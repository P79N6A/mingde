<?php
namespace App\Http\Controllers\Mingde;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\ClassProduct;

class IndexController extends CommonController
{

    /**
     *首页推荐
     */
    public function indexRecommend()
    {

        $pro = DB::table('sch_classproduct as pro')
            ->select('pro.id','pro.title','pro.image1')
            ->leftJoin('sch_classrecommend','sch_classrecommend.number','=','pro.number')
            ->orderBy('pro.sort','desc')
            ->limit(2)
            ->get();
        foreach($pro as $k=>$v){
            $pro[$k]->image1 = config('app.app_configs.loadhost').$v->image1;
        }
        return $this->api_json($pro,200,'成功');
    }
    /**
     *研学推荐
     */
    public function indexYanxueRec()
    {
        $pro = DB::table('sch_classproduct as pro')
            ->select('pro.id','pro.title','pro.image1')
            ->where('is_recommend',0)
            ->orderBy('sort','desc')
            ->limit(6)
            ->get()->toArray();
        foreach ($pro as $k=>$v) {
            $pro[$k]->image1 = config('app.app_configs.loadhost').$v->image1;
        }
        return $this->api_json($pro,200,'成功');
    }

    /**
     *商品详情
     */
    public function indexDetail(Request $request)
    {
        $id = $request->input('id');

        $pro = ClassProduct::select('title','title_fit','price','is_onoff','image1','image2','image3','text_item','text_introduce','text_arrange','fit','day','start_time','city','clothing','gradeup','gradedo','is_pay','is_sign','school')
            ->where('id',$id)->first();
        $grade = DB::table('sch_classgrade')
            ->whereBetween('id', [$pro->gradeup, $pro->gradedo])
            ->get()->toArray();
        foreach($grade as $k=>$v){
            $grades[]=$v->name;
        }
        $pro->grade = $grades;
        $pro->image1 = config('app.app_configs.loadhost').$pro->image1;
        $pro->image2 = config('app.app_configs.loadhost').$pro->image2;
        $pro->image3 = config('app.app_configs.loadhost').$pro->image3;
        $school = explode(',',$pro->school);
        $pro->school = $school;
        return $this->api_json($pro->toarray(),200,'成功');
    }

}