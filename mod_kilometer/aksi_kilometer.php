<?php
	include ("../config/koneksi.php");
	date_default_timezone_set("Asia/Jakarta");

	if ($_GET['module'] == 'tambah') {	
		$id_mobil = $_POST['id_mobil'];
		$id_peg = $_POST['id_peg'];
		$rayon = $_POST['rayon'];

		if (($id_mobil == 0) OR ($id_peg == 0)) {
			echo "<script>
			  		alert('Mobil dan Driver tidak boleh kosong !!');
					window.location.href='../media.php?module=kilometer&&act=tambah';
				  </script>";
		} else {	
			$query = mysqli_query($conn, "INSERT INTO kilometer (id_mobil, id_peg, rayon) VALUES ('$id_mobil','$id_peg', '$rayon')");

			header("location:../media.php?module=kilometer");
		}
		
	} elseif ($_GET['module'] == 'km_awal') {
		$id_km = $_POST['id_km'];
		$km_awal = $_POST['km_awal'];
		$km_akhir = $_POST['km_akhir'];
		$id_mobil = $_POST['id_mobil'];
		$time_stamp = date("Y-m-d H:i:s");
		
		if ($km_awal < $km_akhir) {
			echo "<script>
			  		alert('Km berangkat tidak bisa lebih kecil Km Pulang periode sebelumnya !!');
					window.location.href='../media.php?module=kilometer&&act=km_awal&&id_km=$id_km&&id_mobil=$id_mobil';
				  </script>";
		} else {
			$query = mysqli_query($conn, "UPDATE kilometer SET km_brkt='$km_awal', jam_brkt='$time_stamp' WHERE id_km='$id_km'");
		
			header("location:../media.php?module=kilometer");
		}		
		
	} elseif ($_GET['module'] == 'km_akhir') {
		$id_km = $_POST['id_km'];
		$id_mobil = $_POST['id_mobil'];
		$km_akhir = $_POST['km_akhir'];
		$time_stamp = date("Y-m-d H:i:s");

		$query1 = mysqli_query($conn, "SELECT * FROM kilometer WHERE id_km='$id_km'");
		$row = mysqli_fetch_array($query1);
		
		if ($km_akhir == 0) {
			echo "<script>
			  		alert('Km Pulang tidak boleh nol!!');
					window.location.href='../media.php?module=kilometer&&act=km_akhir&&id_km=$id_km&&id_mobil=$id_mobil';
				  </script>";
		} else if ($km_akhir < $row['km_brkt']) {
			echo "<script>
			  		alert('Km pulang tidak bisa lebih kecil dari Km Berangkat !!');
					window.location.href='../media.php?module=kilometer&&act=km_akhir&&id_km=$id_km&&id_mobil=$id_mobil';
				  </script>";
		} else {
			$jarak_tempuh = $km_akhir - $row['km_brkt'];

			$query = mysqli_query($conn, "UPDATE kilometer SET km_plg='$km_akhir', jam_plg='$time_stamp', jarak_tempuh='$jarak_tempuh' WHERE id_km='$id_km'");
			
			header("location:../media.php?module=kilometer");
		}		
		
	} elseif ($_GET['module'] == 'solar1') {
		$id_km = $_POST['id_km'];
		$solar = $_POST['solar'];
		$km_solar = $_POST['km_solar'];
		$harga_solar = $_POST['harga_solar'];
		$id_mobil = $_POST['id_mobil'];
		
		if (($solar == 0) || ($km_solar == 0) || ($harga_solar == 0)) {
			echo "<script>
			  		alert('Litter solar, Km solar dan Harga solar tidak boleh nol');
					window.location.href='../media.php?module=kilometer&&act=input_solar1&&id_km=$id_km&&id_mobil=$id_mobil';
				  </script>";
		}

		$query1 = mysqli_query($conn, "SELECT * FROM kilometer WHERE id_km=$id_km");
		$row = mysqli_fetch_array($query1);

		if ($km_solar > $row['km_plg']) {
			echo "<script>
			  		alert('Km isi solar tidak bisa lebih besar dari Km Pulang !!');
					window.location.href='../media.php?module=kilometer&&act=input_solar1&&id_km=$id_km&&id_mobil=$id_mobil';
				  </script>";
		} else if ($km_solar < $row['km_brkt']) {
			echo "<script>
			  		alert('Km isi solar tidak bisa lebih kecil dari Km Berangkat !!');
					window.location.href='../media.php?module=kilometer&&act=input_solar1&&id_km=$id_km&&id_mobil=$id_mobil';
				  </script>";
		} else {
			$query = mysqli_query($conn, "UPDATE kilometer SET solar_1='$solar', km_solar1='$km_solar', harga_solar1='$harga_solar' WHERE id_km='$id_km'");
			
			$id_rasio = $_POST['id_rasio'];
			$km_awal = $_POST['km_awal'];
			$solarr = $_POST['solarr'];
			$seri_km = $_POST['seri_km'];
			
			if ($km_solar < $km_awal) {
				echo "<script>
			  		alert('Km solar sekarang tidak boleh lebih kecil dari Km solar sebelumnya !!');
					window.location.href='../media.php?module=kilometer&&act=input_solar1&&id_km=$id_km&&id_mobil=$id_mobil';
				  </script>";
			}
			
			$selisih = $km_solar - $km_awal;
			$rasio = $selisih/$solarr;
			
			if ($seri_km == 'km_solar1') {
				$query2 = mysqli_query($conn, "UPDATE kilometer SET rasio_solar1 = '$rasio' WHERE id_km = '$id_rasio'");
			} else if ($seri_km == 'km_solar2') {
				$query2 = mysqli_query($conn, "UPDATE kilometer SET rasio_solar2 = '$rasio' WHERE id_km = '$id_rasio'");
			} else if ($seri_km == 'km_solar3') {
				$query2 = mysqli_query($conn, "UPDATE kilometer SET rasio_solar3 = '$rasio' WHERE id_km = '$id_rasio'");
			}
			
			header("location:../media.php?module=kilometer");
		}
		
	} elseif ($_GET['module'] == 'solar2') {
		$id_km = $_POST['id_km'];
		$solar = $_POST['solar'];
		$km_solar = $_POST['km_solar'];
		$harga_solar = $_POST['harga_solar'];
		$id_mobil = $_POST['id_mobil'];
		
		if (($solar == 0) || ($km_solar == 0) || ($harga_solar == 0)) {
			echo "<script>
			  		alert('Litter solar, Km solar dan Harga solar tidak boleh nol');
					window.location.href='../media.php?module=kilometer&&act=input_solar2&&id_km=$id_km&&id_mobil=$id_mobil';
				  </script>";
		}

		$query1 = mysqli_query($conn, "SELECT * FROM kilometer WHERE id_km=$id_km");
		$row = mysqli_fetch_array($query1);

		if ($km_solar < $row['km_brkt']) {
			echo "<script>
			  		alert('Km isi solar tidak bisa lebih kecil dari Km Berangkat !!');
					window.location.href='../media.php?module=kilometer&&act=input_solar2&&id_km=$id_km&&id_mobil=$id_mobil';
				  </script>";
		} else if ($km_solar <= $row['km_solar1']) {
			echo "<script>
			  		alert('Km solar kedua tidak bisa lebih kecil dari Km solar pertama !!');
					window.location.href='../media.php?module=kilometer&&act=input_solar2&&id_km=$id_km&&id_mobil=$id_mobil';
				  </script>";
		} else if ($km_solar > $row['km_plg']) {
			echo "<script>
			  		alert('Km isi solar tidak bisa lebih besar dari Km Pulang !!');
					window.location.href='../media.php?module=kilometer&&act=input_solar2&&id_km=$id_km&&id_mobil=$id_mobil';
				  </script>";
		} else {
			$selisih = $km_solar - $row['km_solar1'];
			$rasio = $selisih/$row['solar_1'];

			$query = mysqli_query($conn, "UPDATE kilometer SET solar_2='$solar', km_solar2=$km_solar, rasio_solar1='$rasio', harga_solar2='$harga_solar' WHERE id_km='$id_km'");
			
			header("location:../media.php?module=kilometer");
		}
		
	} elseif ($_GET['module'] == 'solar3') {
		$id_km = $_POST['id_km'];
		$solar = $_POST['solar'];
		$km_solar = $_POST['km_solar'];
		$harga_solar = $_POST['harga_solar'];
		$id_mobil = $_POST['id_mobil'];
		
		if (($solar == 0) || ($km_solar == 0) || ($harga_solar == 0)) {
			echo "<script>
			  		alert('Litter solar, Km solar dan Harga solar tidak boleh nol');
					window.location.href='../media.php?module=kilometer&&act=input_solar3&&id_km=$id_km&&id_mobil=$id_mobil';
				  </script>";
		}

		$query1 = mysqli_query($conn, "SELECT * FROM kilometer WHERE id_km=$id_km");
		$row = mysqli_fetch_array($query1);

		if ($km_solar < $row['km_brkt']) {
			echo "<script>
			  		alert('Km isi solar tidak bisa lebih kecil dari Km Berangkat !!');
					window.location.href='../media.php?module=kilometer&&act=input_solar3&&id_km=$id_km&&id_mobil=$id_mobil';
				  </script>";
		} else if ($km_solar <= $row['km_solar1']) {
			echo "<script>
			  		alert('Km solar ketiga tidak bisa lebih kecil dari Km solar pertama !!');
					window.location.href='../media.php?module=kilometer&&act=input_solar3&&id_km=$id_km&&id_mobil=$id_mobil';
				  </script>";
		} else if ($km_solar <= $row['km_solar2']) {
			echo "<script>
			  		alert('Km solar ketiga tidak bisa lebih kecil dari Km solar kedua !!');
					window.location.href='../media.php?module=kilometer&&act=input_solar3&&id_km=$id_km&&id_mobil=$id_mobil';
				  </script>";
		} else if ($km_solar > $row['km_plg']) {
			echo "<script>
			  		alert('Km isi solar tidak bisa lebih besar dari Km Pulang !!');
					window.location.href='../media.php?module=kilometer&&act=input_solar3&&id_km=$id_km&&id_mobil=$id_mobil';
				  </script>";
		} else {			
			$selisih = $km_solar - $row['km_solar2'];
			$rasio = $selisih/$row['solar_2'];

			$query = mysqli_query($conn, "UPDATE kilometer SET solar_3='$solar', km_solar3=$km_solar, rasio_solar2=$rasio, harga_solar3='$harga_solar' WHERE id_km='$id_km'");
			
			header("location:../media.php?module=kilometer");
		}
		
	} elseif ($_GET['module'] == 'hapus') {
		$id_km = $_GET['id_km'];		
		$query = mysqli_query($conn, "DELETE FROM kilometer WHERE id_km='$id_km'");
		header("location:../media.php?module=kilometer");
	}
?>