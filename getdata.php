<?php

mysql_connect("localhost", "root", "111111") or die("Nope");

mysql_select_db('survey') or die("Dope");

$imagename=$_FILES["myimage"]["name"];

//Get the content of the image and then add slashes to it
$imagetmp=addslashes (file_get_contents($_FILES['myimage']['tmp_name']));

//Insert the image name and image content in image_table
$insert_image="INSERT INTO test VALUES('$imagetmp','$imagename')";

mysql_query($insert_image);

$name=$_GET['name'];

$select_image="select * from test where name='$name'";

$var=mysql_query($select_image);

if($row=mysql_fetch_array($var))
{
 $image_name=$row["name"];
 $image_content=$row["image"];
}
echo $image;

 ?>
