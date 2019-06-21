<?php
  namespace app\moneys_api\controller;

  use think\Controller;
  use think\Request;
  use think\Validate;

  class  Base extends Controller{


      protected $request; //用来处理客户端传递过来的参数
      protected $validater; //用来验证数据/参数
      protected $params; //过滤后符合要求的参数

      //控制器下面方法所要接受参数的
      protected $rules = array(
          'Moneys' => array(
              'eqx_list' => array(
                  'isstate' => ['number'],
                  'limit' => ['number'],
                  ),
              'article_list' => array(
                  'isstate' => ['number'],
                  'limit' => ['number'],
                  ),
              'video_list' => array(
                  'isstate' => ['number'],
                  'limit' => ['number'],
                  ),
              'dubbing_list' => array(
                  'isstate' => ['number'],
                  'limit' => ['number'],
              )
          )
      );

      /**
       * [构造方法]
       * @return [type] [description]
       */
      protected  function  _initialize()
      {
          parent::_initialize();
      //解决跨域--析构方法
      header('content-type:text/html;charset=utf-8');
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
      header('Access-Control-Allow-Methods: GET, POST, PUT');
      ksort($_POST);
      ksort($_GET);
         $this->request = Request::instance();

          //1. 检车请求时间是否超时
//         $this->check_time($this->request->only(['time']));

          //2. 验证token
//         $this->check_token($this->request->param());

          //3. 验证参数,返回成功过滤后的参数数组
          $this->params = $this->checkParams($this->request->param(true));
      }

      //检测请求的时间是否超时
      public  function  check_time($arr){
          //$this->returnMsg(400, '请求超时!');
          if (!isset($arr['time']) || intval($arr['time']) <= 1) {
              $this->returnMsg(400, '时间戳不存在!');
          }
          if (time() - intval($arr['time']) > 10) {
              $this->returnMsg(400, '请求超时!');
          }
      }

      //返回信息
      public function returnMsg($code,$msg='',$data=[]){
        /******** 组合数组 **********/
        $return_data['code']=$code;
        $return_data['msg']=$msg;
        $return_data['data']=$data;

        /******** 返回信息并终止 **********/
        echo json_encode($return_data);die;
      }

      //验证token方法 (防止篡改数据)
      /*
      $arr: 全部请求参数
      return : json
       */
      public function check_token($arr){
          if (!isset($arr['token']) || empty($arr['token'])){
              $this->returnMsg(400,'token不能为空');
          }
          //api传过来的token
          $api_token=$arr['token'];

          /******** 服务器生产token **********/

          //如果已经传递token数据，就删除token数据，生成服务端token与客户端的token做对比
          unset($arr['token']);
          $service_token='';
          foreach ($arr as $key => $value){
              $service_token .=md5($value);
          }

          $service_token = md5('money_'.$service_token.'moneys_'); //服务器生产的token
          /******** 比较token ，返回结果**********/
          if ($api_token !== $service_token){
              $this->returnMsg(400,'token不正确');
          }
      }

      //检测客户端传递过来的其他参数（用户名，其他相关）
      /*
      param: $arr [除了time,token以外的其他参数]
      return:     [合格的参数数组]
       */
      protected function checkParams($arr)
      {

          //1.获取验证规则 (Array)
          $rule = $this->rules[$this->request->controller()][$this->request->action()];

          //2. 验证参数并且返回错误
          $this->validater = new Validate($rule);

          if (!$this->validater->check($arr)) {
              $this->returnMsg(400, $this->validater->getError());
          }

          //3. 如果正常，就通过验证

          return $arr;
      }
  }