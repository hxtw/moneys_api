<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:88:"D:\phpStudy\PHPTutorial\WWW\My_moneys\public/../application/index\view\Article\list.html";i:1561711932;}*/ ?>
<!--视频 记录-->
<div class="container-fluid">
    <h3 class="page-title">提审记录</h3>
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title"></h3>
                </div>
                <div class="panel-body">
                    <div>
                        <div class='col-sm-2'>
                            <div class="form-group">
                                <!--指定 date标记-->
                                <div class='input-group date' >
                                    <input type='text' readonly  id="startTime"  class="form-control laydate" name="starttime" />
                                </div>
                            </div>
                        </div>
                        <div class='col-sm-2'>
                            <div class="form-group">
                                <!--指定 date标记-->
                                <div class='input-group date'>
                                    <input type='text'  readonly id="endTime"  class="form-control laydate" name="endtime" />
                                </div>
                            </div>
                        </div>
                    <div class="input-group margin-bottom-30"  style="width: 500px; height: 20px;margin-left: 30%;">
                        <input class="form-control" type="text" placeholder="标题">
                        <span class="input-group-btn"><button class="btn btn-primary " type="button">查询</button></span>
                    </div>
                    <div class="margin-bottom-30">
                        <button type="button" class="btn btn-danger" onclick="whereFrom(3)">未通过</button>
                        <button type="button" class="btn btn-warning" onclick="whereFrom(1)">待审核</button>
                        <button type="button" class="btn btn-success" onclick="whereFrom(2)">审核通过</button>
                    </div>
                    <div class="clearfix"></div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>标题</th>
                                <th>状态</th>
                                <th class="text-center">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php if(is_array($artl_list) || $artl_list instanceof \think\Collection || $artl_list instanceof \think\Paginator): $i = 0; $__LIST__ = $artl_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <tr>
                                <td><?php echo $vo['id']; ?></td>
                                <td><?php echo $vo['title']; ?></td>
                                <td>
                                    <?php switch($vo['isstate']): case "1": ?><span class="lab el label-warning">待审核</span><?php break; case "2": ?><span class="label label-success">通过</span></td><?php break; case "3": ?><span class="label label-danger">未通过</span><?php break; endswitch; ?>
                                 <td class="text-center">
                                    <button type="button" class="btn btn-primary btn-xs" onclick="a_hear('',<?php echo $vo['id']; ?>)">编辑</button>
<!--                                    <button type="button" class="btn btn-info btn-xs"  onclick="a_hear('liulan',<?php echo $vo['id']; ?>,<?php echo $page; ?>)">预览</button>-->
                                </td>
                            </tr>
                                <?php endforeach; endif; else: echo "" ;endif; ?>

                        </tbody>
                    </table>
                    <?php echo $pag_list; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function whereFrom(where_id) {
        $('#content-load').load( "<?php echo url("Index/Article/list_index"); ?>" + "?where=" + where_id );
    }
    function a_hear(type,id,page) {
        // $('#content-load').load( "<?php echo url("Index/Eqx/edit_index"); ?>" + "?id=" + id );
        var str = "<?php echo url('Index/Article/edit_index'); ?>";
        $("#content-load").load(str, {"id" : id, "type":type,"page":page});
    }
    function liulan(id) {
        $('#content-load').load( "<?php echo url("Index/Article/list_index"); ?>" + "?page=" + id );
    }
</script>
<script>
    //日期
    var nowTime=new Date();
    var startTime=laydate.render({
        elem:'#startTime',
        type:'date',
        btns: ['confirm'],
        max:'nowTime',//默认最大值为当前日期
        done:function(value,date){
//    		console.log(value); //得到日期生成的值，如：2017-08-18
//    	    console.log(date); //得到日期时间对象：{year: 2017, month: 8, date: 18, hours: 0, minutes: 0, seconds: 0}
            endTime.config.min={
                year:date.year,
                month:date.month-1,//关键
                date:date.date,
                hours:date.hours,
                minutes:date.minutes,
                seconds:date.seconds
            };

        }
    })
    var endTime=laydate.render({
        elem:'#endTime',
        type:'date',
        btns: ['confirm'],
        max:'nowTime',
        done:function(value,date){
//    		console.log(value); //得到日期生成的值，如：2017-08-18
//    	    console.log(date); //得到日期时间对象：{year: 2017, month: 8, date: 18, hours: 0, minutes: 0, seconds: 0}
            startTime.config.max={
                year:date.year,
                month:date.month-1,//关键
                date:date.date,
                hours:date.hours,
                minutes:date.minutes,
                seconds:date.seconds
            }

        }
    })

    //重置
    $("#btn-resert").on("click",function(){
        $("#sch-form")[0].reset();
        endTime.config.min='1900-1-1';
        startTime.config.max=endTime.config.max;
    })
</script>