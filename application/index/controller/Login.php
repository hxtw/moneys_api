<?php

namespace app\index\controller;

use \think\Controller;
use \think\Request;
use \think\Db;
use \think\Cookie;

class Login extends Controller
{
    //-------------------------------------登录页面----------------------------------------------
    //登录
    public function Index()
    {
        return $this->fetch('Login/login');
    }

//------------------------------------------------登录操作-----------------------------------------
    /*
      * my_money——登录操作
      * 数据表：my_user（账号表）
      * 基础规则：判断手机号是否正确、判断账号密码是否存在、账号是否通过审核
      * 关联common：phone_ya（手机号验证）
      */
    public function login_phone()
    {
        //接值
        $number = Request::instance()->post('number','','trim,htmlspecialchars,addslashes');
        $password = Request::instance()->post('password','','trim,htmlspecialchars,addslashes');

        //判断是否为手机号
        if(phone_ya($number) == 'ok'){
            //判断手机号是否存在
            $number_where['u.number'] = $number;
            $number_user = Db::name('user')->alias('u')->join('user_access a','u.id=a.uid','left')->where($number_where)->find();

            if (!empty($number_user)) {
                //判断账号 密码是否正确
                if($number_user['number']==$number and $number_user['password']==md5($password)){
                    if ($number_user['isstatus'] == 2) {
                        $arr = 'user_Close';//账号被关闭
                    }else{
                        Cookie::set('my_money_userid', $number_user['id']);
                        Cookie::set('my_money_user', $number);
                        Cookie::set('my_money_user_access', $number_user['group_id']);
                        $arr = 'user_ok';//账号密码正确
                    }
                }else{
                    $arr = 'user_no';//账号密码错误
                }
            } else {
                $arr = 'number_no';//账号不存在
            }
        }else{
            $arr = 'phone_no';//手机号错误
        }
        return json($arr);
    }
}
