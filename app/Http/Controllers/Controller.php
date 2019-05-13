<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     *�����ȡ����
     * by chenyu
     * 2019-1-10
     * lat ����
     * lng ά��
     **/
    public function apiMapGeocoder($lat,$lng)
    {
        $ak = config('app.app_configs.mapAk');
        $url = config('app.app_configs.mapUrl');
        $location = $lng.','.$lat;
        $path = $url.'ak='.$ak.'&callback=renderReverse&location='.$location.'&output=json&pois=1';

        $map = file_get_contents($path);
        echo $map;exit;
        $stripos=stripos($map,'{');
        $strrpos=strrpos($map,'}')-2;
        $maps = mb_substr($map,$stripos,$strrpos);
        echo $maps;exit;
        $res = json_decode($maps,true);
        if($res['status'] ==0){
            $data['addr'] = $res['formatted_address'];
            $data['province'] = $res['addressComponent']['province'];
            $data['city'] = $res['addressComponent']['city'];
            $data['district'] = $res['addressComponent']['district'];
            return $data;
        }else{
            return false;
        }
    }

    /**
     * ��ȡ��Ա����¼ �ܺ�
     *
     */
    public function getTestsrecordCount($uids)
    {
        $cout = DB::table('app_testsrecord')
            ->whereIn('id',$uids)
            ->where('is_del',0)
            ->get();
        if(count($cout->toArray())>0){
            return $cout->toArray();
        }else{
            return false;
        }
    }


}
