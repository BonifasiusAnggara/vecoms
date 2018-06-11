<?php
	$conn = mysqli_connect("127.0.0.1","root","") or die("Tidak Terkoneksi");
	$db = mysqli_select_db($conn, "vecoms") or die("Database Tidak Ditemukan");
?>