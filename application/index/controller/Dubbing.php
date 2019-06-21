<?php

namespace app\index\controller;

use \think\Config;
use \think\Controller;
use think\Error;
use \think\Request;
use \think\Db;
use \think\Session;
use \think\Cookie;

class Dubbing extends Controller
{

    //-------------------------------------配音----------------------------------------------
    /*
    * add_index——添加页
    * 关联common：createJianc（生成session）
    */
//    public function add_index()
//    {
//        //生成session用来判断二次提交
//        $add_Jianc=createJianc();
//        Config::set('default_ajax_return', 'html');
//        return $this->fetch('Dubbing/add_index');
//    }
    /*
    * list_order——来单了页面
    * 数据表：my_dubbing（配音表）
    */
    public function list_order()
    {

        //查询音频的列表数据
        $where['du_assig_type']=1;
        $du_list = Db::name('dubbing')->field('du_id as id,du_title as title,du_addtime as addtime')->order('du_addtime desc')->where($where)->paginate(10,false);

        //模板输出
        $pag_list = $du_list->render();
        $this->assign('pag_list', $pag_list);
        $this->assign('page', Request::instance()->get('page'));
        $this->assign('du_list',$du_list);
        //输出格式
        Config::set('default_ajax_return', 'html');
        return $this->fetch('Dubbing/list_order');
    }
    /*
    * list_index——列表页
    * 数据表：my_dubbing（配音表）
    */
    public function list_index()
    {
        //列表页where值
        $get=Request::instance()->get('where');
        if ($get){
            $du_list_where['du_isstate']=$get;
        }else{
            $du_list_where=null;
        }
        //查询易企秀的列表数据
        $where['du_assig_type']=2;
        $du_list = Db::name('dubbing')->field('du_id as id,du_title as title,du_isstate as isstate')->where($du_list_where)->order('du_edittime desc')->where($where)->paginate(10,false);
        //模板输出
        $pag_list = $du_list->render();
        $this->assign('pag_list', $pag_list);
        $this->assign('page', Request::instance()->get('page'));
        $this->assign('du_list',$du_list);
        //输出格式
        Config::set('default_ajax_return', 'html');
        return $this->fetch('Dubbing/list');
    }
    /*
    * add_viadd——配音添加操作
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

       // 获取配音信息
       $file = request()->file('file1');
       if (!$file ) return json($arr = array('code'=>'401','parameter'=>''));
       //上传配音信息
       $info = $file->validate(['ext' => 'mp3'])->move(ROOT_PATH . 'public' . DS . 'dubbing_vi_uploads');
       //判断是否成功
       if ($info) {
           // 成功上传后 获取上传信息
           $video = $info->getSaveName();
           $arr = array('code'=>'402','parameter'=>$video);
           Session::set('video_add_id', Session::get('add_Jianc'));
           Session::set('video_add_vi', "../public/dubbing_vi_uploads/".$video);
       }else{
           $arr = array('code'=>'403','parameter'=>'');
       }

       return json($arr);
   }
    /*
     * add_videl——配音删除操作
     *
     */
    public function  add_videl()
    {
        //接值
        $aer=Request::instance()->post('value', '', 'trim,htmlspecialchars,addslashes');

        //判断是否存在
        $filename = "../public/dubbing_vi_uploads/".$aer;
        if(file_exists($filename)){
            @unlink($filename);
            $arr = array('code'=>'502','parameter'=>'');
        } else {
            $arr = array('code'=>'503','parameter'=>'');
        }

        return json($arr);
    }
    //------------------------------------------------配音-添加操作-----------------------------------------
    /*
      * Dubbing_add——配音-添加操作
      * 数据表：my_dubbing（配音表）
      * 基础规则：判断数据、SQL注入、xss注入、图片上传判断,图片宽高
      * 关联common：checkJianc(判断session,防止二次提交也可以防止远程提交)Valid_type（数据验证）
      */
//    public function Dubbing_add()
//    {
//        //传值
//        $request=Request::instance();
//        //判断是否二次提交和远程提交
//        $add_Jianc=$request->post('add_Jianc');
//        if(checkJianc($add_Jianc)== false) return json( 'jianc_no');
//        //接值
//        $request = Request::instance();
//        //判断配音是否提交
//        $video=$request->post('vidvalue', '', 'trim,htmlspecialchars,addslashes');
//        if (empty($video)){
//            Session::set('add_Jianc', $add_Jianc);
//            return json( 'vid_no');
//        }
//        //配音上传信息赋值
//        $data = array(
//            'du_title' => $request->post('title', '', 'htmlspecialchars,addslashes,strip_tags,trim'),
//            'du_video' => str_replace("\\\\","/",$video),
//            'du_adduesr' => $request->cookie('my_money_user'),
//            'du_addtime' => time(),
//        );
//        //验证返回
//        $validate = Valid_type('dubbing');
//        if (!$validate->check($data)){
//            Session::set('add_Jianc', $add_Jianc);
//            return  json( $validate->getError());
//        }
//        //sql执行
//        $dub = Db::name('dubbing')->insertGetId($data);
//        if (!empty($dub)) {
//            $arr = 'dub_ok';//添加成功
//
//        } else {
//            $arr = 'dub_no';//添加失败
//            Session::set('add_Jianc', $add_Jianc);
//        }
//
//        return json($arr);
//    }
    //-------------------------------------配音----------------------------------------------
    /*
    * edit_index——修改页
    * 数据表：my_dubbing（配音表）
    * 关联common：createJianc（生成session）
    */
    public function edit_index()
    {
        //生成session用来判断二次提交
        $add_Jianc=createJianc();

        //传值
        $request= Request::instance();

        //where参数，sql语句
        $du_where['du_id']=$request->post('id','','trim');
        $edit=Db::name('dubbing')->where($du_where)->field('du_id as id,du_title as title,du_video as video,du_content as content')->find();

        //赋值
        $this->assign('edit',$edit);
        $this->assign('type',$request->post('type'));
        $page=$request->post('page','','trim');
        if (empty($page))$page='1';
        $this->assign('page',$page);
        //输出模板
        Config::set('default_ajax_return', 'html');
        return $this->fetch('Dubbing/add_index');
    }

