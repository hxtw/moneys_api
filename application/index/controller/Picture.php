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
//    public function  add_pi()
//    {
//        $val = Request::instance()->post('val');
//        //判断是否第二次添加图片
//        if (Session::get('add_Jianc') == Session::get('video_add_id')){
//            //判断添加图片的类型
//            if($val == Session::get('video_add_type')){
//                //判断是否存在
//                $filename = Session::get('video_add_pitoutu');
//                if(file_exists($filename)){
//                    @unlink($filename);
//                }
//            }else{
//                Session::clear('video_add_id');
//                Session::clear('video_add_pitoutu');
//            }
//        }else{
//            Session::clear('video_add_id');
//            Session::clear('video_add_pitoutu');
//        }
//        //取图片的参数
//        $type = Request::instance()->post('type');
//        //匹配是头图 还是 大图
//        switch ($val)
//        {
//            case 'toutu'://头图
//                $pic = Request::instance()->file('pic1');
//                if (is_image($pic,320,480) == false) return json(array('code'=>'403','parameter'=>'头图尺寸不对'));
//                break;
//            case 'datu'://大图
//                $pic = Request::instance()->file('pic2');
//                if (is_image($pic,900,383) == false) return json( array('code'=>'403','parameter'=>'大图尺寸不对'));
//                break;
//            default:
//        }
//        //上传操作
//        $info = $pic->validate(['ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS .$type);
//        if ($info) {
//            // 成功上传后 获取上传信息
//            $simg = $info->getSaveName();
//            $arr = array('code'=>'402','parameter'=>$simg);
//            Session::set('video_add_id', Session::get('add_Jianc'));
//            Session::set('video_add_pitoutu', "../public/".$type.'/'.$simg);
//            switch ($val)
//            {
//                case 'toutu'://头图
//                    Session::set('video_add_type', 'toutu');
//                    break;
//                case 'datu'://大图
//                    Session::set('video_add_type', 'datu');
//                    break;
//                default:
//            }
//        }else{
//            $arr = array('code'=>'403','parameter'=>'');
//
//        }
//        return json($arr);
//    }
    public function  add_pi(){
        $val = Request::instance()->post('val');
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
        //阿里Oss的图片上传
        $ossClient = new_oss();

        $bucket= "my-moneys";//oss中的文件上传空间
        $resResult = end(explode('.',$pic->getInfo()['name']));//想要保存文件的格式
        $file = $pic->getInfo()['tmp_name'];//文件路径，必须是本地的。
            // 设置规则ID和文件前缀。
            $ruleId1 = "rule1";
            $matchPrefix1 = "A1/";
            $lifecycleConfig = new LifecycleConfig();
            $actions = array();
//             指定日期之前创建的文件过期。
            $actions[] = new LifecycleAction(OssClient::OSS_LIFECYCLE_EXPIRATION, OssClient::OSS_LIFECYCLE_TIMING_DAYS, 1);
            $lifecycleRule = new LifecycleRule($ruleId1, $matchPrefix1, "Enabled", $actions);
            $lifecycleConfig->addRule($lifecycleRule);
        try {

            $fileName =$matchPrefix1.sha1(date('YmdHis', time()) . uniqid()).rand(1,99). '.' .$resResult;//想要保存文件的名称
            //执行阿里云上传
            $ossClient->putBucketLifecycle($bucket, $lifecycleConfig);
            $ossClient->uploadFile($bucket, $fileName, $file);

            //上传成功之后的值
                $arr = array('code'=>'402','parameter'=>$fileName);
                Session::set('video_add_id', Session::get('add_Jianc'));
                Session::set('video_add_pitoutu', $fileName);
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
        } catch (OssException $e) {
            $arr = array('code'=>'403','parameter'=>'');
//            printf(__FUNCTION__ . ": FAILED\n");
//            print $e->getMessage();
        }
        return json($arr);

    }
    /*
         * del_pi——图片删除操作
         *
         */
    public function  del_pi()
    {
//        $type = Request::instance()->post('type');
               //接值
        $aer=Request::instance()->post('value', '', 'trim,htmlspecialchars,addslashes');

        $bucket= "my-moneys";//oss中的文件上传空间
        $object = $aer;
        $ossClient = new_oss();//Oss引用

        try{
            $ossClient->deleteObject($bucket, $object);
            $arr = array('code'=>'502','parameter'=>'');
        } catch(OssException $e) {
//            printf(__FUNCTION__ . ": FAILED\n");
//            printf($e->getMessage() . "\n");
            $arr = array('code'=>'503','parameter'=>'');
        }
        return json($arr);

    }

    /*
     * new_pi——将临时文件变为正式文件
     *
     */
    public function  new_pi($type_name,$img_val)
    {
        //oss中的文件上传空间
        $from_bucket = "my-moneys";
        $to_bucket = $from_bucket;
        //图片
        $img_from_object = $img_val;
        $imgto_object = date('Ymd', time()).'/'.end(explode('/',$img_from_object));

        $ossClient = new_oss();
        try{
            $ossClient->copyObject($from_bucket, $img_from_object, $to_bucket,  $type_name.'/'.$imgto_object);
            $are=$imgto_object;
            return $are;
        } catch(OssException $e) {
//            printf(__FUNCTION__ . ": FAILED\n");
//            printf($e->getMessage() . "\n");
            return false;
        }

    }

    public function lok_pi($type_name,$val){
        // 设置URL的有效期为24小时。
        $timeout = 86400;
        $bucket= "my-moneys";//oss中的文件上传空间
        $object = $val;
        try {
            $ossClient = new_oss();

            // 生成GetObject的签名URL。
            $signedUrl = $ossClient->signUrl($bucket, $type_name.'/'.$object, $timeout);
        } catch (OssException $e) {
            printf(__FUNCTION__ . ": FAILED\n");
            printf($e->getMessage() . "\n");
            return;
        }
            return $signedUrl;
    }

    public function dele_pi($type_name,$img_val){

        $bucket= "my-moneys";//oss中的文件上传空间
        $object=$type_name.'/'.$img_val;
        try{
            $ossClient = new_oss();

            $ossClient->deleteObject($bucket, $object);
        } catch(OssException $e) {
            printf(__FUNCTION__ . ": FAILED\n");
            printf($e->getMessage() . "\n");
            return;
        }
    }
}

