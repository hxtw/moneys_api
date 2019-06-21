<?php
namespace app\index\controller;

use \think\Controller;
use \think\Config;
use \think\Request;
use \think\Db;
use \think\Cookie;

class Index extends Controller
{
    //-------------------------------------主页导航----------------------------------------------
    public function index()
    {
        //取值
        $request = Request::instance();
        $my_money_user=$request->Cookie('my_money_user');
        $my_money_userid=$request->Cookie('my_money_userid');
        $my_money_user_access=$request->Cookie('my_money_user_access');
        $comma_separated = explode(',',$my_money_user_access);

        $this->assign('comma_separated',$comma_separated);
        //判断用户是否登录
        if ($my_money_user and $my_money_userid){
            return $this->fetch('Index/index');
        }else{
            $this->redirect('index/Login/Index');
        }

    }
    //-------------------------------------首页页面----------------------------------------------
    public function home()
    {
        Config::set('default_ajax_return','html');
        return $this->fetch('Index/home');
    }
}