    /*
     * video_edit——文章-修改操作
     * 数据表：my_video（配音表）
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
        //判断图片、配音是否提交
        $edit_video=input('edit_video');
        $vidvalue=$request->post('vidvalue','', 'trim,htmlspecialchars,addslashes');
        if (empty($vidvalue)){//判断是否上传新配音，赋值
            $video=$edit_video;
        }else{
            $video=str_replace("\\\\","/",$vidvalue);
        }
        //上传信息赋值
        $du_where['du_id']=$request->post('edit_id');
        $data = array(
//            'du_id' =>$request->post('id','','trim,htmlspecialchars,addslashes'),
            'du_title' => $request->post('title', '', 'trim,htmlspecialchars,addslashes'),
            'du_video' => $video,
            'du_assig_type' => 2,
            'du_edittime' =>time(),
        );
        //验证返回
        $validate = Valid_type('dubbing');
        if (!$validate->check($data)){
            Session::set('add_Jianc', $add_Jianc);
            return  json( $validate->getError());
        }

        $du = Db::name('dubbing')->where($du_where)->update($data);
        if ($du  !==   false ) {
            //新图片、配音上传 删除旧图片、旧配音
            if (!empty($vidvalue))   @unlink('../public/'.$request->post('edit_name_video','', 'trim,htmlspecialchars,addslashes').'/'.$edit_video);
            $arr = 'dub_ok';//修改成功

        } else {
            $arr = 'dub_no';//修改失败
            Session::set('add_Jianc', $add_Jianc);
        }
        return json($arr);
    }
}
