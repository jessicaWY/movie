<?php
header('Content-type:application/json');
$output=[];

$start=$_REQUEST['start'];

include('common.php');
$conn=mysqli_connect($host,$aname,$apwd,$dbname,$port);
mysqli_query($conn,"SET NAMES UTF8");

$sql="SELECT COUNT(*) FROM movie_list";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);

$totalPage=intval($row['COUNT(*)']);
$pageSize=5;
$pageCount=ceil($totalPage/$pageSize);

$sql="SELECT * FROM movie_list LIMIT $start,$pageSize";
$result=mysqli_query($conn,$sql);

while(($row=mysqli_fetch_assoc($result))!==NULL){
    $output[]=$row;
}

echo json_encode($output);
