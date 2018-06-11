<?php
	include ("../config/koneksi.php");
	date_default_timezone_set("Asia/Jakarta");

	if ($_GET['module'] == 'tambah') {
		$kode_svc = $_POST['kode_svc'];
		$id_bkl = $_POST['id_bkl'];		
		$id_mobil = $_POST['id_mobil'];
		$kodeuser = $_POST['kode_user'];

		if (($id_mobil == 0) OR ($id_bkl== 0)) {
			echo "<script>
			  		alert('Maaf, tidak boleh ada field yang kosong !!');
					window.location.href='../media.php?module=service_mobil&&act=tambah';
				  </script>";
		} else {
			$query1 = mysqli_query($conn, "SELECT * FROM user_man WHERE kodeUser='$kodeuser'");
			$row = mysqli_fetch_array($query1);
			$email = $row['email'];
			$nama = $row['first_name']." ".$row['last_name'];

			$query2 = mysqli_query($conn, "SELECT * FROM mobil WHERE id_mobil='$id_mobil'");
			$r = mysqli_fetch_array($query2);
			$plat_no = $r['plat_no'];
			$query = mysqli_query($conn, "INSERT INTO service (kode_svc, id_bkl, id_mobil, kodeuser) VALUES ('$kode_svc','$id_bkl','$id_mobil','$kodeuser')");
			require_once("request.php");
			header("location:../media.php?module=service_mobil");
		}
		
	} elseif ($_GET['module'] == 'input_service') {
		$kode_svc = $_POST['kode_svc'];
		$id_mobil = $_POST['id_mobil'];
		
		$id_serv = $_POST['id_serv'];
		$harga_serv = $_POST['harga_serv'];
		$masa_serv = $_POST['masa_serv'];
		$tax = .1 * $harga_serv;
		$nama_serv = $_POST['nama_serv'];

		$km = $_POST['km'];
		$km_awal = $_POST['km_awal'];
		$filter = $km-$km_awal;

		if ($filter < $masa_serv) {
			echo "<script>
		  		alert('Selisih kilometer untuk ".$nama_serv." mobil ini belum mencapai ".$masa_serv." !!');
				window.location.href='../media.php?module=service_mobil&&act=input_service&&kode_svc=$kode_svc&&id_mobil=$id_mobil';					
			  </script>";
		} else {
			$query = mysqli_query($conn, "INSERT INTO detail_service (kode_svc, id_mobil, km, id_serv, nama_serv, harga_serv, tax) VALUES ('$kode_svc','$id_mobil','$km','$id_serv','$nama_serv','$harga_serv','$tax')");
			$query2 = mysqli_query($conn, "SELECT * FROM service WHERE kode_svc='$kode_svc'");
			$row = mysqli_fetch_array($query2);
			$harga_awal = $row['cost_est'];
			$tax_awal = $row['tax'];
			$harga_baru = $harga_awal+$harga_serv;
			$tax_baru = $tax_awal+$tax;
			$query3 = mysqli_query($conn, "UPDATE service SET cost_est='$harga_baru', tax='$tax_baru' WHERE kode_svc='$kode_svc'");
			header("location:../media.php?module=service_mobil");
		}
		
	} elseif ($_GET['module'] == "approve_1") {
		$kode_svc = $_GET['kode_svc'];
		$time_stamp = date("Y-m-d H:i:s");
		$kodeusers = $_GET['kodeuser'];

		$query4 = mysqli_query($conn, "SELECT * FROM user_man WHERE kodeUser='$kodeusers'");
		$users = mysqli_fetch_array($query4);
		$emails = $users['email'];
		$namas = $users['first_name']." ".$users['last_name'];

		$query = mysqli_query($conn, "SELECT * FROM service WHERE kode_svc='$kode_svc'");
		$svc = mysqli_fetch_array($query);
		$id_mobil = $svc['id_mobil'];
		$kodeuser = $svc['kodeuser'];

		$query1 = mysqli_query($conn, "SELECT * FROM user_man WHERE kodeUser='$kodeuser'");
		$user = mysqli_fetch_array($query1);
		$email = $user['email'];
		$nama = $user['first_name']." ".$user['last_name'];

		$query2 = mysqli_query($conn, "SELECT * FROM mobil WHERE id_mobil='$id_mobil'");
		$mbl = mysqli_fetch_array($query2);
		$plat_no = $mbl['plat_no'];

		$query3 = mysqli_query($conn, "UPDATE service SET status='APPROVED_1', app1_date='$time_stamp' WHERE kode_svc='$kode_svc'");
		require_once("approve_1.php");
		header("location:../media.php?module=service_mobil");
	} elseif ($_GET['module'] == "approve_2") {
		$kode_svc = $_GET['kode_svc'];
		$time_stamp = date("Y-m-d H:i:s");
		$kodeusers = $_GET['kodeuser'];

		$query4 = mysqli_query($conn, "SELECT * FROM user_man WHERE kodeUser='$kodeusers'");
		$users = mysqli_fetch_array($query4);
		$emails = $users['email'];
		$namas = $users['first_name']." ".$users['last_name'];

		$query = mysqli_query($conn, "SELECT * FROM service WHERE kode_svc='$kode_svc'");
		$svc = mysqli_fetch_array($query);
		$kodeuser = $svc['kodeuser'];
		$id_mobil = $svc['id_mobil'];

		$query1 = mysqli_query($conn, "SELECT * FROM user_man WHERE kodeUser='$kodeuser'");
		$user = mysqli_fetch_array($query1);
		$email = $user['email'];
		$nama = $user['first_name']." ".$user['last_name'];

		$query2 = mysqli_query($conn, "SELECT * FROM mobil WHERE id_mobil='$id_mobil'");
		$mbl = mysqli_fetch_array($query2);
		$plat_no = $mbl['plat_no'];
		$query3 = mysqli_query($conn, "UPDATE service SET status='APPROVED_2', app2_date='$time_stamp' WHERE kode_svc='$kode_svc'");
		require_once("approve_2.php");
		header("location:../media.php?module=service_mobil");
	} elseif ($_GET['module'] == 'hapus') {
		$kode_svc = $_GET['kode_svc'];		
		$query = mysqli_query($conn, "DELETE FROM service WHERE kode_svc='$kode_svc'");
		$query2 = mysqli_query($conn, "DELETE FROM detail_service WHERE kode_svc='$kode_svc'");
		header("location:../media.php?module=service_mobil");
	} elseif ($_GET['module'] == "close") {
		$kode_svc = $_GET['kode_svc'];
		$time_stamp = date("Y-m-d H:i:s");
		$query3 = mysqli_query($conn, "UPDATE service SET status='CLOSED', closed_date='$time_stamp' WHERE kode_svc='$kode_svc'");
		header("location:../media.php?module=service_mobil");
	} elseif ($_GET['module'] == 'cost_real') {
		$kode_svc = $_POST['kode_svc'];	
		$cost_real = $_POST['cost_real'];
		$query3 = mysqli_query($conn, "UPDATE service SET cost_real='$cost_real' WHERE kode_svc='$kode_svc'");
		header("location:../media.php?module=service_mobil");
	}
?>