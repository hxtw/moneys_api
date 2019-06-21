<?php

namespace app\index\controller;

use \think\Config;
use \think\Controller;
use think\Error;
use \think\Request;
use \think\Db;
use \think\Session;
use \think\Cookie;

class Video extends Controller
{

    //-------------------------------------视频----------------------------------------------
    /*
    * add_index——添加页
    * 关联common：createJianc（生成session）
    */
    public function add_index()
    {
        //生成session用来判断二次提交
        $add_Jianc=createJianc();
        Config::set('default_ajax_return', 'html');
        return $this->fetch('Video/add_index');
    }
    /*
    * list_index——列表页
    * 数据表：my_video（易企秀表）
    */
    public function list_index()
    {
        //列表页where值
        $get=Request::instance()->get('where');
        if ($get){
            $vde_list_where['vde_isstate']=$get;
        }else{
            $vde_list_where=null;
        }
        //查询易企秀的列表数据
        $vde_list = Db::name('video')->field('vde_id as id,vde_title as title,vde_isstate as isstate')->where($vde_list_where)->order('vde_addtime desc')->paginate(10,false);
        //模板输出
        $pag_list = $vde_list->render();
        $this->assign('pag_list', $pag_list);
        $this->assign('page', Request::instance()->get('page'));
        $this->assign('vde_list',$vde_list);
        //输出格式
        Config::set('default_ajax_return', 'html');
        return $this->fetch('Video/list');
    }
    /*
    * add_viadd——视频添加操作
    * 关联common：createJianc（生成session）
    */
   public function  add_viadd()
   {

        if (Session::get('add_Jianc') == Session::get('video_add_id')){
            //判断是否存在
            $filename = Session::get('video_add_vi');
            if(file_exists($filename)){
                @unlink($filename);
            }
        }else{
            Session::clear('video_add_id');
            Session::clear('video_add_vi');
        }

       // 获取视频信息
       $file = request()->file('file1');
       if (!$file ) return json($arr = array('code'=>'401','parameter'=>''));
       //上传视频信息
       $info = $file->validate(['ext' => 'AVI,mov,rm,FLV,mp4,3GP'])->move(ROOT_PATH . 'public' . DS . 'video_vi_uploads');
       //判断是否成功
       if ($info) {
           // 成功上传后 获取上传信息
           $video = $info->getSaveName();
           $arr = array('code'=>'402','parameter'=>$video);
           Session::set('video_add_id', Session::get('add_Jianc'));
           Session::set('video_add_vi', "../public/video_vi_uploads/".$video);
       }else{
           $arr = array('code'=>'403','parameter'=>'');
       }

       return json($arr);
   }
    /*
     * add_videl——视频删除操作
     *
     */
    public function  add_videl()
    {
        //接值
        $aer=Request::instance()->post('value', '', 'trim,htmlspecialchars,addslashes');

        //判断是否存在
        $filename = "../public/video_vi_uploads/".$aer;
        if(file_exists($filename)){
            @unlink($filename);
            $arr = array('code'=>'502','parameter'=>'');
        } else {
            $arr = array('code'=>'503','parameter'=>'');
        }

        return json($arr);
    }
    //------------------------------------------------视频-添加操作-----------------------------------------
    /*
      * Video_add——视频-添加操作
      * 数据表：my_video（视频表）
      * 基础规则：判断数据、SQL注入、xss注入、图片上传判断,图片宽高
      * 关联common：checkJianc(判断session,防止二次提交也可以防止远程提交)Valid_type（数据验证）
      */
    public function Video_add()
    {
        //传值
        $request=Request::instance();
        //判断是否二次提交和远程提交
        $add_Jianc=$request->post('add_Jianc');
        if(checkJianc($add_Jianc)== false) return json( 'jianc_no');
        //接值
        $request = Request::instance();
        //判断视频是否提交
        $video=$request->post('vidvalue', '', 'trim,htmlspecialchars,addslashes');
        if (empty($video)){
            Session::set('add_Jianc', $add_Jianc);
            return json( 'vid_no');
        }
        // 获取上传图片
        $simg=$request->post('toutuval', '', 'trim,htmlspecialchars,addslashes');
        $himg=$request->post('datuval', '', 'trim,htmlspecialchars,addslashes');
        if (empty($simg)){
            Session::set('add_Jianc', $add_Jianc);
            return    json( 'toutu_no');
        }
        if (empty($himg)){
            Session::set('add_Jianc', $add_Jianc);
            return   json( 'datu_no');
        }
        $simg=action('index/Picture/new_pi',['type_name' => $request->post('edit_name','', 'trim,htmlspecialchars,addslashes'),'img_val'=>$simg]);
        $himg=action('index/Picture/new_pi',['type_name' => $request->post('edit_name','', 'trim,htmlspecialchars,addslashes'),'img_val'=>$himg]);
        if ($simg == false and  $himg == false){
            $arr = 'vde_no';//添加失败
        }else {
            //视频上传信息赋值
            $data = array(
                'vde_title' => $request->post('title', '', 'trim,htmlspecialchars,addslashes'),
                'vde_subheading' => $request->post('subheading', '', 'trim,htmlspecialchars,addslashes'),
                'vde_video' => str_replace("\\\\", "/", $video),
                'vde_simg' => $simg,
                'vde_himg' => $himg,
                'vde_adduesr' => $request->cookie('my_money_user'),
                'vde_addtime' => time(),
            );
            //验证返回
            $validate = Valid_type('video');
            if (!$validate->check($data)) {
                Session::set('add_Jianc', $add_Jianc);
                return json($validate->getError());
            }
            //sql执行
            $exq = Db::name('video')->insertGetId($data);
            if (!empty($exq)) {
                $arr = 'vde_ok';//添加成功

            } else {
                $arr = 'vde_no';//添加失败
                Session::set('add_Jianc', $add_Jianc);
            }
        }
        return json($arr);
    }
    //-------------------------------------视频----------------------------------------------
    /*
    * edit_index——修改页
    * 数据表：my_video（视频表）
    * 关联common：createJianc（生成session）
    */
    public function edit_index()
    {
        //生成session用来判断二次提交
        $add_Jianc=createJianc();

        //传值
        $request= Request::instance();

        //where参数，sql语句
        $vdo_where['vde_id']=$request->post('id','','trim');
        $edit=Db::name('video')->where($vdo_where)->field('vde_id as id,vde_title as title,vde_subheading as subheading,vde_simg as simg,vde_himg as himg,vde_video as video')->find();
        $edit['ht_simg']=action('index/Picture/lok_pi',['type_name' => 'video_pi_uploads','val'=>$edit['simg']]);
        $edit['ht_himg']=action('index/Picture/lok_pi',['type_name' => 'video_pi_uploads','val'=>$edit['himg']]);
        //赋值
        $this->assign('edit',$edit);
        $this->assign('type',$request->post('type'));
        $page=$request->post('page','','trim');
        if (empty($page))$page='1';
        $this->assign('page',$page);
        //输出模板
        Config::set('default_ajax_return', 'html');
        return $this->fetch('Video/add_index');
    }

