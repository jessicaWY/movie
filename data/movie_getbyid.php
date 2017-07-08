<?php
header('Content-type:application/json');

$id=$_REQUEST['id'];

include('common.php');
$conn=mysqli_connect($host,$aname,$apwd,$dbname,$port);
mysqli_query($conn,"SET NAMES UTF8");

$sql="SELECT mid,name,price,img_lg,actor,detail  FROM movie_list WHERE mid='$id'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);

echo json_encode($row);
