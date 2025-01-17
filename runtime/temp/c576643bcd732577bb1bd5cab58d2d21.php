<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:91:"D:\phpStudy\PHPTutorial\WWW\My_moneys\public/../application/index\view\Video\add_index.html";i:1561599577;}*/ ?>
<!--视频投稿-->
<div class="container-fluid">
    <h3 class="page-title">视频投稿</h3>
    <div class="row">
        <?php if(empty($edit['id']) || (($edit['id'] instanceof \think\Collection || $edit['id'] instanceof \think\Paginator ) && $edit['id']->isEmpty())): ?>
        <div class="col-md-8">
        <?php else: ?>
        <div class="col-md-6">
        <?php endif; ?>
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title"></h3>
                </div>
                <form class="form-auth-small" id="form-video-add" enctype="multipart/form-data">
<!--                    防止二次提交的token-->
                    <input type="hidden" name="add_Jianc" value="<?php echo session('add_Jianc'); ?>" />
                    <input type="hidden" name="edit_id" value="<?php echo $edit['id']; ?>" />
                    <input type="hidden" name="edit_name" id="edit_name" value="video_pi_uploads" />
                    <input type="hidden" name="edit_simg" id="edit_simg" value="<?php echo $edit['simg']; ?>" />
                    <input type="hidden" name="ht_simg" id="ht_simg" value="<?php echo $edit['ht_simg']; ?>" />
                    <input type="hidden" name="edit_himg" id="edit_himg" value="<?php echo $edit['himg']; ?>" />
                    <input type="hidden" name="ht_himg" id="ht_himg" value="<?php echo $edit['ht_himg']; ?>" />
                    <input type="hidden" name="edit_video" id="edit_video" value="<?php echo $edit['video']; ?>" />
                    <input type="hidden" name="edit_name_video"  id="edit_name_video"  value="video_vi_uploads" />
                    <div class="panel-body" id="uploadForm" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="" class="control-label sr-only">标题</label>
                            <input type="text" class="form-control input-lg liulan" value="<?php echo $edit['title']; ?>" id="title" placeholder="标题" name="title" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label sr-only">副标题</label>
                            <input type="text" class="form-control input-lg liulan" value="<?php echo $edit['subheading']; ?>" id="subheading" placeholder="副标题" name="subheading" autocomplete="off">
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-4">
<!--                                头图上传-->
                                <div class="form-group">
                                    <input id="file-b" class="file liulan" type="file"   name="pic1"  accept="image/*">
                                </div>
                                <input type="hidden" name="toutuval" id="toutu_val">
                            </div>
                            <div class="col-lg-8">
