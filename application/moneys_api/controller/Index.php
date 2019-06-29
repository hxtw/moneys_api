<?php
namespace app\moneys_api\controller;

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
        $time=time();
        echo"api.th2324.com/eqx/".$time.'/'.md5('money_'.md5($time).'moneys_');
//        echo 'moneys_api/index111';
    }
}

