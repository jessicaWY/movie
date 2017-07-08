<?php
header('Content-type:application/json');
$output=[];

@$kw=@$_REQUEST['kw'];
if(empty($kw)){
    echo '[]';
    return;
}
include('common.php');
$conn=mysqli_connect($host,$aname,$apwd,$dbname,$port);
mysqli_query($conn,"SET NAMES UTF8");

$sql="SELECT * FROM movie_list WHERE name LIKE '%$kw%' OR detail LIKE '%$kw%'";
$result=mysqli_query($conn,$sql);
while(($row=mysqli_fetch_assoc($result))!==NULL){
    $output[]=$row;
}
echo json_encode($output);