<!--                                大图上传-->
                                <div class="form-group">
                                    <input id="file-c" class="file liulan" type="file"   name="pic2"  accept="image/*">
                                </div>
                                <input type="hidden" name="datuval" id="datu_val">
                            </div>
                        </div>
                        <div class="form-group">
                            <input id="file-0a" class="file liulan" type="file"   name="file1"  accept="video/*">
                        </div>
                        <input type="hidden" name="vidvalue" id="ziyuan_id">
                    </div>
                </form>
                <div class="panel-footer">
                    <div class="row">
                        <?php if($type == liulan): ?>
                        <div class="col-md-2" style="margin-left: 37%;">
                            <button type="button" class="btn btn-success btn-block btn-lg" onclick="list_index(<?php echo $page; ?>)" >返回</button>
                        </div>
                        <?php else: if(empty($edit['id']) || (($edit['id'] instanceof \think\Collection || $edit['id'] instanceof \think\Paginator ) && $edit['id']->isEmpty())): ?>
                          <div class="col-md-2" style="margin-left: 37%;">
                            <button type="button" class="btn btn-primary btn-block btn-lg" onclick="Panduan('tianjia')">提交审核</button>
                           </div>
                            <?php else: ?>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-success btn-block btn-lg" onclick="list_index(<?php echo $page; ?>)" >返回</button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-primary btn-block btn-lg" onclick="Panduan('xiugai')">修改</button>
                            </div>
                            <?php endif; endif; ?>
                    </div>
                </div>
            </div>
        </div>
            <?php if(empty($edit['id']) || (($edit['id'] instanceof \think\Collection || $edit['id'] instanceof \think\Paginator ) && $edit['id']->isEmpty())): else: ?>
            <div class="col-md-6">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title"></h3>
                    </div>
                    <form class="form-auth-small"  enctype="multipart/form-data">
                        <div class="panel-body" >
                            <div class="form-group">
                                <label for="" class="control-label sr-only">标题</label>
                                <input type="text" class="form-control input-lg liulan" value="<?php echo $edit['title']; ?>"  placeholder="标题"  autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label sr-only">副标题</label>
                                <input type="text" class="form-control input-lg liulan" value="<?php echo $edit['subheading']; ?>"  placeholder="副标题"  autocomplete="off">
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <!--                                头图上传-->
                                    <div class="form-group">
                                        <input id="file-bb" class="file liulan" type="file" disabled="true" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <!--                                大图上传-->
                                    <div class="form-group">
                                        <input id="file-cc" class="file liulan" type="file"disabled="true" accept="image/*">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input id="file-0aa" class="file liulan" type="file" disabled="true" accept="video/*">
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <?php endif; ?>
    </div>
    <input type="hidden" id="liuan_type" value="<?php echo $type; ?>">
</div>
<script type="text/javascript">
    //返回列表
    function list_index(page) {
        $('#content-load').load( "<?php echo url("Index/Video/list_index"); ?>" + "?page=" + page);
    }
</script>
<!--头图/大图 ————上传、删除 ————操作-->
<script src="/static/video_file/js/My_moneys_picture.js" type="text/javascript"></script>
<script src="/static/video_file/js/My_moneys_picturesee.js" type="text/javascript"></script>
    <script>
    // 提交格式判断
    function Panduan(type) {
        if($("#title").val() == ''){
            layer.msg("标题不能为空！", {icon: 5,time:2500});
            return false;
        }
        if($("#subheading").val() == ''){
            layer.msg("副标题不能为空！", {icon: 5,time:2500});
            return false;
        }

        if (type == 'xiugai'){
            if($("#edit_simg").val() == ''){
                layer.msg("头图不能为空！", {icon: 5,time:2500});
                return false;
            }
            if($("#edit_himg").val() == ''){
                layer.msg("大图不能为空！", {icon: 5,time:2500});
                return false;
            }
            if($("#edit_video").val() == ''){
                layer.msg("视频不能为空！", {icon: 5,time:2500});
                return false;
            }
            editFrom();
        }else if (type == 'tianjia') {
            if($("#toutu_val").val() == ''){
                layer.msg("头图不能为空！", {icon: 5,time:2500});
                return false;
            }
            if($("#datu_val").val() == ''){
                layer.msg("大图不能为空！", {icon: 5,time:2500});
                return false;
            }
            if($("#ziyuan_id").val() == ''){
                layer.msg("视频不能为空！", {icon: 5,time:2500});
                return false;
            }
            updateFrom();
        }

    }
    var edit_name=$("#edit_name_video").val();
    var e_video=$("#edit_video").val();
    if (e_video) {
        var liulan_v="__IMG__/"+edit_name+"/"+e_video;
    }else {
        var liulan_v= "";
    }
