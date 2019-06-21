<?php

namespace app\index\controller;

use think\Config;
use \think\Controller;
use \think\Request;
use \think\Db;
use \think\Cookie;
use \think\helper\Time;

class Statistics extends Controller
{
    //-------------------------------------登录页面----------------------------------------------
    //登录
    public function Index()
    {
        //取用户权限和信息
        $my_money_user_access=Request::instance()->Cookie('my_money_user_access');
        $my_money_user=Request::instance()->Cookie('my_money_user');
        $comma_separated = explode(',',$my_money_user_access);
        //取得查询日期的规则
        $tyoe= Request::instance()->get('type');
        switch ($tyoe){
            case 'day'://每天查询
                $riqi=get_day(); //一个月每天的日期，作为循环判断
                $date="d";// 判断日期的月-日条件
                list($start) = Time::month(); //取这个月第一天开始的时间戳
                $end = time();//当前时间戳
              //取树状图X轴的单位
//                $days = date("d");
//                $m=array();
//                for($i=1;$i<=$days;$i++){
//                    $m[]=$i;
//                }
                $ssum="'".implode("号','",$riqi)."号'";
                $b_ssum=$riqi;
                //取树状图Y轴的单位
                $max=20;
                $interval=2;
                //取表格的显示文字
                $count['name']='每天';
                break;
            case 'month':
                $j = date("Y");
                $date="Y-m";
                $riqi=array(1=>$j.'-'.'01',$j.'-'.'02',$j.'-'.'03',$j.'-'.'04',$j.'-'.'05',$j.'-'.'06',$j.'-'.'07',$j.'-'.'08',$j.'-'.'09',$j.'-'.'10',$j.'-'.'11',$j.'-'.'12');
                list($start) = Time::year();
                $end = time();
                $ssum="'1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'";
                $b_ssum=array('1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月');
                $max=200;
                $interval=50;
                $count['name']='每月';
                break;
            case 'year':
                $riqi=get_year();
                $date="Y";
                $start =strtotime($riqi[1].'-01-01');
                $end = time();
                $ssum="'".implode("年','",$riqi)."年'";
                $b_ssum=$riqi;
                $max=1000;
                $interval=100;
                $count['name']='每年';
                break;
            default:
                $riqi=get_weeks();
                $date="m-d";
                list($start, $end) = Time::dayToNow(6);
                $ssum="'".implode("号','",get_weekss())."号'";
                $b_ssum=$riqi;
                $max=20;
                $interval=2;
                $count['name']='最近七天';
                break;

        }
        //计算出发表的数量,定义参数
        if (in_array('Eqx',$comma_separated)) {
            $eqx = array();//易企秀
            $eqx_val=Db::name('eqx') ->where('eqx_addtime > '.$start)->where('eqx_addtime <'.$end)->where('eqx_adduesr ='.$my_money_user)->field('eqx_id as id ,eqx_addtime as date')->select();
            $count['eqx']=count($eqx_val); //计算总数量
        }
        if (in_array('Article',$comma_separated)) {
            $article = array();//文章
            $article_val=Db::name('article') ->where('artl_addtime > '.$start)->where('artl_addtime <'.$end)->where('artl_adduesr ='.$my_money_user)->field('artl_id as id ,artl_addtime as date')->select();
            $count['article']=count($article_val);

        }
        if (in_array('Video',$comma_separated)) {
            $video = array();//视频
            $video_val=Db::name('video') ->where('vde_addtime > '.$start)->where('vde_addtime <'.$end)->where('vde_adduesr ='.$my_money_user)->field('vde_id as id ,vde_addtime as date')->select();
            $count['video']=count($video_val);

        }
        if (in_array('Dubbing',$comma_separated)) {
            $dubbing = array();//音频
            $dubbing_val=Db::name('dubbing') ->where('du_edittime > '.$start)->where('du_edittime <'.$end)->where('du_adduesr ='.$my_money_user)->field('du_id as id ,du_edittime as date')->select();
            $count['dubbing']=count($dubbing_val);

        }
        // 统计数量
        foreach ($riqi as $item =>$val){
            //易企秀
            if (in_array('Eqx',$comma_separated)){
                foreach ($eqx_val as $keys){
                    $keysvalue=date($date,$keys['date']);
                    if ($val == $keysvalue){
                        $eqx[$item] +=1;
                    }else{
                        $eqx[$item] +=0;
                    }
                }
            }
            //文章
            if (in_array('Article',$comma_separated)){
                foreach ($article_val as $keys){
                    $keysvalue=date($date,$keys['date']);
                    if ($val == $keysvalue){
                        $article[$item] +=1;
                    }else{
                        $article[$item] +=0;
                    }
                }

            }
            //视频
            if (in_array('Video',$comma_separated)){
                foreach ($video_val as $keys){
                    $keysvalue=date($date,$keys['date']);
                    if ($val == $keysvalue){
                        $video[$item] +=1;
                    }else{
                        $video[$item] +=0;
                    }
                }
            }
            //音频
            if (in_array('Dubbing',$comma_separated)){
                foreach ($dubbing_val as $keys){
                    $keysvalue=date($date,$keys['date']);
                    if ($val == $keysvalue){
                        $dubbing[$item] +=1;
                    }else{
                        $dubbing[$item] +=0;
                    }
                }
            }
        }

        //输出模板
        $this->assign('comma_separated',$comma_separated); //权限
        $this->assign('eqx',implode(',',$eqx));   //易企秀数据
        $this->assign('article',implode(',',$article)); //文章数据
        $this->assign('video',implode(',',$video)); //视频数据
        $this->assign('dubbing',implode(',',$dubbing)); //音频数据
        $this->assign('ssum',$ssum); //x轴的单位
        $this->assign('b_ssum',$b_ssum); //x轴的单位
        $this->assign('max',$max); //Y轴的最大值
        $this->assign('interval',$interval); //Y轴的显示值
        $this->assign('count',$count); // 表单的数据

        Config::set('default_ajax_return', 'html');
        return $this->fetch('Statistics/index');
    }

