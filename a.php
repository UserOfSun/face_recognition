<!DOCTYPE html>

<?php session_start(); ?>
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
.table-view-cell {
  padding: 11px 15px 11px 15px;
}
.bar{
		background-color: #44cef8;
	}
.for{
	padding-left: 20px;
	padding-right:20px;
}
.real{
	display: none;;
}
.input{
	background:#44cef8;
	color: white;
}
</style>
</head>


<body>
	<header class="bar bar-nav">
		<a href="http://192.168.43.21:8080/a1.html">
			<span class="icon icon-left-nav pull-left">
		</a>
		</span>
		<h1 class="title">认证信息确认</h1>	
	</header>
	<br>

<?php 

//获取社保和身份信息
$shebao = $_GET['shebao'];
$id = $_GET['id'];
//认证状态，是否认证过
$zhuangtai = "";
//上次认证的时间
$time = "";
//按钮中显示的文字
$buttontxt = "";

//向session中存储认证人和身份证
$_SESSION['shebao_number'] = $shebao;
$_SESSION['name'] = "";

//连接数据库
$con = mysql_connect("localhost","root","sunxusen2020");

//没有连接成功的情况
if(!$con){
	die('Could not connect'. mysql_error() );
}

//选择需要连接的数据库
mysql_select_db("face",$con);

//选择表并查询数据
$result = mysql_query("select * from user");

//定义一个变量用来判断数据库中是否含有该人信息
$exit_flag = false;
//定义一个变量来判断是否认证过
$indentify_flag = false;
//输出字体的颜色(默认为黑色)
$color = "black";

while($row = mysql_fetch_array($result))
{
	//如果数据库中存在本人信息将flag便为true
	if($row['id']==$id || $row['shebaonumber']==$shebao)
	{
		$exit_flag = true;
		$_SESSION['name'] = $row['name'];
		$_SESSION['id'] = $row['id'];
	}
	//如果认证过将indentify_flag置为true
	if($row['indentify_flag']==1 && ($row['id']==$id || $row['shebaonumber']==$shebao))
	{
		$time = $row['primary_date'];
		$indentify_flag=true;
	}
}
if($exit_flag==false){		//若不存在弹出对话框后返回登录界面
	header("location:error.html");
}else {						//数据库中存在该人的信息
	if($indentify_flag==true){		//该人以前认证过
		$zhuangtai = "已建模";
		$buttontxt = "继续认证";
		$_SESSION['flag'] = "继续认证";
		$_SESSION['buttontxt'] = $buttontxt;
	}else {					//该人以前没有认证过
		$time = "无";
		$zhuangtai = "未建模";
		$buttontxt = "初次采集";
		$_SESSION['flag'] = "初次采集";
		$color = "red";
		$_SESSION['buttontxt'] = $buttontxt;
	}
}

 ?>



	
	<div class="content">
		<img src="./img/i1.jpg" width=100%; height=50%;>
			<div class="card">
			 <ul class="table-view"> 
				 <li class="table-view-cell">认证人<span class="pull-right" id="first"><?php echo $_SESSION['name']; ?></span></li>
			  	 <li class="table-view-cell">身份证<span class="pull-right"><?php  echo $_SESSION['id']; ?></span></li>
			  	 <li class="table-view-cell">认证状态<span class="pull-right" style="color:<?php echo $color;?>"><?php echo $zhuangtai;?></span></li>
			  	 <li class="table-view-cell">上次认证时间<span class="pull-right" style="color:<?php echo $color;?>"><?php  echo $time; ?></span></li>
			  </ul>
			</div>
			<form class="for" action="http://192.168.43.21:8080/upload_file.php" enctype="multipart/form-data" name="myform" method="post" >
				<label class="btn btn-block input">
                	<span><?php  echo $buttontxt ?></span>
					<input class="real" name="filename" id="file" type="file" accept="image/*" capture="camera">
            	</label>
            	<div class="btn btn-block input">
                	<input class="for2 back input" type="submit" value="下一步" style="border: #44cef8" />
            	</div>
            </form>
	</div>
</body>
</html>