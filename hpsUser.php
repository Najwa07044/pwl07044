<?php
//memanggil file pustaka fungsi
require "fungsi.php";

//memindahkan data kiriman dari form ke var biasa
$iduser = $_GET["iduser"];

$sql = $koneksi->query("select * from user where iduser='$iduser'");
$data = $sql->fetch_assoc();


$sql = $koneksi->query("select * from user where iduser='$iduser'");
//membuat query hapus data
$sql = "delete from user where iduser=$iduser";
mysqli_query($koneksi, $sql);
header("location:ajaxUpdateUser.php");