/*    视频上传功能 -配置        */
    $("#file-0a").fileinput({
        dropZoneTitle : "请上传视频！", //标题
        uploadUrl : "<?php echo url('index/Vadd/createUploadVideo'); ?>", //上传地址
        language : "zh",//语言
        showCaption : false,//上传名称隐藏
        showUpload : true,//上传按键取消
        overwriteInitial : false, //是否要覆盖初始预览内容和标题设置
        showUploadedThumbs : false, //显示上传缩略图
        maxFileCount : 1, //最大上传文件
        minFileCount : 1, //最小上传文件
        maxFileSize : 153600,//文件最大153600kb=150M
        initialPreviewShowDelete : true, //缩略图显示删除按钮
        showRemove : true,//是否显示删除按钮
        showClose : false,//是否显示预览界面的关闭图标
        autoReplace : true, //是否自动替换预览中的文件
        enctype: 'multipart/form-data',//提交的编码
        validateInitialCount:true,//验证minfilecount和maxfilecount时是否包括初始预览文件计数
        layoutTemplates : {
            actionDelete:'', //去除上传预览的缩略图中的删除图标
            actionUpload:'',//去除上传预览缩略图中的上传图片；
            actionZoom:'',   //去除上传预览缩略图中的查看详情预览的缩略图标。
            },
        allowedFileExtensions : [ "mp4","avi","dat","3gp","mov","rmvb"],//上传格式
        previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",//当检测到用于预览的不可读文件类型时，在每个预览文件缩略图中显示的图标。
        initialPreviewAsData:true,//开启默认预览功能
        initialPreview: liulan_v,//预览图片、视频的参数
        initialPreviewConfig: [
            {type: "video", filetype: "video/mp4", caption: "", url: "", key: 3},
        ],//视频配置
    });

/*    视频上传功能 -上传操作        */
    $('#file-0a').on('fileuploaded',function(event, data, previewId, index) {
        alert(111);
        var objUrl = getObjectURL(this.files[0]) ;
        console.log (objUrl);
        function getObjectURL(file) {
            var url = null;
            if (window.createObjectURL != undefined) { // basic
                url = window.createObjectURL(file);
            } else if (window.URL != undefined) { // mozilla(firefox)
                url = window.URL.createObjectURL(file);
            } else if (window.webkitURL != undefined) { // webkit or chrome
                url = window.webkitURL.createObjectURL(file);
            }
            console.log (url);
        }
        return;
        if (data.response.code == "402") {
            layer.msg('上传成功', {
                icon: 1,//提示的样式
                time: 1000, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
            });
             $("#ziyuan_id").val(data.response.parameter);
        }else{
            layer.msg('上传失败', {
                icon: 5,//提示的样式
                time: 2000, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
            });
            $(event.target)
                .fileinput('clear')
                .fileinput('unlock')
            $(event.target)
                .siblings('.fileinput-remove')
                .hide()
        }
    }).on('fileerror', function(event, data, msg) {
        layer.msg('服务器错误，请稍后再试', {icon: 5});

    });
/*    视频上传功能 -删除操作        */
 $('#file-0a').on('filecleared',function(event) {
        var value =$(" #ziyuan_id").val();
        if (value) {
            $.ajax({
                url: "<?php echo URL('index/Video/add_videl'); ?>",
                type: 'post',
                data: {value},
                success: function (arr) {
                    if(arr.code == "502"){
                        //登录成功
                        layer.msg('删除成功', {
                            icon: 1,//提示的样式
                            time: 1000, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                        });
                        $("#ziyuan_id").val("");
                    }else{
                        layer.msg('删除失败', {icon: 5});
                    }
                },
                error:function(){
                    layer.msg('操作失败', {icon: 5})
                }
            })
        }else{
            $("#ziyuan_id").val("");
        }
    });
