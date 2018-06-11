<?php
	include ("../config/koneksi.php");
	date_default_timezone_set("Asia/Jakarta");

	if ($_GET['module'] == 'tambah') {	
		$id_mobil = $_POST['id_mobil'];
		$id_peg = $_POST['id_peg'];
		$bensin = $_POST['bensin'];
		$tgl_isi = $_POST['tgl_isi'];
		$harga = $_POST['harga'];
		$km_bensin = $_POST['km_bensin'];

		if (($id_mobil == 0) OR ($id_peg == 0) OR ($bensin == 0) OR ($km_bensin == 0)) {
			echo "<script>
			  		alert('Maaf, tidak boleh ada field yang kosong !!');
					window.location.href='../media.php?module=bensin&&act=tambah';
				  </script>";
		} else {
			$km_awal = $_POST['km_awal'];
			if ($km_awal > $km_bensin) {
			echo "<script>
			  		alert('Km pengisian bensin sekarang tidak boleh lebih kecil daripada Km pengisian bensin sebelumnya !! Mikirrrrrr !!');
					window.location.href='../media.php?module=bensin&&act=tambah';
				  </script>";
			} else {
				$id_rasio = $_POST['id_rasio'];
				$query = mysqli_query($conn, "INSERT INTO bensin (id_mobil, id_peg, bensin, km_bensin, harga, tgl_isi) VALUES ('$id_mobil','$id_peg','$bensin','$km_bensin','$harga','$tgl_isi')");

				$query2 = mysqli_query($conn, "SELECT bensin FROM bensin WHERE id_bensin = '$id_rasio'");
				$row = mysqli_fetch_array($query2);
				$rasio = ($km_bensin-$km_awal)/$row['bensin'];

				$query3 = mysqli_query($conn, "UPDATE bensin SET rasio = '$rasio' WHERE id_bensin = '$id_rasio'");

				header("location:../media.php?module=bensin");
			}
		}

	} elseif ($_GET['module'] == 'hapus') {
		$id_bensin = $_GET['id_bensin'];		
		$query = mysqli_query($conn, "DELETE FROM bensin WHERE id_bensin='$id_bensin'");
		header("location:../media.php?module=bensin");
	}
?>