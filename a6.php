<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	<title>人脸识别资格认证</title>
	<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no,minimal-ui">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
	<link rel="stylesheet" href="./css/ratchet.css">
	<script type="./js/ratchet.js"></script>

<style type="text/css">
 .bar{
	background-color: #44cef8;
} 
.for{
	padding-left: 20px;
	padding-right:20px;
}
</style>
 
</head>


<body>
	<header class="bar bar-nav">
		<a href="http://192.168.43.21:8080/a.php">
			<span class="icon icon-left-nav pull-left"></span>
		</a>
		<h1 class="title">认证信息确认</h1>	
	</header>

    

	<div class="content">
	    <div align="center" style="padding-top: 20%;">
	        <img src="./img/i1.jpg"  text-align:centre; width=35%; height=30%;>
            <h2>验证失败</h2> 	
        
	       
	    </div>
	    <div style="padding-left: 30%;">
			<p>您认证失败的原因可能是以下：</p>
            <p>1.请保持光线的充足和均匀</p>                
            <p>2.摘掉眼镜，并露出耳朵</p>
            <p>3.请脸部正对摄像头</p>
            <p>4.请务必拍摄本人活体照片</p>
            <p>若多次认证未成功，请联系后台人员</p>

	    </div> 
	  	<form class="for" action="http://192.168.43.21:8080/a1.html">
	  		<button class="btn btn-block" style="background: red;">重新认证</button>
	  	</form>	
	</div>

</body>
</html>