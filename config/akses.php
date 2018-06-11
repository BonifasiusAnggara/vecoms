<?php
	include "koneksi.php";
	$iduser = $_SESSION['iduser'];
	$query = mysqli_query($conn, "SELECT * FROM user_man WHERE id_user='$iduser'");
	$row = mysqli_fetch_array($query);
?>