<?php
namespace app\index\controller;

use AliyunVodUploader;
use Exception;
use think\Controller;
use \think\Request;
use think\Db;
use think\Loader;
use UploadVideoRequest;
use vod\Request\V20170321\CreateUploadVideoRequest;
use vod\Request\V20170321\RefreshUploadVideoRequest;
use vod\Request\V20170321\GetPlayInfoRequest;
use vod\Request\V20170321\GetVideoPlayAuthRequest;


include EXTEND_PATH."aliyun-php-sdk/aliyun-php-sdk-core/Config.php";
include EXTEND_PATH."aliyun-php-sdk/uploader/AliyunVodUploader.php";
include EXTEND_PATH."aliyun-php-sdk/uploader/UploadVideoRequest.php";

class Vadd extends Controller
{

    private $accessKeyId = 'LTAI9MGtugZckrQP';   //阿里云 accessKeyId
    private $accessKeySecret = 'Z9jwckHB8mY7QxovfhMT0uojEQUX7K'; //阿里云 accessKeySecret
    private $regionId = 'cn-shanghai';   //表示中国区域 不用修改
    private $TemplateGroupId = 'VOD_NO_TRANSCODE';  //阿里云控制台视频点播>全局设置->转码设置  转码组id


    function initVodClient()
    {
        include EXTEND_PATH . "aliyun-php-sdk/aliyun-php-sdk-core/Profile/DefaultProfile.php";
        include EXTEND_PATH . "aliyun-php-sdk/aliyun-php-sdk-core/DefaultAcsClient.php";

        $profile = \DefaultProfile::getProfile($this->regionId, $this->accessKeyId, $this->accessKeySecret);
        return new \DefaultAcsClient($profile);
    }

    //获取上传地址(uploadAddress) 上传凭证(uploadAuth)  视频(videoId)
    function createUploadVideo()
    {

//        try {
//            include EXTEND_PATH . "aliyun-php-sdk/aliyun-php-sdk-vod/vod/Request/V20170321/CreateUploadVideoRequest.php";
//
//            $client = $this->initVodClient();
//            $file = request()->file('file1');
//            $filee=$file->getInfo();
//
//            echo'<br>';
//            $request = new CreateUploadVideoRequest($filee['tmp_name']);
//
//            $request->setTitle("Sample Title");
//            $request->setFileName($filee['name']);
//            $request->setDescription("Video Description");
//            $request->setCoverURL("http://img.alicdn.com/tps/TB1qnJ1PVXXXXXCXXXXXXXXXXXX-700-700.png");
//            $request->setTags("tag1,tag2");
//            $request->setTemplateGroupId($this->TemplateGroupId);
//            $request->setAcceptFormat('JSON');
//
//            $aa = $client->getAcsResponse($request);
//            $auth['UploadAddress'] = $aa->UploadAddress;
//            $auth['RequestId'] = $aa->RequestId;
//            $auth['VideoId'] = $aa->VideoId;
//            $auth['UploadAuth'] = $aa->UploadAuth;
////            $this->ajaxReturn(array('status' => '0', 'data' => $auth));
//        } catch (Exception $e) {
//            print $e->getMessage() . "\n";
//        }
            $accessKeyId = 'LTAI9MGtugZckrQP';   //阿里云 accessKeyId
            $accessKeySecret = 'Z9jwckHB8mY7QxovfhMT0uojEQUX7K'; //阿里云 accessKeySecret
            $file = request()->file('file1');
//            $filee=$file->getInfo();
            var_dump($file);
//            var_dump($filee);
            $info = $file->validate(['ext' => 'AVI,mov,rm,FLV,mp4,3GP'])->move(ROOT_PATH . 'public' . DS . 'video_vi_uploads');
             $video = $info->getSaveName();
             var_dump($video);
        try {
            $uploader = new AliyunVodUploader($accessKeyId, $accessKeySecret);
            $uploadVideoRequest = new UploadVideoRequest("../public/video_vi_uploads/".$video, 'testUploadLocalVideo via PHP-SDK');
            //$uploadVideoRequest->setCateId(1);
            //$uploadVideoRequest->setCoverURL("http://xxxx.jpg");
            //$uploadVideoRequest->setTags('test1,test2');
            //$uploadVideoRequest->setStorageLocation('outin-xx.oss-cn-beijing.aliyuncs.com');
            //$uploadVideoRequest->setTemplateGroupId('6ae347b0140181ad371d197ebe289326');
            $userData = array(
                "MessageCallback"=>array("CallbackURL"=>"https://demo.sample.com/ProcessMessageCallback"),
                "Extend"=>array("localId"=>"xxx", "test"=>"www")
            );
            $uploadVideoRequest->setUserData(json_encode($userData));
            $res = $uploader->uploadLocalVideo($uploadVideoRequest);
            print_r($res);
        } catch (Exception $e) {
            printf("testUploadLocalVideo Failed, ErrorMessage: %s\n Location: %s %s\n Trace: %s\n",
                $e->getMessage(), $e->getFile(), $e->getLine(), $e->getTraceAsString());
        }
//        try {
//            $client = $this->initVodClient();
//            $uploadInfo = createUploadVideo($client);
//            var_dump($uploadInfo);
//        } catch (Exception $e) {
//            print $e->getMessage()."\n";
//        }
    }

