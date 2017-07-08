<?php
header('Content-type:application/json');

$uname=$_REQUEST['uname'];
$phone=$_REQUEST['phone'];
$movie=$_REQUEST['movie'];
$sex=$_REQUEST['sex'];
$mid=$_REQUEST['mid'];

if(empty($uname)||empty($phone)||empty($movie)||empty($sex)){
    echo '[]';
    return;
}
include('common.php');
$conn=mysqli_connect($host,$aname,$apwd,$dbname,$port);
mysqli_query($conn,"SET NAMES UTF8");

$orderTime=time()*1000;
$sql="INSERT INTO movie_order VALUES(NULL,'$phone','$uname','$sex','$orderTime','$movie','$mid')";
$result=mysqli_query($conn,$sql);
$arr=[];
if($result){
    $arr['msg']='succ';
    $arr['mid']=mysqli_insert_id($conn);
}else{
   $arr['msg']='fail';
   $arr['reason']='insert 数据失败'.$sql;
}
echo json_encode($arr);