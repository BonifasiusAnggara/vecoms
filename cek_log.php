<?php
	session_start();
	include('config/koneksi.php');
	$user = $_POST['username'];
	$pass = sha1($_POST['password']);
	$query = mysqli_query($conn, "SELECT * FROM user_man WHERE username='$user' AND password='$pass'");
	$num = mysqli_num_rows($query);
	$row = mysqli_fetch_array($query);

	if ($num >= 1) {
		$_SESSION['iduser'] = $row['id_user'];
		$_SESSION['akses'] = $row['akses'];
		$_SESSION['kodeuser'] = $row['kodeUser'];
		$_SESSION['email'] = $row['email'];
		header("location:media.php?module=home");
	} else {
		echo "<script type='text/javascript'>
				alert('Username atau Password Anda Salah !!');
				history.back(self);
			  </script>";
	}