    //刷新视频上传凭证
    function refreshUploadVideo()
    {
        try {
            $client = $this->initVodClient();
            $request = new RefreshUploadVideoRequest();
            $request->setVideoId('47324be263014946b4846704444cc0fc');
            $request->setAcceptFormat('JSON');
            dump($client->getAcsResponse($request));

        } catch (Exception $e) {
            print $e->getMessage() . "\n";
        }

    }


    //获取播放地址
    function getPlayInfo($videoId)
    {
        try {
            $client = $this->initVodClient();
            $request = new GetPlayInfoRequest();

            $request->setVideoId($videoId);
            $request->setAuthTimeout(3600 * 24);
            $request->setAcceptFormat('JSON');
            $playInfo = $client->getAcsResponse($request);


            //dump($playInfo->PlayInfoList->PlayInfo);
            return $playInfo;
        } catch (Exception $e) {
            print $e->getMessage() . "\n";
        }

    }

    //获取播放凭证
    function getPlayAuth()
    {
        try {
            $client = $this->initVodClient();
            $request = new GetVideoPlayAuthRequest();
            $request->setVideoId('47324be263014946b4846704444cc0fc');
            $request->setAuthInfoTimeout(3600);
            $request->setAcceptFormat('JSON');
            $playInfo = $client->getAcsResponse($request);


            // print($playInfo->PlayAuth."\n");
            // print_r($playInfo->VideoMeta);
            return $playInfo->VideoMeta;
        } catch (Exception $e) {
            print $e->getMessage() . "\n";
        }


    }


    //上传图片视频成功回调
    function notify()
    {

        $str = file_get_contents('php://input');


        if ($notify->VideoId) {

            $info = $this->getPlayInfo($notify->VideoId);

            $playurl = $info->PlayInfoList->PlayInfo[1]->PlayURL;

            $datainfo = [
                'video_id' => $notify->VideoId,
                'url' => $playurl,

                'create_time' => date('Y-m-d H:i:s', time())
            ];
            Db::name('aliyun_video')->insert($datainfo);

        }

    }


    //上传成功之后前端轮训获取视频url
    public function getVideoUrl()
    {
        $param = Request::instance()->param();
        if ($param['videoid']) {
            $where['video_id'] = $param['videoid'];

            $url = Db::name('aliyun_video')->where($where)->value('url');
            if (!empty($url)) {
                $this->ajaxReturn(array('status' => '0', 'data' => $url));
            } else {
                $this->ajaxReturn(array('status' => '1', 'data' => '未查到相关数据'));
            }
        } else {
            $this->ajaxReturn(array('status' => '1', 'data' => '未查到相关数据'));
        }

    }

}