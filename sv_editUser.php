<?php
//memanggil file pustaka fungsi
require "fungsi.php";

//memindahkan data kiriman dari form ke var biasa
$iduser = $_POST["iduser"];
$username = $_POST["username"];
$password = $_POST["password"];
$uploadOk = 1;

//membuat query
$sql = "update user set username='$username',
					 password='$password'
					 where iduser='$iduser'";
mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
header("location:ajaxupdateUser.php");