    public function table_index()
    {
        //取用户权限和信息
        $my_money_user_access=Request::instance()->Cookie('my_money_user_access');
        $my_money_user=Request::instance()->Cookie('my_money_user');
        $comma_separated = explode(',',$my_money_user_access);
        //取得查询日期的规则
        $tyoe= Request::instance()->get('type');
        switch ($tyoe){
            case 'day'://每天查询
                $riqi=get_day(); //一个月每天的日期，作为循环判断
                $date="d";// 判断日期的月-日条件
                list($start) = Time::month(); //取这个月第一天开始的时间戳
                $end = time();//当前时间戳
                $ssum="'".implode("号','",$riqi)."号'";
                $b_ssum=$riqi;
                //取表格的显示文字
                $count['name']='每天';
                break;
            case 'month':
                $j = date("Y");
                $date="Y-m";
                $riqi=array(1=>$j.'-'.'01',$j.'-'.'02',$j.'-'.'03',$j.'-'.'04',$j.'-'.'05',$j.'-'.'06',$j.'-'.'07',$j.'-'.'08',$j.'-'.'09',$j.'-'.'10',$j.'-'.'11',$j.'-'.'12');
                list($start) = Time::year();
                $end = time();
                $ssum="'1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'";
                $b_ssum=array('1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月');
                $count['name']='每月';
                break;
            case 'year':
                $riqi=get_year();
                $date="Y";
                $start =strtotime($riqi[1].'-01-01');
                $end = time();
                $ssum="'".implode("年','",$riqi)."年'";
                $b_ssum=$riqi;
                $count['name']='每年';
                break;
            default:
                $riqi=get_weeks();
                $date="m-d";
                list($start, $end) = Time::dayToNow(6);
                $ssum="'".implode("号','",get_weekss())."号'";
                $b_ssum=$riqi;
                $count['name']='最近七天';
                break;

        }
        //计算出发表的数量,定义参数
        if (in_array('Eqx',$comma_separated)) {
            $eqx = array();//易企秀
            $eqx_val=Db::name('eqx') ->where('eqx_addtime > '.$start)->where('eqx_addtime <'.$end)->where('eqx_adduesr ='.$my_money_user)->field('eqx_id as id ,eqx_addtime as date')->select();
            $count['eqx']=count($eqx_val); //计算总数量
        }
        if (in_array('Article',$comma_separated)) {
            $article = array();//文章
            $article_val=Db::name('article') ->where('artl_addtime > '.$start)->where('artl_addtime <'.$end)->where('artl_adduesr ='.$my_money_user)->field('artl_id as id ,artl_addtime as date')->select();
            $count['article']=count($article_val);

        }
        if (in_array('Video',$comma_separated)) {
            $video = array();//视频
            $video_val=Db::name('video') ->where('vde_addtime > '.$start)->where('vde_addtime <'.$end)->where('vde_adduesr ='.$my_money_user)->field('vde_id as id ,vde_addtime as date')->select();
            $count['video']=count($video_val);

        }
        if (in_array('Dubbing',$comma_separated)) {
            $dubbing = array();//音频
            $dubbing_val=Db::name('dubbing') ->where('du_edittime > '.$start)->where('du_edittime <'.$end)->where('du_adduesr ='.$my_money_user)->field('du_id as id ,du_edittime as date')->select();
            $count['dubbing']=count($dubbing_val);

        }
        // 统计数量
        foreach ($riqi as $item =>$val){
            //易企秀
            if (in_array('Eqx',$comma_separated)){
                foreach ($eqx_val as $keys){
                    $keysvalue=date($date,$keys['date']);
                    if ($val == $keysvalue){
                        $eqx[$item] +=1;
                    }else{
                        $eqx[$item] +=0;
                    }
                }
            }
            //文章
            if (in_array('Article',$comma_separated)){
                foreach ($article_val as $keys){
                    $keysvalue=date($date,$keys['date']);
                    if ($val == $keysvalue){
                        $article[$item] +=1;
                    }else{
                        $article[$item] +=0;
                    }
                }

            }
            //视频
            if (in_array('Video',$comma_separated)){
                foreach ($video_val as $keys){
                    $keysvalue=date($date,$keys['date']);
                    if ($val == $keysvalue){
                        $video[$item] +=1;
                    }else{
                        $video[$item] +=0;
                    }
                }
            }
            //音频
            if (in_array('Dubbing',$comma_separated)){
                foreach ($dubbing_val as $keys){
                    $keysvalue=date($date,$keys['date']);
                    if ($val == $keysvalue){
                        $dubbing[$item] +=1;
                    }else{
                        $dubbing[$item] +=0;
                    }
                }
            }
        }

        //输出模板
        $this->assign('comma_separated',$comma_separated); //权限
        $this->assign('b_eqx',$eqx);   //易企秀数据_表格
        $this->assign('b_article',$article); //文章数据_表格
        $this->assign('b_video',$video); //视频数据_表格
        $this->assign('b_dubbing',$dubbing); //音频数据_表格
        $this->assign('ssum',$ssum); //x轴的单位
        $this->assign('b_ssum',$b_ssum); //x轴的单位
        $this->assign('count',$count); // 表单的数据

        Config::set('default_ajax_return', 'html');
        return $this->fetch('Statistics/table_index');
    }
}