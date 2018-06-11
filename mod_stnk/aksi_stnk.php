<?php
	include ("../config/koneksi.php");
	date_default_timezone_set("Asia/Jakarta");

	if ($_GET['module'] == 'tambah') {
		$kode_perp_stnk = $_POST['kode_perp_stnk'];	
		$id_mobil = $_POST['id_mobil'];
		$cost_est = $_POST['cost_est'];
		$kodeuser = $_POST['kode_user'];

		if ($id_mobil == 0) {
			echo "<script>
			  		alert('Maaf, tidak boleh ada field yang kosong !!');
					window.location.href='../media.php?module=stnk&&act=tambah';
				  </script>";
		} else {
			$query1 = mysqli_query($conn, "SELECT * FROM user_man WHERE kodeUser='$kodeuser'");
			$row = mysqli_fetch_array($query1);
			$email = $row['email'];
			$nama = $row['first_name']." ".$row['last_name'];

			$query2 = mysqli_query($conn, "SELECT * FROM mobil WHERE id_mobil='$id_mobil'");
			$r = mysqli_fetch_array($query2);
			$plat_no = $r['plat_no'];
			$query = mysqli_query($conn, "INSERT INTO perp_stnk (kode_perp_stnk, id_mobil, cost_est, kodeuser) VALUES ('$kode_perp_stnk','$id_mobil','$cost_est','$kodeuser')");
			require_once("request.php");
			header("location:../media.php?module=stnk");
		}
		
	} elseif ($_GET['module'] == "approve_1") {
		$kode_perp_stnk = $_GET['kode_perp_stnk'];
		$time_stamp = date("Y-m-d H:i:s");
		$kodeusers = $_GET['kodeuser'];

		$query4 = mysqli_query($conn, "SELECT * FROM user_man WHERE kodeUser='$kodeusers'");
		$users = mysqli_fetch_array($query4);
		$emails = $users['email'];
		$namas = $users['first_name']." ".$users['last_name'];

		$query = mysqli_query($conn, "SELECT * FROM perp_stnk WHERE kode_perp_stnk='$kode_perp_stnk'");
		$stnk = mysqli_fetch_array($query);
		$id_mobil = $stnk['id_mobil'];
		$kodeuser = $stnk['kodeuser'];

		$query1 = mysqli_query($conn, "SELECT * FROM user_man WHERE kodeUser='$kodeuser'");
		$user = mysqli_fetch_array($query1);
		$email = $user['email'];
		$nama = $user['first_name']." ".$user['last_name'];

		$query2 = mysqli_query($conn, "SELECT * FROM mobil WHERE id_mobil='$id_mobil'");
		$mbl = mysqli_fetch_array($query2);
		$plat_no = $mbl['plat_no'];

		$query3 = mysqli_query($conn, "UPDATE perp_stnk SET status='APPROVED_1', app1_date='$time_stamp' WHERE kode_perp_stnk='$kode_perp_stnk'");
		require_once("approve_1.php");
		header("location:../media.php?module=stnk");
	} elseif ($_GET['module'] == "approve_2") {
		$kode_perp_stnk = $_GET['kode_perp_stnk'];
		$time_stamp = date("Y-m-d H:i:s");
		$kodeusers = $_GET['kodeuser'];

		$query4 = mysqli_query($conn, "SELECT * FROM user_man WHERE kodeUser='$kodeusers'");
		$users = mysqli_fetch_array($query4);
		$emails = $users['email'];
		$namas = $users['first_name']." ".$users['last_name'];

		$query = mysqli_query($conn, "SELECT * FROM perp_stnk WHERE kode_perp_stnk='$kode_perp_stnk'");
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
		$query3 = mysqli_query($conn, "UPDATE perp_stnk SET status='APPROVED_2', app2_date='$time_stamp' WHERE kode_perp_stnk='$kode_perp_stnk'");
		require_once("approve_2.php");
		header("location:../media.php?module=stnk");
	} elseif ($_GET['module'] == 'hapus') {
		$kode_perp_stnk = $_GET['kode_perp_stnk'];		
		$query = mysqli_query($conn, "DELETE FROM perp_stnk WHERE kode_perp_stnk='$kode_perp_stnk'");
		header("location:../media.php?module=stnk");
	} elseif ($_GET['module'] == "close") {
		$kode_perp_stnk = $_GET['kode_perp_stnk'];
		$time_stamp = date("Y-m-d H:i:s");
		$query3 = mysqli_query($conn, "UPDATE perp_stnk SET status='CLOSED', closed_date='$time_stamp' WHERE kode_perp_stnk='$kode_perp_stnk'");
		header("location:../media.php?module=stnk");
	} elseif ($_GET['module'] == 'cost_real') {
		$kode_perp_stnk = $_POST['kode_perp_stnk'];	
		$cost_real = $_POST['cost_real'];
		$query3 = mysqli_query($conn, "UPDATE perp_stnk SET cost_real='$cost_real' WHERE kode_perp_stnk='$kode_perp_stnk'");
		header("location:../media.php?module=stnk");
	}
?>