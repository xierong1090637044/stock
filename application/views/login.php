<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="zh-CN">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>登陆丨进销云</title>
<link rel="stylesheet" href="../statics/test/css/style.css">
<script src="<?php echo base_url()?>statics/login/<?php echo sys_skin()?>/Scripts/minijs/jquery-1.7.1.js"></script>
<script src="<?php echo base_url()?>statics/login/<?php echo sys_skin()?>/Scripts/minijs/common.js"></script>
<script src="<?php echo base_url()?>statics/login/<?php echo sys_skin()?>/Scripts/minijs/minicheck.js"></script>
<script src="../statics/test/js/common.js"></script>
<!--背景图片自动更换-->
<script src="../statics/test/js/supersized.3.2.7.min.js"></script>
<!--表单验证-->
<script src="../statics/test/js/jquery.validate.min.js?var1.14.0"></script>
<body id="body">

<div class="login-container">
	<h1>进销云</h1>

	<div class="connect">
		<p>宁愿跑起来被拌倒无数次，也不愿规规矩矩走一辈子，就算跌倒，也要豪迈的笑</p>
	</div>

	<form onSubmit="return Login()" method="post" id="loginForm">
    <div style="color:red; font-size:20px; margin-top:12px; line-height:20px; display:none;" id="loginerror"></div>
		<div>
			<input type="text" class="logininput" value="<?php echo get_cookie('username')?>" id="username" placeholder="输入账号" />
		</div>
		<div>
			<input type="password" class="logininput" id="password" value="<?php echo get_cookie('userpwd')?>" placeholder="输入密码" />
		</div>
		<button id="submit" type="submit">登 陆</button>
	</form>

	<a href="<?php echo site_url('login/test')?>">
		<button type="button" class="register-tis">还有没有账号？</button>
	</a>

</div>

<!--需要loading 的页面就在页面最下方加-->
<div class="loading">
	<img src="<?php echo base_url()?>statics/login/<?php echo sys_skin()?>/Images/loading.gif" style="position:absolute;top:50%;left:50%;margin:-82px 0 0 -135px;" alt="请稍后...">
</div>

</body>
<script type="text/javascript">
    //加载公用的js最后面
    $(window).load(function(){
        $('.loading').hide();
    });

    function Login() {
        var cookieEnabled = (navigator.cookieEnabled) ? true : false;
        if (!cookieEnabled) {
            alert("该浏览器Cookie设置不正确，无法正常登录");
            return false;
        }
        var username = $.trim($("#username").val());
        var password = $.trim($("#password").val());
        var isRemmenbPassWord = $("#Checked").attr("val"); // 1为记住密码  0 未记住密码
        if (checkNullOrEmpty(username)) {
            $("#loginerror").text("请输入账号").show();
            $("#username").focus();
            return false;
        }
        if (checkNullOrEmpty(password)) {
            $("#loginerror").text("请输入密码").show();
            $("#password").focus();
            return false;
        }
        $('.loading').show();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('login');?>",
            data: {
                username: username,
                userpwd: password,
                token: "<?php echo token()?>",
                ispwd:isRemmenbPassWord
            },
            //dataType: "json",
            success: function (data) {
              if (data==1) {
      				    $('.loading').hide();
      					location.href = "<?php echo site_url('home/index')?>";
      				} else {
      				    $("#loginerror").text(data).show();
      					$('.loading').hide();
      					setTimeout("location.href='<?php echo site_url('login')?>'",1500);
      				}
                //$('.loading').hide();
                //location.href = "<?php echo site_url('home/index')?>";
                return false;
            },
            timeout: 60000,
            error: function (xhr, status) {
                if (status == "timeout") {
                    $("#loginerror").text("您的网络好像很糟糕，请刷新页面重试").show();
                    $('.loading').hide();
                    return false;
                }
                else {
                    $("#loginerror").text("服务器内部错误，请重试").show();
                    $('.loading').hide();
                    return false;
                }
            }
        });
        return false;
    }
    $(function () {
        document.onkeydown = function(e) {
            var ev = document.all ? window.event : e;
            if (ev.keyCode == 13) {
                $("#btnLogin").trigger("click");
            }
        };
    });

    //图片轮播
    jQuery(function($){

        $.supersized({

            // 功能
            slide_interval     : 4000,    // 转换之间的长度
            transition         : 1,    // 0 - 无，1 - 淡入淡出，2 - 滑动顶，3 - 滑动向右，4 - 滑底，5 - 滑块向左，6 - 旋转木马右键，7 - 左旋转木马
            transition_speed   : 1000,    // 转型速度
            performance        : 1,    // 0 - 正常，1 - 混合速度/质量，2 - 更优的图像质量，三优的转换速度//（仅适用于火狐/ IE浏览器，而不是Webkit的）

            // 大小和位置
            min_width          : 0,    // 最小允许宽度（以像素为单位）
            min_height         : 0,    // 最小允许高度（以像素为单位）
            vertical_center    : 1,    // 垂直居中背景
            horizontal_center  : 1,    // 水平中心的背景
            fit_always         : 0,    // 图像绝不会超过浏览器的宽度或高度（忽略分钟。尺寸）
            fit_portrait       : 1,    // 纵向图像将不超过浏览器高度
            fit_landscape      : 0,    // 景观的图像将不超过宽度的浏览器

            // 组件
            slide_links        : 'blank',    // 个别环节为每张幻灯片（选项：假的，'民'，'名'，'空'）
            slides             : [    // 幻灯片影像
                                     {image : '../statics/test/images/1.jpg'},
                                     {image : '../statics/test/images/2.jpg'},
                                     {image : '../statics/test/images/3.jpg'}
                           ]

        });

    });
</script>

</html>
