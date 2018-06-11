<?php
	include ("../config/koneksi.php");

	if ($_GET['module'] == 'tambah') {
		$id_bkl = $_POST['id_bkl'];
		$nama_serv = $_POST['nama_serv'];
		$harga_serv = $_POST['harga_serv'];
		$masa_serv = $_POST['masa_serv'];

		if ($id_bkl == 0) {
			echo "<script>
			  		alert('Maaf, nama bengkel tidak boleh kosong !!');
					window.location.href='../media.php?module=service';
				  </script>";
		} else {
			$query = mysqli_query($conn, "INSERT INTO kat_service (id_bkl, nama_serv, harga_serv, masa_serv) VALUES ('$id_bkl','$nama_serv','$harga_serv','$masa_serv')");
			header("location:../media.php?module=service");
		}
		
	} elseif ($_GET['module'] == 'edit') {
		$id_serv = $_POST['id_serv'];
		$id_bkl = $_POST['id_bkl'];
		$nama_serv = $_POST['nama_serv'];
		$harga_serv = $_POST['harga_serv'];
		$masa_serv = $_POST['masa_serv'];
		$query = mysqli_query($conn, "UPDATE kat_service SET id_bkl='$id_bkl', nama_serv='$nama_serv', harga_serv='$harga_serv', masa_serv='$masa_serv' WHERE id_serv='$id_serv'");
		header("location:../media.php?module=service");
	} elseif ($_GET['module'] == 'hapus') {
		$id_serv = $_GET['id_serv'];
		$query = mysqli_query($conn, "DELETE FROM kat_service WHERE id_serv='$id_serv'");
		header("location:../media.php?module=service");
	}
?>