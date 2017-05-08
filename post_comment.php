<?php

mysql_connect("localhost", "root", "111111");
mysql_select_db("survey");

$name = $_POST["name"];
$period = $_POST["period"];
$comment = $_POST["comment"];
//Get the content of the image and then add slashes to it
$imagetmp=addslashes (file_get_contents($_FILES['image']['tmp_name']));


//
// if(isset($_POST['submit'])){
//     $target = "/uploads".basename($_FILES['image']['name']);
//
//     $name = $_POST["name"];
//     $period = $_POST["period"];
//     $comment = $_POST["comment"];
//     $image = $_FILES['image']['name'];
//     $sql = "INSERT INTO comment1 VALUES('', '$name','$period','$comment','')"
//     mysql_query($sql);
//
//     move_uploaded_file($_FILES['image']['tmp_name'], $target)
//     header("location: comment.html");
//
// }
// $file = $_FILES['image']['tmp_name'];
//
// if(isset($file)){
//   $image = file_get_contents($_FILES['image']['tmp_name']);
// }

mysql_query("INSERT INTO comment1 VALUES('', '$name','$period','$comment', '$imagetmp')");
header("location: comment_result.php");


 ?>
