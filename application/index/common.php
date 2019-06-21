<?php
use \think\Session;
use think\Validate;
use OSS\OssClient;
use OSS\Core\OssException;

/*手机号验证*/
function phone_ya($p){
    if(preg_match("/1[3456789]{1}\d{9}$/",$p)){

        $m='ok';
    }else{

        $m='no';
    }
    return $m;
}

//创建二次提交
function createJianc() {
    $code = chr(mt_rand(0xB0, 0xF7)) . chr(mt_rand(0xA1, 0xFE)) .       chr(mt_rand(0xB0, 0xF7)) . chr(mt_rand(0xA1, 0xFE)) . chr(mt_rand(0xB0, 0xF7)) . chr(mt_rand(0xA1, 0xFE));
    Session::set('add_Jianc', authcode($code));
}
//判断TOKEN
function checkJianc($token) {
    if ($token == Session::get('add_Jianc') and $token !== NULL and Session::get('add_Jianc') !== NULL) {
        Session::clear('add_Jianc');
        return true;
    } else {
        return false;
    }
}
/* 加密TOKEN */
function authcode($str) {
    $key = "YOURKEY";
    $str = substr(md5($str), 8, 10);
    return md5($key . $str);
}

/* 判断图片是否符合规定 */
function is_image($img,$width,$height){
    //取图片宽高
    $are=Image_Size($img);
    //判断
    if ($are[0] == $width and $are[1] == $height){
        return true;
    }else{
        return false;
    }
}

/* 获取image 宽高 */
function Image_Size($arr){
    //图片宽高
    $image = \think\Image::open($arr);

    // 返回图片的宽度
    $width = $image->width();
    // 返回图片的高度
    $height = $image->height();

    $info_image=array($width,$height);
    return $info_image;
}

/* 取前七天的日期 */
function get_weeks($time = '', $format='m-d'){
    $time = $time != '' ? $time : time();
    //组合数据
    $date = [];
    for ($i=1; $i<=7; $i++){
        $date[$i] = date($format ,strtotime( '+' . $i-7 .' days', $time));
    }
    return $date;
}
/* 取前七天的日期 */
function get_weekss($time = '', $format='d'){
    $time = $time != '' ? $time : time();
    //组合数据
    $date = [];
    for ($i=1; $i<=7; $i++){
        $date[$i] = date($format ,strtotime( '+' . $i-7 .' days', $time));
    }
    return $date;
}
/* 取前一个月每天的日期 */
function get_day($time = '', $format='m-d'){
    $j = date("t"); //获取当前月份天数
    $start_time = strtotime(date('Y-m-01'));  //获取本月第一天时间戳
    $array = array();
    for($i=0;$i<$j;$i++){
        $array[] = date('d',$start_time+$i*86400); //每隔一天赋值给数组
    }

    return $array;
}

/* 取往年的日期 */
function get_year($time = '', $format='Y'){
    $time = $time != '' ? $time : time();
    //组合数据
    $date = [];
    for ($i=1; $i<=7; $i++){
        $date[$i] = date($format ,strtotime( '+' . $i-7 .' year', $time));
    }
    return $date;
}

/*验证判断返回的值*/
function Valid_type($val){
    switch ($val){
        case 'eqx'://易企秀
            $validate = new Validate([
                'eqx_title'  => 'require|chsDash',
                'eqx_subheading'  => 'require|chsDash',
                'eqx_url'  => 'require|url',
                'eqx_industry'  => 'require',
                'eqx_type'  => 'require',
                'eqx_code'  => 'require|alphaNum',
                'eqx_eqxid'  => 'require|alphaNum',
                'eqx_publishtime'  => 'require|number',
            ],
                [
                    'eqx_title.require' => '标题不能为空',
                    'eqx_subheading.require' => '副标题不能为空',
                    'eqx_url.require' => 'URL不能为空',
                    'eqx_industry.require' => '行业不能为空',
                    'eqx_type.require' => '类型不能为空',
                    'eqx_eqxid.require' => 'id不能为空',
                    'eqx_code.require' => '行业不能为空',
                    'eqx_publishtime.require' => 'PublishTime不能为空',
                    'eqx_title.chsDash' => '标题只能是汉字、字母、数字和下划线_及破折号-',
                    'eqx_subheading.chsDash' => '副标题只能是汉字、字母、数字和下划线_及破折号-',
                    'eqx_url.url' => 'URL格式不对',
                    'eqx_code.alphaNum' => 'code格式不对',
                    'eqx_eqxid.alphaNum' => 'id格式不对',
                    'eqx_publishtime.number' => 'PublishTime格式不对',

                ]);
            break;
        case 'article'://文章
            $validate = new Validate([
                'artl_title'  => 'require|chsDash',
                'artl_subheading'  => 'require|chsDash',
                'artl_content'  => 'require|chsDash',
            ],
                [
                    'artl_title.require' => '标题不能为空',
                    'artl_subheading.require' => '副标题不能为空',
                    'artl_content.require' => '内容不能为空',
                    'artl_title.chsDash' => '标题只能是汉字、字母、数字和下划线_及破折号-',
                    'artl_subheading.chsDash' => '副标题只能是汉字、字母、数字和下划线_及破折号-',
                    'artl_content.chsDash' => '内容只能是汉字、字母、数字和下划线_及破折号-',
                ]);
            break;
        case 'video'://视频
            $validate = new Validate([
                'vde_title'  => 'require|chsDash',
                'vde_subheading'  => 'require|chsDash',
            ],
                [
                    'vde_title.require' => '标题不能为空',
                    'vde_subheading.require' => '副标题不能为空',
                    'vde_title.chsDash' => '标题只能是汉字、字母、数字和下划线_及破折号-',
                    'vde_subheading.chsDash' => '副标题只能是汉字、字母、数字和下划线_及破折号-',
                ]);
            break;
        case 'dubbing'://音频
            $validate = new Validate([
                'du_title'  => 'require|chsDash',
            ],
                [
                    'du_title.require' => '标题不能为空',
                    'du_title.chsDash' => '标题只能是汉字、字母、数字和下划线_及破折号-',
                ]);
            break;
        default:
            $validate = false;

    }
    return $validate;
}
/**
 * 实例化阿里云OSS
 * @return object 实例化得到的对象
 * @return 此步作为共用对象，可提供给多个模块统一调用
 */
function new_oss(){
    //获取配置项，并赋值给对象$config
    $config=config('aliyun_oss');
    //实例化OSS
    $oss=new \OSS\OssClient($config['KeyId'],$config['KeySecret'],$config['Endpoint']);
    return $oss;
}
