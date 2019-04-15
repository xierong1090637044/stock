<!DOCTYPE html>
<html lang="zh-CN">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>注册丨进销云</title>
<link rel="stylesheet" href="../../statics/test/css/style.css">
<body>

<div class="register-container">
	<h1>进销云</h1>

	<div class="connect">
		<p>宁愿跑起来被拌倒无数次，也不愿规规矩矩走一辈子，就算跌倒，也要豪迈的笑</p>
	</div>

	<form action="" onSubmit="return register()" id="loginForm">
    <div style="color:red; font-size:20px; margin-top:12px; line-height:20px; display:none;" id="loginerror"></div>
		<div>
			<input type="text" name="username" class="username" placeholder="您的用户名" autocomplete="off" id="username"/>
		</div>
		<div>
			<input type="password" name="password" class="password" placeholder="输入密码" oncontextmenu="return false" onpaste="return false" id="password"/>
		</div>
		<div>
			<input type="password" name="confirm_password" class="confirm_password" placeholder="再次输入密码" oncontextmenu="return false" onpaste="return false"  id="confirm_password"/>
		</div>
		<div>
			<input type="text" name="phone_number" class="phone_number" placeholder="输入手机号码" id="number"/>
		</div>
		<div>
			<input type="email" name="email" class="email" placeholder="输入邮箱地址" oncontextmenu="return false" onpaste="return false" id="email"/>
		</div>

		<button id="submit" type="submit" >注 册</button>
	</form>
	<a href="<?php echo site_url('login');?>">
		<button type="button" class="register-tis">已经有账号？</button>
	</a>

</div>

</body>
<script src="http://www.jq22.com/jquery/1.11.1/jquery.min.js"></script>
<script src="../../statics/test/js/common.js"></script>
<!--背景图片自动更换-->
<script src="../../statics/test/js/supersized.3.2.7.min.js"></script>
<!--表单验证-->
<script src="../../statics/test/js/jquery.validate.min.js?var1.14.0"></script>
<script>
function register()
{
  var cookieEnabled = (navigator.cookieEnabled) ? true : false;
  if (!cookieEnabled) {
      alert("该浏览器Cookie设置不正确，无法正常登录");
      return false;
  }
  var username = $("#username").val();
  var password = $("#password").val();
  var mobile = $("#number").val();
  var mail = $("#email").val();
  $('.loading').show();
  $.ajax({
      type: "POST",
      url: "<?php echo site_url('login/test');?>",
      data: {
          username: username,
          userpwd: password,
          mobile:mobile,
          mail:mail,
      },
      //dataType: "json",
      success: function (data) {
        if (data==1) {
          $("#loginerror").text("注册成功").show();
          setTimeout(function(){
            location.href = "<?php echo site_url('login')?>";
          },1000)
        } else {
          $("#loginerror").text(data).show();
          $('.loading').hide();
          setTimeout("location.href='<?php echo site_url('login/test')?>'",1500);
        }
      },
      error: function (xhr, status) {

      }
  });
  return false;
};

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
                                 {image : '../../statics/test/images/1.jpg'},
                                 {image : '../../statics/test/images/2.jpg'},
                                 {image : '../../statics/test/images/3.jpg'}
                       ]

    });

});
</script>
</html>