</script>
<script>
    var post_flag = false; //设置一个对象来控制是否进入AJAX过程
    function updateFrom() {
        if(post_flag) return; //如果正在提交则直接返回，停止执行
        post_flag = true;//标记当前状态为正在提交状态
        //加载层
        layer.load();
        $.ajax({
            url: "<?php echo URL('index/Video/Video_add'); ?>",
            type: 'post',
            data: $("#form-video-add").serializeArray(),
            success: function (arr) {
                if(arr == "vde_ok"){
                    //登录成功
                    layer.msg('添加成功', {
                        icon: 1,//提示的样式
                        time: 1000, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                        end:function(){
                            $('#content-load').load("<?php echo url('index/Video/list_index'); ?>");
                        }
                    });
                }else if(arr == "vde_no"){
                    layer.msg('添加失败', {icon: 5});
                    post_flag =false;
                }else if(arr == "toutu_no"){
                    layer.msg('请添加头图', {icon: 5});
                    post_flag =false;
                }else if(arr == "datu_no"){
                    layer.msg('请添加大图', {icon: 5});
                    post_flag =false;
                }else if(arr == "jianc_no"){
                    layer.msg('请不要重复提交', {icon: 5});
                    post_flag =false;
                }else if(arr == "vid_no"){
                    layer.msg('请上传视频', {icon: 5});
                    post_flag =false;
                }else{
                    layer.msg(arr, {icon: 5});
                    post_flag =false;
                }
                post_flag =false;
                setTimeout(function(){
                    layer.closeAll('loading');
                }, 2500);
            },
            error:function(){

                post_flag =false;
            }
        })
    }
</script>
<script>
    var post_flag = false; //设置一个对象来控制是否进入AJAX过程
    function editFrom(){
        if(post_flag) return; //如果正在提交则直接返回，停止执行
        post_flag = true;//标记当前状态为正在提交状态
        // 加载层
        layer.load();
        $.ajax({
            url: "<?php echo URL('index/Video/video_edit'); ?>",
            type: 'post',
            data: $("#form-video-add").serializeArray(),
            success: function (arr) {
                if(arr == "vde_ok"){
                    //修改成功
                    layer.msg('修改成功', {
                        icon: 1,//提示的样式
                        time: 1000, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
                        end:function(){
                            // location.href="<?php echo url('index/Eqx/list_index'); ?>";
                            $('#content-load').load("<?php echo url('index/Video/list_index'); ?>");
                        }
                    });
                }else if(arr == "vdo_no"){
                    layer.msg('修改失败', {icon: 5});
                    post_flag =false;
                }else if(arr == "jianc_no"){
                    layer.msg('请不要重复提交', {icon: 5});
                    post_flag =false;
                }else{
                    layer.msg(arr, {icon: 5});
                    post_flag =false;
                }
                post_flag =false;
                setTimeout(function(){
                    layer.closeAll('loading');
                }, 3000);
            },
            error:function(){

                post_flag =false;
            }
        })

    }
</script>
<script>
    /*    视频预览功能 -配置        */
    $("#file-0aa").fileinput({
        dropZoneTitle : "请上传视频！", //标题
        language : "zh",//语言
        showCaption : false,//上传名称隐藏
        showUpload : true,//上传按键取消
        overwriteInitial : false, //是否要覆盖初始预览内容和标题设置
        showUploadedThumbs : false, //显示上传缩略图
        maxFileCount : 1, //最大上传文件
        minFileCount : 1, //最小上传文件
        maxFileSize : 153600,//文件最大153600kb=150M
        initialPreviewShowDelete : true, //缩略图显示删除按钮
        showRemove : true,//是否显示删除按钮
        showClose : false,//是否显示预览界面的关闭图标
        autoReplace : true, //是否自动替换预览中的文件
        enctype: 'multipart/form-data',//提交的编码
        validateInitialCount:true,//验证minfilecount和maxfilecount时是否包括初始预览文件计数
        layoutTemplates : {
            actionDelete:'', //去除上传预览的缩略图中的删除图标
            actionUpload:'',//去除上传预览缩略图中的上传图片；
            actionZoom:'',   //去除上传预览缩略图中的查看详情预览的缩略图标。
        },
        allowedFileExtensions : [ "mp4","avi","dat","3gp","mov","rmvb"],//上传格式
        previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",//当检测到用于预览的不可读文件类型时，在每个预览文件缩略图中显示的图标。
        initialPreviewAsData:true,//开启默认预览功能
        initialPreview: liulan_v,//预览图片、视频的参数
        initialPreviewConfig: [
            {type: "video", filetype: "video/mp4", caption: "", url: "", key: 3},
        ],//视频配置
    });
</script>