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
.table-view-cell {
  padding: 11px 15px 11px 15px;
}

.bar{
		background-color: #44cef8;
	}
.for{
	padding-left: 20px;
	padding-right: 20px;
}
.people{
	text-align: center;;
}
</style>
</head>


<body>
	<header class="bar bar-nav">
		<a href="http://192.168.43.21:8080/a.php">
			<span class="icon icon-left-nav pull-left">
		</a>
		</span>
		<h1 class="title">认证信息确认</h1>	
	</header>
	<br>


<?php 


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

//启动
session_start();

//认证成功，更新数据库的认证时间
$sql2 = "update user set primary_date='".date("Y-m-d")."' where id='".$_SESSION['id']."'";
//执行SQL语句
mysql_query($sql2,$con);
		


 ?>


	
	<div class="content">

			<td style="position:relative;">
                <img class="people" style="position:absolute;z-index: -s1;padding-left: 16%;padding-top: 10%;" 
                src=<?php echo "./img/UserImage/".$_SESSION['id'].".jpg";?>  width=80%; height=43%;>
                 <img  style="z-index:2;" src="./img/i2.png"  width=100%; height=50%;>
            </td>
            <span style="display: block;text-align: center;color: red;"><?php if ($_SESSION['buttontxt']=="初次采集") {echo "采集成功";} ?></span>
			<div class="card">
			 <ul class="table-view"> 
				 <li class="table-view-cell">认证人<span class="pull-right"><?php echo $_SESSION['name']; ?></span></li>
			  	 <li class="table-view-cell">身份证<span class="pull-right"><?php echo $_SESSION['id']; ?></span></li>
			  	 <li class="table-view-cell">社保状态<span class="pull-right">已参保</span></li>
			  	 <li class="table-view-cell">认证时间<span class="pull-right"><?php echo date("Y-m-d"); ?></span></li>
				 <li class="table-view-cell">下次认证时间<span class="pull-right"><?php echo date("Y-m",strtotime("+1 year")); ?></span></li>
			  </ul>
			</div>
			<form class="for" action="http://192.168.43.21:8080/a1.html">
				<button class="btn btn-block" style="background: #44cef8;color: white;">返回</button>
			</form>	
	</div>
</body>
</html>