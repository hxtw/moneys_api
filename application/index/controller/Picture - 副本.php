<?php

namespace app\index\controller;

use \think\Config;
use \think\Controller;
use think\Error;
use \think\Request;
use \think\Db;
use \think\Session;
use \think\Cookie;
use \think\image;
use OSS\OssClient;
use OSS\Core\OssException;
use OSS\Model\LifecycleConfig;
use OSS\Model\LifecycleRule;
use OSS\Model\LifecycleAction;

class Picture extends Controller
{
    /*
    * add_pi——图片添加操作
    * 关联common：is_image（判断图片是否符合规则）
    */
    public function  add_pi()
    {
        $val = Request::instance()->post('val');
        //判断是否第二次添加图片
        if (Session::get('add_Jianc') == Session::get('video_add_id')){
            //判断添加图片的类型
            if($val == Session::get('video_add_type')){
                //判断是否存在
                $filename = Session::get('video_add_pitoutu');
                if(file_exists($filename)){
                    @unlink($filename);
                }
            }else{
                Session::clear('video_add_id');
                Session::clear('video_add_pitoutu');
            }
        }else{
            Session::clear('video_add_id');
            Session::clear('video_add_pitoutu');
        }
        //取图片的参数
        $type = Request::instance()->post('type');
        //匹配是头图 还是 大图
        switch ($val)
        {
            case 'toutu'://头图
                $pic = Request::instance()->file('pic1');
                if (is_image($pic,320,480) == false) return json(array('code'=>'403','parameter'=>'头图尺寸不对'));
                break;
            case 'datu'://大图
                $pic = Request::instance()->file('pic2');
                if (is_image($pic,900,383) == false) return json( array('code'=>'403','parameter'=>'大图尺寸不对'));
                break;
            default:
        }
        //上传操作
        $info = $pic->validate(['ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS .$type);
        if ($info) {
            // 成功上传后 获取上传信息
            $simg = $info->getSaveName();
            $arr = array('code'=>'402','parameter'=>$simg);
            Session::set('video_add_id', Session::get('add_Jianc'));
            Session::set('video_add_pitoutu', "../public/".$type.'/'.$simg);
            switch ($val)
            {
                case 'toutu'://头图
                    Session::set('video_add_type', 'toutu');
                    break;
                case 'datu'://大图
                    Session::set('video_add_type', 'datu');
                    break;
                default:
            }
        }else{
            $arr = array('code'=>'403','parameter'=>'');

        }
        return json($arr);
    }
    /*
         * del_pi——图片删除操作
         *
         */
    public function  del_pi()
    {
        $type = Request::instance()->post('type');
        //接值
        $aer=Request::instance()->post('value', '', 'trim,htmlspecialchars,addslashes');
        //判断是否存在
        $filename = "../public/".$type."/".$aer;
        if(file_exists($filename)){
            @unlink($filename);
            $arr = array('code'=>'502','parameter'=>'');
        } else {
            $arr = array('code'=>'503','parameter'=>'');
        }

        return json($arr);
    }

}
