<?php

namespace app\index\controller;

use \think\Config;
use \think\Controller;
use \think\Request;
use \think\Db;
use \think\Session;
use \think\Cookie;

class Article extends Controller
{

    //-------------------------------------文章----------------------------------------------
    /*
    * add_index——添加页
    * 关联common：createJianc（生成session）
    */
    public function add_index()
    {
        //生成session用来判断二次提交
        $add_Jianc=createJianc();
        Config::set('default_ajax_return', 'html');
        return $this->fetch('Article/add_index');
    }

    /*
     * list_index——列表页
     * 数据表：my_article（文章表）
     */
    public function list_index()
    {
        //列表页where值
        $get=Request::instance()->get('where');
        if ($get){
            $artl_list_where['artl_isstate']=$get;
        }else{
            $artl_list_where=null;
        }
        //查询文章的列表数据
        $artl_list = Db::name('article')->field('artl_id as id,artl_title as title,artl_isstate as isstate')->where($artl_list_where)->order('artl_addtime desc')->paginate(1,false);

        //模板输出
        $pag_list = $artl_list->render();
        $this->assign('pag_list', $pag_list);
        $this->assign('page', Request::instance()->get('page'));
        $this->assign('artl_list',$artl_list);
        //输出格式
        Config::set('default_ajax_return', 'html');
        return $this->fetch('Article/list');
    }

    //------------------------------------------------文章-添加操作-----------------------------------------
    /*
      * Article_add——文章-添加操作
      * 数据表：my_article（文章表）
      * 基础规则：判断数据、SQL注入、xss注入、图片上传判断,图片宽高
      * 关联common：checkJianc(判断session,防止二次提交也可以防止远程提交)Valid_type（数据验证）
      */
    public function Article_add()
    {
        //接值
        $request = Request::instance();
        //判断是否二次提交和远程提交
        $add_Jianc=$request->post('add_Jianc');
        if(checkJianc($add_Jianc)== false) return json( 'jianc_no');
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
            $arr = 'artl_no';//添加失败
        }else {
            //文章上传信息赋值
            $data = array(
                'artl_title' => $request->post('title', '', 'trim,htmlspecialchars,addslashes'),
                'artl_subheading' => $request->post('subheading', '', 'trim,htmlspecialchars,addslashes'),
                'artl_content' => $request->post('content', '', 'trim,htmlspecialchars,addslashes'),
                'artl_simg' => $simg,
                'artl_himg' => $himg,
                'artl_adduesr' => $request->cookie('my_money_user'),
                'artl_addtime' => time(),
            );
            //验证返回
            $validate = Valid_type('article');
            if (!$validate->check($data)) {
                Session::set('add_Jianc', $add_Jianc);
                return json($validate->getError());
            }
            //sql执行
            $exq = Db::name('article')->insertGetId($data);
            if (!empty($exq)) {

                $arr = 'artl_ok';//添加成功

            } else {
                $arr = 'artl_no';//添加失败
                Session::set('add_Jianc', $add_Jianc);

            }
        }
            return json($arr);
        }

    //-------------------------------------文章----------------------------------------------
    /*
    * artl_index——文章修改页
    * 数据表：my_article（文章表）
    * 关联common：createJianc（生成session） Valid_type（数据验证）
    */
    public function edit_index()
    {
        //生成session用来判断二次提交
        $add_Jianc=createJianc();

        //传值
        $request= Request::instance();

        //where参数，sql语句
        $artl_where['artl_id']=$request->post('id','','trim');
        $edit=Db::name('article')->where($artl_where)->field('artl_id as id,artl_title as title,artl_subheading as subheading,artl_content as content,artl_simg as simg, artl_himg as himg')->find();
        $edit['ht_simg']=action('index/Picture/lok_pi',['type_name' => 'artl_pi_uploads','val'=>$edit['simg']]);
        $edit['ht_himg']=action('index/Picture/lok_pi',['type_name' => 'artl_pi_uploads','val'=>$edit['himg']]);
        //赋值
        $this->assign('edit',$edit);
        $this->assign('type',$request->post('type'));
        $page=$request->post('page','','trim');
        if (empty($page))$page='1';
        $this->assign('page',$page);
        //输出模板
        Config::set('default_ajax_return', 'html');
        return $this->fetch('Article/add_index');
    }
    /*
      * Article_edit——文章-修改操作
      * 数据表：my_article（文章表）
      * 基础规则：判断数据、SQL注入、xss注入、图片上传判断,图片宽高
      * 关联common：checkJianc(判断session,防止二次提交也可以防止远程提交)
      */
    public function Article_edit()
    {
        //接值
        $request = Request::instance();
        //判断是否二次提交和远程提交
        $add_Jianc=$request->post('add_Jianc');
        if(checkJianc($add_Jianc)== false) return json( 'jianc_no');
        // 获取表单上传图片
        $edit_simg=input('edit_simg');
        $edit_himg=input('edit_himg');
        $toutuval=$request->post('toutuval','', 'trim,htmlspecialchars,addslashes');
        $datuval=$request->post('datuval','', 'trim,htmlspecialchars,addslashes');
        if (empty($toutuval)){
            $simg=$edit_simg;
        }else{
            $simg=action('index/Picture/new_pi',['type_name' => $request->post('edit_name','', 'trim,htmlspecialchars,addslashes'),'img_val'=>$toutuval]);
        }
        if (empty($datuval)){
            $himg=$edit_himg;
        }else{
            $himg=action('index/Picture/new_pi',['type_name' => $request->post('edit_name','', 'trim,htmlspecialchars,addslashes'),'img_val'=>$datuval]);
        }
        if ($simg == false and  $himg == false){
            $arr = 'artl_no';//修改失败
        }else {
            //上传信息赋值
            $artl_where['artl_id'] = $request->post('edit_id');
            $data = array(
//            'artl_id' =>$request->post('id','','trim,htmlspecialchars,addslashes'),
                'artl_title' => $request->post('title', '', 'trim,htmlspecialchars,addslashes'),
                'artl_subheading' => $request->post('subheading', '', 'trim,htmlspecialchars,addslashes'),
                'artl_content' => $request->post('content', '', 'trim,htmlspecialchars,addslashes'),
                'artl_simg' => $simg,
                'artl_himg' => $himg,
            );
            //验证返回
            $validate = Valid_type('article');
            if (!$validate->check($data)) {
                Session::set('add_Jianc', $add_Jianc);
                return json($validate->getError());
            }

            $exq = Db::name('article')->where($artl_where)->update($data);
            if ($exq !== false) {
                //新图片上传 删除旧图片
                if (!empty($toutuval)) $del_simg=action('index/Picture/dele_pi',['type_name' => $request->post('edit_name','', 'trim,htmlspecialchars,addslashes'),'img_val'=>$edit_simg]);
                if (!empty($datuval))  $del_himg=action('index/Picture/dele_pi',['type_name' => $request->post('edit_name','', 'trim,htmlspecialchars,addslashes'),'img_val'=>$edit_himg]);
                $arr = 'artl_ok';//修改成功

            } else {
                $arr = 'artl_no';//修改失败
                Session::set('add_Jianc', $add_Jianc);
            }
        }
        return json($arr);
    }
}
