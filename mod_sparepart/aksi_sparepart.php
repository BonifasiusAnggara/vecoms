<?php
	include ("../config/koneksi.php");

	if ($_GET['module'] == 'tambah') {
		$id_bkl = $_POST['id_bkl'];
		$nama_sprt = $_POST['nama_sprt'];
		$harga_sprt = $_POST['harga_sprt'];
		$masa_ganti = $_POST['masa_ganti'];

		if ($id_bkl == 0) {
			echo "<script>
			  		alert('Maaf, nama bengkel tidak boleh kosong !!');
					window.location.href='../media.php?module=data_sparepart';
				  </script>";
		} else {
			$query = mysqli_query($conn, "INSERT INTO sparepart (id_bkl, nama_sprt, harga_sprt, masa_ganti) VALUES ('$id_bkl','$nama_sprt','$harga_sprt','$masa_ganti')");
			header("location:../media.php?module=data_sparepart");
		}
		
	} elseif ($_GET['module'] == 'edit') {
		$id_sprt = $_POST['id_sprt'];
		$id_bkl = $_POST['id_bkl'];
		$nama_sprt = $_POST['nama_sprt'];
		$harga_sprt = $_POST['harga_sprt'];
		$masa_ganti = $_POST['masa_ganti'];
		if ($id_bkl == '') {
			echo "<script>
			  		alert('Maaf, nama bengkel tidak boleh kosong !!');
					window.location.href='../media.php?module=data_sparepart';
				  </script>";
		} else {
			$query = mysqli_query($conn, "UPDATE sparepart SET id_bkl='$id_bkl', nama_sprt='$nama_sprt', harga_sprt='$harga_sprt', masa_ganti='$masa_ganti' WHERE id_sprt='$id_sprt'");
			header("location:../media.php?module=data_sparepart");
		}
		
	} elseif ($_GET['module'] == 'hapus') {
		$id_sprt = $_GET['id_sprt'];
		$query = mysqli_query($conn, "DELETE FROM sparepart WHERE id_sprt='$id_sprt'");
		header("location:../media.php?module=data_sparepart");
	}
?>