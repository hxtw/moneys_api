<?php
namespace app\moneys_api\controller;

use think\Request;
use think\Db;

class  Moneys extends Base{

    public $datas;

  /*
  * eqx_list——易企秀接口
  * 数据表：my_exq（易企秀表）
  */
     public  function  eqx_list(){
         //1. 接收参数
         $this->datas = $this->params;

         //2.检查参数
//         if (isset($this->datas['limit'])) {
//             $this->datas['limit'] = 10;
//         }
         //3. 查询数据库
         if (!isset($this->datas['isstate'])){
             $where['eqx_isstate']=$this->datas['isstate'];
         }
         $field = 'eqx_id as id,eqx_title as title,eqx_isstate as isstate,eqx_addtime as addtime,number as adduser';
         $join = [['my_user u', 'u.id = a.eqx_adduesr']];
         $res = db('eqx')->alias('a')->field($field)->join($join)->where($where)->limit($this->datas['limit'])->order('eqx_addtime desc')->select();
         if ($res === false) {
             $this->returnMsg(400, '查询失败！');
         } else if (empty($res)) {
             $this->returnMsg(200, '暂无数据！');
         } else {
             //响应数据给客户端
             $return_data['eqx'] = $res;
             $this->returnMsg(200, '查询成功！', $return_data);
         }

     }

    /*
   * article_list——文章接口
   * 数据表：my_article（文章表）
   */
    public  function  article_list(){
        //1. 接收参数
        $this->datas = $this->params;

        //2.检查参数
//        if (isset($this->datas['limit'])) {
//            $this->datas['limit'] = 10;
//        }

        //3. 查询数据库
        if (!isset($this->datas['isstate'])){
            $where['artl_isstate']=$this->datas['isstate'];
        }
        $field = 'artl_id as id,artl_title as title,artl_isstate as isstate,artl_addtime as addtime,number as adduser';
        $join = [['my_user u', 'u.id = a.artl_adduesr']];
        $res = db('article')->alias('a')->field($field)->join($join)->where($where)->limit($this->datas['limit'])->order('artl_addtime desc')->select();
        if ($res === false) {
            $this->returnMsg(400, '查询失败！');
        } else if (empty($res)) {
            $this->returnMsg(200, '暂无数据！');
        } else {
            //响应数据给客户端
            $return_data['article'] = $res;
            $this->returnMsg(200, '查询成功！', $return_data);
        }
    }

    /*
    * video_list——视频接口
    * 数据表：my_video（视频表）
    */
    public  function  video_list(){
        //1. 接收参数
        $this->datas = $this->params;

        //2.检查参数
//        if (isset($this->datas['limit'])) {
//            $this->datas['limit'] = 10;
//        }

        //3. 查询数据库
        if (!isset($this->datas['isstate'])){
            $where['vde_isstate']=$this->datas['isstate'];
        }
        $field = 'vde_id as id,vde_title as title,vde_isstate as isstate,vde_addtime as addtime,number as adduser';
        $join = [['my_user u', 'u.id = a.vde_adduesr']];
        $res = db('video')->alias('a')->field($field)->join($join)->where($where)->limit($this->datas['limit'])->order('vde_addtime desc')->select();
        if ($res === false) {
            $this->returnMsg(400, '查询失败！');
        } else if (empty($res)) {
            $this->returnMsg(200, '暂无数据！');
        } else {
            //响应数据给客户端
            $return_data['video'] = $res;
            $this->returnMsg(200, '查询成功！', $return_data);
        }
    }

    /*
     * dubbing_list——音频接口
     * 数据表：my_video（音频表）
     */
    public  function  dubbing_list(){
        //1. 接收参数
        $this->datas = $this->params;

        //2.检查参数
//        if (isset($this->datas['limit'])) {
//            $this->datas['limit'] = 10;
//        }

        //3. 查询数据库
        if (!isset($this->datas['isstate'])){
            $where['du_isstate']=$this->datas['isstate'];
        }
        $field = 'du_id as id,du_title as title,du_assig_type as assg_type,du_isstate as isstate,du_edittime as edittime,number as assignor';
        $join = [['my_user u', 'u.id = a.du_assignor']];
        $res = db('dubbing')->alias('a')->field($field)->join($join)->where($where)->limit($this->datas['limit'])->order('du_addtime desc')->select();

        if ($res === false) {
            $this->returnMsg(400, '查询失败！');
        } else if (empty($res)) {
            $this->returnMsg(200, '暂无数据！');
        } else {
            //响应数据给客户端
            $return_data['video'] = $res;
            $this->returnMsg(200, '查询成功！', $return_data);
        }

    }
}