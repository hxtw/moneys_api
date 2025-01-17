<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:87:"D:\phpStudy\PHPTutorial\WWW\My_moneys\public/../application/index\view\Login\login.html";i:1561447210;}*/ ?>
<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
	<title>My money</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="/static/assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="/static/assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="/static/assets/vendor/linearicons/style.css">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="/static/assets/css/main.css">
	<!-- GOOGLE FONTS -->
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="/static/assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/static/assets/img/favicon.png">
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box ">
					<div class="left">
						<div class="content">
							<div class="header">
								<div class="logo text-center"><img src="/static/assets/img/logo-dark.png" alt="My money Logo"></div>
								<p class="lead">Login to your account</p>
							</div>
							<form class="form-auth-small" action="index.html">
								<div class="form-group">
									<label for="my_phone" class="control-label sr-only">手机号</label>
									<input type="tel" class="form-control input-lg" id="my_phone" value="" placeholder="手机号" name="number">
								</div>
								<div class="form-group">
									<label for="my_password" class="control-label sr-only">密码</label>
									<input type="password" class="form-control input-lg" id="my_password" value="" placeholder="密码" name="password">
								</div>
								<div class="form-group clearfix">
									<label class="fancy-checkbox element-left">
										<input type="checkbox" name="remember">
										<span>记住我</span>
									</label>
								</div>
								<span id="phoneLog" class="btn btn-primary btn-lg btn-block">LOGIN</span>
							</form>
						</div>
					</div>
					<div class="right">
						<div class="overlay"></div>
						<div class="content text">
							<h1 class="heading">The wheat piled up into a mountain</h1>
							<p>My money</p>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
</body>
<script type="text/javascript" src="/static/assets/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript" src="/static/layer/layer.js"></script>

<script>
	$("#phoneLog").click(function (){
		var number=$("#my_phone").val();
		var password=$("#my_password").val();
		$.ajax({
			type: 'post',
			url: "<?php echo url('index/login/login_phone'); ?>",
			data: {
				number:number,
				password:password,
			},
			success: function (data) {
				if(data=="user_ok"){
					//登录成功
					layer.msg('登录成功', {
						icon: 1,//提示的样式
						time: 2000, //2秒关闭（如果不配置，默认是3秒）//设置后不需要自己写定时关闭了，单位是毫秒
						end:function(){
							location.href="<?php echo url('index/Index/index'); ?>";
						}
					});
				}else if(data=="user_Close"){
					layer.msg('账号已关闭', {icon: 5});
				}else if(data=="user_no"){
					layer.msg('密码错误', {icon: 5});
				}else if(data=="number_no"){
					layer.msg('账号不存在', {icon: 5});
				}else if(data=="phone_no"){
					layer.msg('手机号格式错误', {icon: 5});
				}
			}
		})

	})
</script>
</html>
