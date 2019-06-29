<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:87:"D:\phpStudy\PHPTutorial\WWW\My_moneys\public/../application/index\view\Index\index.html";i:1561625427;}*/ ?>
<!doctype html>
<html lang="en">

<head>
	<title>My money</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="/static/assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="/static/assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="/static/assets/vendor/linearicons/style.css">
	<link href="/static/video_file/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<!--	<link rel="stylesheet" href="/static/assets/vendor/fileinput/bootstrap-fileinput.css">-->
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="/static/assets/css/main.css">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="/static/assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/static/assets/img/favicon.png">
	<!-- bootstrap time -->
	<link rel="stylesheet" href="/static/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css">
</head>
<style>
	.xxxx{
		position:fixed;
		top:0;
		left:0;
		background:rgba(255,255,255,0);
		width:100%;
		height:100%;
	}
</style>
<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand">
				<a href="javascript:void(0);"><img src="/static/assets/img/logo-dark.png" alt="My money" class="img-responsive logo"></a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
				</div>
				<form class="navbar-form navbar-left">
					<div class="input-group">
						<input type="text" value="" class="form-control" placeholder="Search ...">
						<span class="input-group-btn"><button type="button" class="btn btn-primary">Go</button></span>
					</div>
				</form>

				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
								<i class="lnr lnr-alarm"></i>
								<span class="badge bg-danger">5</span>
							</a>
							<ul class="dropdown-menu notifications">
								<li><a href="#" class="notification-item"><span class="dot bg-warning"></span>System space is almost full</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-danger"></span>You have 9 unfinished tasks</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-success"></span>Monthly report is available</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-warning"></span>Weekly meeting in 1 hour</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-success"></span>Your request has been approved</a></li>
								<li><a href="#" class="more">See all notifications</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><img src="/static/assets/img/user.png" class="img-circle" alt="Avatar"> <span><?php echo \think\Cookie::get('my_money_user'); ?>
							</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu" style="min-width:150px;">
								<li><a href="#"><i class="lnr lnr-user"></i> <span>我的信息</span></a></li>
								<li><a href="login.html"><i class="lnr lnr-exit"></i> <span>退 出</span></a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li><a href="javascript:void(0);" data-href="module/home.html" class="active"><i class="lnr lnr-home"></i> <span>首页</span></a></li>
						<?php if(in_array(Eqx,$comma_separated)): ?>
						<li>
							<a href="#navEqx" data-toggle="collapse" class="collapsed"><i class="lnr lnr-laptop-phone"></i> <span>易企秀</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="navEqx" class="collapse">
								<ul class="nav">
									<li><a href="javascript:void(0);" class="" data-href="<?php echo url('index/Eqx/add_index'); ?>"><i class="lnr lnr-rocket"></i> <span>投稿</span></a></li>
									<li><a href="javascript:void(0);" class="" data-href="<?php echo url('index/Eqx/list_index'); ?>"><i class="lnr lnr-hourglass"></i> <span>提审记录</span></a></li>
								</ul>
							</div>
						</li>
						<?php endif; if(in_array(Article,$comma_separated)): ?>
						<li>
							<a href="#navEssay" data-toggle="collapse" class="collapsed"><i class="lnr lnr-pencil"></i> <span>文章</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="navEssay" class="collapse">
								<ul class="nav">
									<li><a href="javascript:void(0);" class="" data-href="<?php echo url('index/Article/add_index'); ?>"><i class="lnr lnr-rocket"></i> <span>投稿</span></a></li>
									<li><a href="javascript:void(0);" class="" data-href="<?php echo url('index/Article/list_index'); ?>"><i class="lnr lnr-hourglass"></i> <span>提审记录</span></a></li>
									<li><a href="javascript:void(0);" class=""><i class="lnr lnr-question-circle"></i> <span>注意</span></a></li>
								</ul>
							</div>
						</li>
						<?php endif; if(in_array(Video,$comma_separated)): ?>
						<li>
							<a href="#navVideo" data-toggle="collapse" class="collapsed"><i class="lnr lnr-camera-video"></i> <span>视频</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="navVideo" class="collapse">
								<ul class="nav">
									<li><a href="javascript:void(0);" class="" data-href="<?php echo url('index/Video/add_index'); ?>"><i class="lnr lnr-rocket"></i> <span>投稿</span></a></li>
									<li><a href="javascript:void(0);" class="" data-href="<?php echo url('index/Video/list_index'); ?>"><i class="lnr lnr-hourglass"></i> <span>提审记录</span></a></li>
									<li><a href="javascript:void(0);" class=""><i class="lnr lnr-question-circle"></i> <span>注意</span></a></li>
								</ul>
							</div>
						</li>
						<?php endif; if(in_array(Ih5,$comma_separated)): ?>
						<li>
							<a href="#navIh5" data-toggle="collapse" class="collapsed"><i class="lnr lnr-camera-video"></i> <span>ih5</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="navIh5" class="collapse">
								<ul class="nav">
									<li><a href="javascript:void(0);" class=""><i class="lnr lnr-rocket"></i> <span>投稿</span></a></li>
									<li><a href="javascript:void(0);" class=""><i class="lnr lnr-hourglass"></i> <span>提审记录</span></a></li>
									<li><a href="javascript:void(0);" class=""><i class="lnr lnr-question-circle"></i> <span>注意</span></a></li>
								</ul>
							</div>
						</li>
						<?php endif; if(in_array(Dubbing,$comma_separated)): ?>
						<li>
							<a href="#navDub" data-toggle="collapse" class="collapsed"><i class="lnr lnr-mic"></i> <span>配音</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="navDub" class="collapse">
								<ul class="nav">
									<li><a href="javascript:void(0);" class="" data-href="<?php echo url('index/Dubbing/list_order'); ?>"><i class="lnr lnr-alarm"></i> <span>来单了</span></a></li>
									<li><a href="javascript:void(0);" class="" data-href="<?php echo url('index/Dubbing/list_index'); ?>"><i class="lnr lnr-hourglass"></i> <span>提审记录</span></a></li>
									<li><a href="javascript:void(0);" class=""><i class="lnr lnr-question-circle"></i> <span>注意</span></a></li>
								</ul>
							</div>
						</li>
						<?php endif; ?>
						<li>
                            <a href="#navTj" data-toggle="collapse" class="collapsed"><i class="lnr lnr-cog"></i> <span>我的信息</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                            <div id="navTj" class="collapse">
                                <ul class="nav">
                                    <li><a href="javascript:void(0);" class="" data-href="<?php echo url('index/Statistics/index'); ?>"><i class="lnr lnr-chart-bars"></i> <span>统计</span></a></li>
                                </ul>
                            </div>
                        </li>
					</ul>
				</nav>
			</div>
		</div>
		<!-- END LEFT SIDEBAR -->
		<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content" id="content-load"></div>
			<!-- END MAIN CONTENT -->
		</div>
		<!-- END MAIN -->
		<div class="clearfix"></div>
		<footer>
			<div class="container-fluid">
				<p class="copyright">Copyright © 2018 My money</p>
			</div>
		</footer>
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
<!--	<script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>-->
<!--	<script src="/static/assets/vendor/jquery/jquery.min.js"></script>-->
	<script src="/static/assets/vendor/jquery/jquery-3.3.1.min.js"></script>
	<script src="/static/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="/static/assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!--	<script src="/static/assets/vendor/fileinput/bootstrap-fileinput.js"></script>-->
	<script src="/static/video_file/js/fileinput.js" type="text/javascript"></script>
	<script src="/static/video_file/js/locales/zh.js" type="text/javascript"></script>
	<script src="/static/assets/scripts/klorofil-common.js"></script>
	<script src="/static/layer/layer.js"></script>
	<!-- bootstrap time -->
	<script src="/static/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js"></script>
	<!-- laydate time -->
	<script src="/static/laydate/laydate.js"></script>
	<script>
        jQuery(function($) {
            $('#content-load').load("<?php echo URL('index/Index/home'); ?>");
            $("#sidebar-nav a").click(function () {
                if($(this).attr('data-href')){
                    $('#content-load').load($(this).attr('data-href'));
                }
            });
        })
		var addpiu = "<?php echo url('index/Picture/add_pi'); ?>";
		var delpiu = "<?php echo url('index/Picture/del_pi'); ?>";
	</script>
</body>
</html>
