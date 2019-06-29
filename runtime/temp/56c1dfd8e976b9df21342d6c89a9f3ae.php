<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:86:"D:\phpStudy\PHPTutorial\WWW\My_moneys\public/../application/index\view\Video\list.html";i:1561614279;}*/ ?>
<!--易企秀投稿 记录-->
<div class="container-fluid">
    <h3 class="page-title">提审记录</h3>
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title"></h3>
                </div>
                <div class="panel-body">
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
                                <?php if(is_array($vde_list) || $vde_list instanceof \think\Collection || $vde_list instanceof \think\Paginator): $i = 0; $__LIST__ = $vde_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <tr>
                                <td><?php echo $vo['id']; ?></td>
                                <td><?php echo $vo['title']; ?></td>
                                <td>
                                    <?php switch($vo['isstate']): case "1": ?><span class="label label-warning">待审核</span><?php break; case "2": ?><span class="label label-success">通过</span></td><?php break; case "3": ?><span class="label label-danger">未通过</span><?php break; endswitch; ?>
                                <td class="text-center">
                                    <button type="button" class="btn btn-primary btn-xs" onclick="a_hear('',<?php echo $vo['id']; ?>)">编辑</button>
<!--                                    <button type="button" class="btn btn-info btn-xs" onclick="a_hear('liulan',<?php echo $vo['id']; ?>,<?php echo $page; ?>)">预览</button>-->
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
<script type="text/javascript">
    function whereFrom(where_id) {
        $('#content-load').load( "<?php echo url("Index/Video/list_index"); ?>" + "?where=" + where_id );
    }

    function a_hear(type,id,page) {
        // $('#content-load').load( "<?php echo url("Index/Eqx/edit_index"); ?>" + "?id=" + id );
        var str = "<?php echo url('Index/Video/edit_index'); ?>";
        $("#content-load").load(str, {"id" : id, "type":type,"page":page});
    }
    function liulan(id) {
        $('#content-load').load( "<?php echo url("Index/Video/list_index"); ?>" + "?page=" + id );
    }
</script>