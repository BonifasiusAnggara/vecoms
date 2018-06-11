<?php
	include "../config/koneksi.php";
	include "../phpmailer/class.phpmailer.php";
	include "../phpmailer/class.phpmaileroauth.php";
	include "../phpmailer/class.phpmaileroauthgoogle.php";
	include "../phpmailer/class.smtp.php";
	date_default_timezone_set("Asia/Jakarta");

	if ($_GET['module'] == 'tambah') {
		$kode_spr = $_POST['kode_spr'];
		$id_bkl = $_POST['id_bkl'];		
		$id_mobil = $_POST['id_mobil'];
		$kodeuser = $_POST['kode_user'];

		if (($id_mobil == 0) OR ($id_bkl== 0)) {
			echo "<script>
			  		alert('Maaf, tidak boleh ada field yang kosong !!');
					window.location.href='../media.php?module=ganti_sparepart&&act=tambah';
				  </script>";
		} else {
			$query1 = mysqli_query($conn, "SELECT * FROM user_man WHERE kodeUser='$kodeuser'");
			$row = mysqli_fetch_array($query1);
			$email = $row['email'];
			$nama = $row['first_name']." ".$row['last_name'];

			$query2 = mysqli_query($conn, "SELECT * FROM mobil WHERE id_mobil='$id_mobil'");
			$r = mysqli_fetch_array($query2);
			$plat_no = $r['plat_no'];

			$query = mysqli_query($conn, "INSERT INTO ganti_sparepart (kode_spr, id_bkl, id_mobil, kodeuser) VALUES ('$kode_spr','$id_bkl','$id_mobil','$kodeuser')");
			require_once("request.php");
			header("location:../media.php?module=ganti_sparepart");
		}

	} elseif ($_GET['module'] == 'input_sparepart') {
		$kode_spr = $_POST['kode_spr'];
		$id_mobil = $_POST['id_mobil'];

		$id_sprt = $_POST['id_sprt'];
		$nama_sprt = $_POST['nama_sprt'];
		$harga_sprt = $_POST['harga_sprt'];
		$masa_ganti = $_POST['masa_ganti'];
		$jumlah = $_POST['jumlah'];
		$total_harga = $harga_sprt*$jumlah;
		$tax = .1 * $total_harga;

		$tglwaktu = $_POST['tgl_awal'];
		$tgl = explode(" ", $tglwaktu);
		$tgl_awal = strtotime($tgl[0]);
		$tgl_skrg = strtotime(date('Y-m-d'));
		$diff = abs($tgl_skrg-$tgl_awal);
		$hari = floor($diff/86400);

		if ($nama_sprt == "Ban") {
			if ($hari < $masa_ganti) {
				echo "<script>
					alert('Selisih hari untuk Ganti Ban mobil ini belum ".$masa_ganti." Hari !!');
					window.location.href='../media.php?module=ganti_sparepart&&act=input_sparepart&&kode_spr=$kode_spr&&id_mobil=$id_mobil';
				  </script>";
			} else {
				$ban_array = $_POST['kode_ban'];

				foreach ($ban_array as $one_ban) {
					$source .= $one_ban.",";
				}

				$kode_ban = substr($source,0,-1);

				$query = mysqli_query($conn, "INSERT INTO detail_gs (kode_spr, id_mobil, id_sprt, nama_sprt, arr_kode_ban, harga_sprt, jumlah, tax) VALUES ('$kode_spr','$id_mobil','$id_sprt','$nama_sprt','$kode_ban','$harga_sprt','$jumlah','$tax')");
				$query2 = mysqli_query($conn, "SELECT * FROM ganti_sparepart WHERE kode_spr='$kode_spr'");
				$row = mysqli_fetch_array($query2);
				$harga_awal = $row['cost_est']; 
				$tax_awal = $row['tax'];
				$harga_baru = $harga_awal+$total_harga; 
				$tax_baru = $tax_awal+$tax;
				$query3 = mysqli_query($conn, "UPDATE ganti_sparepart SET cost_est='$harga_baru', tax='$tax_baru' WHERE kode_spr='$kode_spr'");
				header("location:../media.php?module=ganti_sparepart");
			}
		} elseif ($nama_sprt == "Ban Truck") {
			if ($hari < $masa_ganti) {
				echo "<script>
					alert('Selisih hari untuk Ganti Ban mobil ini belum ".$masa_ganti." Hari !!');
					window.location.href='../media.php?module=ganti_sparepart&&act=input_sparepart&&kode_spr=$kode_spr&&id_mobil=$id_mobil';
				  </script>";
			} else {
				$ban_array = $_POST['kode_ban'];

				foreach ($ban_array as $one_ban) {
					$source .= $one_ban.",";
				}

				$kode_ban = substr($source,0,-1);

				$query = mysqli_query($conn, "INSERT INTO detail_gs (kode_spr, id_mobil, id_sprt, nama_sprt, arr_kode_ban, harga_sprt, jumlah, tax) VALUES ('$kode_spr','$id_mobil','$id_sprt','$nama_sprt','$kode_ban','$harga_sprt','$jumlah','$tax')");
				$query2 = mysqli_query($conn, "SELECT * FROM ganti_sparepart WHERE kode_spr='$kode_spr'");
				$row = mysqli_fetch_array($query2);
				$harga_awal = $row['cost_est']; 
				$tax_awal = $row['tax'];
				$harga_baru = $harga_awal+$total_harga; 
				$tax_baru = $tax_awal+$tax;
				$query3 = mysqli_query($conn, "UPDATE ganti_sparepart SET cost_est='$harga_baru', tax='$tax_baru' WHERE kode_spr='$kode_spr'");
				header("location:../media.php?module=ganti_sparepart");
			}
		} else {
			if ($hari < $masa_ganti) {
				echo "<script>
					alert('Selisih hari untuk Ganti ".$nama_sprt." ini belum ".$masa_ganti." Hari !!');
					window.location.href='../media.php?module=ganti_sparepart&&act=input_sparepart&&kode_spr=$kode_spr&&id_mobil=$id_mobil';
				  </script>";
			} else {
				$query = mysqli_query($conn, "INSERT INTO detail_gs (kode_spr, id_mobil, id_sprt, nama_sprt, harga_sprt, jumlah, tax) VALUES ('$kode_spr','$id_mobil','$id_sprt','$nama_sprt','$harga_sprt','$jumlah','$tax')");
				$query2 = mysqli_query($conn, "SELECT * FROM ganti_sparepart WHERE kode_spr='$kode_spr'");
				$row = mysqli_fetch_array($query2);
				$harga_awal = $row['cost_est']; 
				$tax_awal = $row['tax'];
				$harga_baru = $harga_awal+$total_harga; 
				$tax_baru = $tax_awal+$tax;
				$query3 = mysqli_query($conn, "UPDATE ganti_sparepart SET cost_est='$harga_baru', tax='$tax_baru' WHERE kode_spr='$kode_spr'");
				header("location:../media.php?module=ganti_sparepart");
			}
		}
	} elseif ($_GET['module'] == "approve_1") {
		$kode_spr = $_GET['kode_spr'];
		$time_stamp = date("Y-m-d H:i:s");
		$kodeusers = $_GET['kodeuser'];

		$query4 = mysqli_query($conn, "SELECT * FROM user_man WHERE kodeUser='$kodeusers'");
		$users = mysqli_fetch_array($query4);
		$emails = $users['email'];
		$namas = $users['first_name']." ".$users['last_name'];

		$query = mysqli_query($conn, "SELECT * FROM ganti_sparepart WHERE kode_spr='$kode_spr'");
		$spr = mysqli_fetch_array($query);
		$id_mobil = $spr['id_mobil'];
		$kodeuser = $spr['kodeuser'];

		$query1 = mysqli_query($conn, "SELECT * FROM user_man WHERE kodeUser='$kodeuser'");
		$user = mysqli_fetch_array($query1);
		$email = $user['email'];
		$nama = $user['first_name']." ".$user['last_name'];

		$query2 = mysqli_query($conn, "SELECT * FROM mobil WHERE id_mobil='$id_mobil'");
		$mbl = mysqli_fetch_array($query2);
		$plat_no = $mbl['plat_no'];

		$query3 = mysqli_query($conn, "UPDATE ganti_sparepart SET status='APPROVED_1', app1_date='$time_stamp' WHERE kode_spr='$kode_spr'");
		require_once("approve_1.php");
		header("location:../media.php?module=ganti_sparepart");
	} elseif ($_GET['module'] == "approve_2") {
		$kode_spr = $_GET['kode_spr'];
		$time_stamp = date("Y-m-d H:i:s");
		$kodeusers = $_GET['kodeuser'];

		$query4 = mysqli_query($conn, "SELECT * FROM user_man WHERE kodeUser='$kodeusers'");
		$users = mysqli_fetch_array($query4);
		$emails = $users['email'];
		$namas = $users['first_name']." ".$users['last_name'];

		$query = mysqli_query($conn, "SELECT * FROM ganti_sparepart WHERE kode_spr='$kode_spr'");
		$spr = mysqli_fetch_array($query);
		$kodeuser = $spr['kodeuser'];
		$id_mobil = $spr['id_mobil'];

		$query1 = mysqli_query($conn, "SELECT * FROM user_man WHERE kodeUser='$kodeuser'");
		$user = mysqli_fetch_array($query1);
		$email = $user['email'];
		var_dump($email);
		$nama = $user['first_name']." ".$user['last_name'];

		$query2 = mysqli_query($conn, "SELECT * FROM mobil WHERE id_mobil='$id_mobil'");
		$mbl = mysqli_fetch_array($query2);
		$plat_no = $mbl['plat_no'];

		$query3 = mysqli_query($conn, "UPDATE ganti_sparepart SET status='APPROVED_2', app2_date='$time_stamp' WHERE kode_spr='$kode_spr'");
		require_once("approve_2.php");
		header("location:../media.php?module=ganti_sparepart");
	} elseif ($_GET['module'] == 'hapus') {
		$kode_spr = $_GET['kode_spr'];		
		$query = mysqli_query($conn, "DELETE FROM ganti_sparepart WHERE kode_spr='$kode_spr'");
		$query2 = mysqli_query($conn, "DELETE FROM detail_gs WHERE kode_spr='$kode_spr'");
		header("location:../media.php?module=ganti_sparepart");
	} elseif ($_GET['module'] == "close") {
		$kode_spr = $_GET['kode_spr'];
		$time_stamp = date("Y-m-d H:i:s");
		$query3 = mysqli_query($conn, "UPDATE ganti_sparepart SET status='CLOSED', closed_date='$time_stamp' WHERE kode_spr='$kode_spr'");
		header("location:../media.php?module=ganti_sparepart");
	} elseif ($_GET['module'] == 'cost_real') {
		$kode_spr = $_POST['kode_spr'];	
		$cost_real = $_POST['cost_real'];
		$query3 = mysqli_query($conn, "UPDATE ganti_sparepart SET cost_real='$cost_real' WHERE kode_spr='$kode_spr'");
		header("location:../media.php?module=ganti_sparepart");
	}
?>