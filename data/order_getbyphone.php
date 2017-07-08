<?php
header('Content-type:application/json');

$phone=$_REQUEST['phone'];
include('common.php');
$conn=mysqli_connect($host,$aname,$apwd,$dbname,$port);
mysqli_query($conn,"SET NAMES UTF8");

$sql="SELECT movie_order.oid,movie_order.user_name,movie_order.order_time,movie_list.img_sm,movie_list.mid FROM movie_order,movie_list WHERE movie_order.mid=movie_list.mid AND movie_order.phone='$phone'";
$result=mysqli_query($conn,$sql);

$output=[];
while($row=mysqli_fetch_assoc($result)){
    $output[]=$row;
}
echo json_encode($output);