    /*
     * video_edit——文章-修改操作
     * 数据表：my_video（视频表）
     * 基础规则：判断数据、SQL注入、xss注入、图片上传判断,图片宽高
     * 关联common：checkJianc(判断session,防止二次提交也可以防止远程提交)Valid_type（数据验证）
     */
    public function video_edit()
    {
        //接值
        $request = Request::instance();
        //判断是否二次提交和远程提交
        $add_Jianc=$request->post('add_Jianc');
        if(checkJianc($add_Jianc)== false) return json( 'jianc_no');
        //判断图片、视频是否提交
        $edit_simg=input('edit_simg');
        $edit_himg=input('edit_himg');
        $edit_video=input('edit_video');
        $toutuval=$request->post('toutuval','', 'trim,htmlspecialchars,addslashes');
        $datuval=$request->post('datuval','', 'trim,htmlspecialchars,addslashes');
        $vidvalue=$request->post('vidvalue','', 'trim,htmlspecialchars,addslashes');
        if (empty($toutuval)){ //判断是否上传新头图，赋值
            $simg=$edit_simg;
        }else{
            $simg=action('index/Picture/new_pi',['type_name' => $request->post('edit_name','', 'trim,htmlspecialchars,addslashes'),'img_val'=>$toutuval]);
        }
        if (empty($datuval)){//判断是否上传新大图，赋值
            $himg=$edit_himg;
        }else{
            $himg=action('index/Picture/new_pi',['type_name' => $request->post('edit_name','', 'trim,htmlspecialchars,addslashes'),'img_val'=>$datuval]);
        }
        if (empty($vidvalue)){//判断是否上传新视频，赋值
            $video=$edit_video;
        }else{
            $video=str_replace("\\\\","/",$vidvalue);
        }
        if ($simg == false and  $himg == false){
            $arr = 'vde_no';//修改失败
        }else {
            //上传信息赋值
            $vde_where['vde_id'] = $request->post('edit_id');
            $data = array(
//            'vde_id' =>$request->post('id','','trim,htmlspecialchars,addslashes'),
                'vde_title' => $request->post('title', '', 'trim,htmlspecialchars,addslashes'),
                'vde_subheading' => $request->post('subheading', '', 'trim,htmlspecialchars,addslashes'),
                'vde_video' => $video,
                'vde_simg' => $simg,
                'vde_himg' => $himg,
            );
            //验证返回
            $validate = Valid_type('video');
            if (!$validate->check($data)) {
                Session::set('add_Jianc', $add_Jianc);
                return json($validate->getError());
            }
            $vde = Db::name('video')->where($vde_where)->update($data);
            if ($vde !== false) {
                //新图片、视频上传 删除旧图片、旧视频
                if (!empty($toutuval)) $del_simg=action('index/Picture/dele_pi',['type_name' => $request->post('edit_name','', 'trim,htmlspecialchars,addslashes'),'img_val'=>$edit_simg]);
                if (!empty($datuval))  $del_himg=action('index/Picture/dele_pi',['type_name' => $request->post('edit_name','', 'trim,htmlspecialchars,addslashes'),'img_val'=>$edit_himg]);
                if (!empty($vidvalue)) @unlink('../public/' . $request->post('edit_name_video', '', 'trim,htmlspecialchars,addslashes') . '/' . $edit_video);
                $arr = 'vde_ok';//修改成功

            } else {
                $arr = 'vde_no';//修改失败
                Session::set('add_Jianc', $add_Jianc);
            }
        }
        return json($arr);
    }
}
