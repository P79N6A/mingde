<?php
namespace App\Http\Controllers\Mingde;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Mingde\CommonController as Common;
use App\AppSignIn;
use App\AppMessageIs;
use Illuminate\Support\Facades\Storage;

class UserController extends Common
{
    /**
     *获取用户信息
     */
   public function getUserInfo()
   {

   }
    /**
     *获取openid
     * 2018-9-19
     * by chenyu
     */
    public function getOpenid(Request $request)
    {
        $code = $request->input('code');
        $c = config('app');
        $xcx = $c['xcx'];
        $URL = "https://api.weixin.qq.com/sns/jscode2session?appid=".$xcx['appid']."&secret=".$xcx['AppSecret']."&js_code=".$code."&grant_type=authorization_code";
        $result = file_get_contents($URL);
        $result = json_decode($result,true);

        $user_info = DB::table('sch_user')
            ->select('id','uid','info_k')
            ->where('openid',$result['openid'])
            ->first();
        if(!empty($user_info)){//存在
            $token = md5($result['openid'] . time() . "yxx");
            DB::table('xcx_user')->where('id',$user_info->id)->update(['token'=>$token]);
            if($user_info->uid==-1){
                return $this->api_json(['token'=>$token,'key'=>$result['session_key'],'info_k'=>$user_info->info_k,'uid'=>-1],'200','');
            }else{
                return $this->api_json(['token'=>$token,'key'=>$result['session_key'],'info_k'=>$user_info->info_k,'uid'=>$user_info->uid],'200','');
            }
        }else{//需同步 已有用户

            $token = md5($result['openid'] . time() . "yxx");
            $xcx_data['openid'] = $result['openid'];
            $xcx_data['sessionkey'] = $result['session_key'];
            $xcx_data['create_time'] = date('Y-m-d H:i:s',time());
            $xcx_data['token'] = $token;
            $bool=DB::table('xcx_user')
                ->insert($xcx_data);
            if($bool){
                return $this->api_json(['token'=>$token,'key'=>$result['session_key'],'info_k'=>1,'uid'=>-1],'200','');
            }else{

            }
        }
    }

}