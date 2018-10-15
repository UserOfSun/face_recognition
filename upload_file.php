<?php 

	require_once 'AipFace.php';

	// 你的 APPID AK SK
	const APP_ID = '14275242';
	const API_KEY = 'sIVH1gessePtlmWTLiqGql8y';
	const SECRET_KEY = 'yZ2KbenC47Pw9BBzNMCzugwbF1fUqYUU';

session_start();
// echo $_FILES['filename']['name']."<br>";
// echo $_FILES['filename']['type']."<br>";
// echo ($_FILES['filename']['size'] / 1024) . " kB<br>";
//文件的存储路径
//echo $_FILES['filename']['tmp_name']."<br>";
//上传图片的路径
$image = $_FILES['filename']['tmp_name'];
//将上传的图片base64转码
$base64_image = base64EncodeImage($image);
//启动
session_start();
//向session中存取图片转码后的信息
$_SESSION['base64'] = $base64_image;

//连接数据库
$con = mysql_connect("localhost","root","sunxusen2020");
//没有连接成功的情况
if(!$con){
	die('Could not connect'. mysql_error() );
}

//选择需要连接的数据库
mysql_select_db("face",$con);

//以前若没有认证过，直接将转码信息存放到数据库
if($_SESSION['flag']=="初次采集"){

move_uploaded_file($_FILES['filename']['tmp_name'],"./img/UserImage/".$_SESSION['id'].".jpg" );
$sql = "update user set photo='".$_SESSION['base64']."',indentify_flag=1"." where id='".$_SESSION['id']."'";
$sql3 = "update user set primary_date='".date("Y-m-d")."' where id='".$_SESSION['id']."'";
//执行sql语句
mysql_query($sql,$con);
mysql_query($sql3,$con);

//图片信息采集完跳转采集成功界面
header("location:a5.php");

}else {				//以前认证过


	$client = new AipFace(APP_ID, API_KEY, SECRET_KEY);

	//从数据库中选取已经存在的base64码
	$sql2 = "select photo from user where id='".$_SESSION['id']."'";
	//将base64编码赋给变量
	$query = mysql_query($sql2,$con);
	$photo = mysql_result($query, 0);
	//将数据库的编码信息转为图片
	preg_match('/^(data:\s*image\/(\w+);base64,)/', $photo, $result);
	$type = $result[2];
	$name = $_SESSION['id'].$type;
	$savepath = "D:/phpStudy/WWW/img".$name;
	file_put_contents($savepath, base64_decode(str_replace($result[1], '',$photo)));
	//将照片的路径存到session中
	$_SESSION['photo_path'] = $savepath;


	//echo "PHOTO ".$name."<br>";

	$result = $client->match(array(
	    array(
	    	//拍照上传的图片
	        'image' => base64_encode(file_get_contents($image)),
	        'image_type' => 'BASE64',
	    ),
	    array(
	    	//数据库中base64码转化的图片（继续用百度的方法转码）
	        'image' => base64_encode(file_get_contents($savepath)),
	        'image_type' => 'BASE64',
	    ),
	));

	//照片活体检测，避免二次翻拍造假
	$live_point = $client->faceverify(array(
    array(
        'image' => base64_encode(file_get_contents($image)),
        'image_type' => 'BASE64',
    	),
	));

//提取照片的相似度
//提取第一个数组中的值
$arr = array_values($result);
//提取第二个数组中的值（嵌套的）
$arr1 = array_values($arr[5]);
//将比对结果分数赋值给一个变量
$score = $arr1[0];

//提取照片活体检测的分数
$livearr = array_values($live_point);
$livearr1 = array_values($livearr[5]);
//照片活体检测的分数
$live_score = $livearr1[1];


if($score>85 && $live_score>0.7){
	header("location:a5.php");
}else {
	header("location:a6.php");
}
}

 

//将图片base64编码
 
function base64EncodeImage ($image_file) {

    $base64_image = '';

    $image_info = getimagesize($image_file);

    $image_data = fread(fopen($image_file, 'r'), filesize($image_file));

    $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));

    return $base64_image;

}


 ?>

