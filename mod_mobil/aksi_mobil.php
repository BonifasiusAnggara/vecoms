<?php
	include ("../config/koneksi.php");
	include ("../config/fungsi_thumb.php");

	if ($_GET['module'] == 'tambah') {
		$plat_no = $_POST['plat_no'];
		$no_mesin = $_POST['no_mesin'];
		$no_rangka = $_POST['no_rangka'];
		$no_bpkb = $_POST['no_bpkb'];
		$id_dir = $_POST['id_dir'];
		$id_peg = $_POST['id_peg'];
		$type = $_POST['type'];
		$type_code = $_POST['type_code'];
		$ms_ber_stnk = $_POST['ms_ber_stnk'];
		$ms_ber_keur = $_POST['ms_ber_keur'];
		$photo = $_FILES['fupload']['name'];
		uploadFotoMobil($photo);
		$cek = mysqli_query($conn, "SELECT * FROM mobil WHERE plat_no = '$plat_no'");
		$num = mysqli_num_rows($cek);
		if ($num >= 1) {
			echo "<script>
					alert('Data mobil sudah ada!');
					window.location.href='../media.php?module=data_mobil';
				  </script>";
		} else {
			$query = mysqli_query($conn, "INSERT INTO mobil (plat_no,no_mesin,no_rangka,no_bpkb,id_dir,id_peg,type,type_code,ms_ber_stnk,ms_ber_keur,photo)
									VALUES('$plat_no','$no_mesin','$no_rangka','$no_bpkb','$id_dir','$id_peg','$type','$type_code','$ms_ber_stnk','$ms_ber_keur','$photo')");
			header("location:../media.php?module=data_mobil");
		}
	} elseif ($_GET['module'] == 'hapus') {
		$id_mobil = $_GET['id_mobil'];
		$query = mysqli_query($conn, "DELETE FROM mobil WHERE id_mobil='$id_mobil'");
		$query1 = mysqli_query($conn, "DELETE FROM service WHERE id_mobil='$id_mobil'");
		$query2 = mysqli_query($conn, "DELETE FROM detail_service WHERE id_mobil='$id_mobil'");
		$query3 = mysqli_query($conn, "DELETE FROM ganti_sparepart WHERE id_mobil='$id_mobil'");
		$query4 = mysqli_query($conn, "DELETE FROM detail_gs WHERE id_mobil='$id_mobil'");
		$query5 = mysqli_query($conn, "DELETE FROM kilometer WHERE id_mobil='$id_mobil'");
		$query6 = mysqli_query($conn, "DELETE FROM bensin WHERE id_mobil='$id_mobil'");
		header("location:../media.php?module=data_mobil");
	} elseif ($_GET['module'] == 'edit') {
		$id_mobil = $_POST['id_mobil'];
		$no_mesin = $_POST['no_mesin'];
		$no_rangka = $_POST['no_rangka'];
		$no_bpkb = $_POST['no_bpkb'];
		$plat_no = $_POST['plat_no'];
		$id_dir = $_POST['id_dir'];
		$id_peg = $_POST['id_peg'];
		$type = $_POST['type'];
		$type_code = $_POST['type_code'];
		$ms_ber_stnk = $_POST['ms_ber_stnk'];
		$ms_ber_keur = $_POST['ms_ber_keur'];
		$photo = $_FILES['fupload']['name'];
		uploadFotoMobil($photo);
		if (empty($photo)) {
			$query = mysqli_query($conn, "UPDATE mobil SET plat_no='$plat_no', no_mesin='$no_mesin', no_rangka='$no_rangka', no_bpkb='$no_bpkb', id_dir='$id_dir', id_peg='$id_peg', type='$type', type_code='$type_code', ms_ber_stnk='$ms_ber_stnk', ms_ber_keur='$ms_ber_keur' WHERE id_mobil='$id_mobil'");
			header("location:../media.php?module=data_mobil");
		} else {
			$query = mysqli_query($conn, "UPDATE mobil SET plat_no='$plat_no', no_mesin='$no_mesin', no_rangka='$no_rangka', no_bpkb='$no_bpkb', id_dir='$id_dir', id_peg='$id_peg', type='$type', type_code='$type_code', ms_ber_stnk='$ms_ber_stnk', ms_ber_keur='$ms_ber_keur', photo='$photo' WHERE id_mobil='$id_mobil'");
			header("location:../media.php?module=data_mobil");
		}
	} elseif ($_GET['module'] == 'seri_ban') {
		$id_mobil = $_POST['id_mobil'];
		$time_stamp = date("Y-m-d H:i:s");
		$no_seri_ban_a = $_POST['no_seri_ban_a'];
		$no_seri_ban_b = $_POST['no_seri_ban_b'];
		$no_seri_ban_c = $_POST['no_seri_ban_c'];
		$no_seri_ban_d = $_POST['no_seri_ban_d'];
		$no_seri_ban_e = $_POST['no_seri_ban_e'];

		$query1 = mysqli_query($conn, "SELECT * FROM mobil WHERE id_mobil='$id_mobil'");
		$row = mysqli_fetch_array($query1);

		if ($row['no_seri_ban_a'] != $no_seri_ban_a) {
			$query = mysqli_query($conn, "UPDATE mobil SET no_seri_ban_a='$no_seri_ban_a', tgl_ganti_ban_a='$time_stamp' WHERE id_mobil='$id_mobil'");
		}

		if ($row['no_seri_ban_b'] != $no_seri_ban_b) {
			$query = mysqli_query($conn, "UPDATE mobil SET no_seri_ban_b='$no_seri_ban_b', tgl_ganti_ban_b='$time_stamp' WHERE id_mobil='$id_mobil'");
		}

		if ($row['no_seri_ban_c'] != $no_seri_ban_c) {
			$query = mysqli_query($conn, "UPDATE mobil SET no_seri_ban_c='$no_seri_ban_c', tgl_ganti_ban_c='$time_stamp' WHERE id_mobil='$id_mobil'");
		}

		if ($row['no_seri_ban_d'] != $no_seri_ban_d) {
			$query = mysqli_query($conn, "UPDATE mobil SET no_seri_ban_d='$no_seri_ban_d', tgl_ganti_ban_d='$time_stamp' WHERE id_mobil='$id_mobil'");
		}	

		if ($row['no_seri_ban_e'] != $no_seri_ban_e) {
			$query = mysqli_query($conn, "UPDATE mobil SET no_seri_ban_e='$no_seri_ban_e', tgl_ganti_ban_e='$time_stamp' WHERE id_mobil='$id_mobil'");
		}

		header("location:../media.php?module=data_mobil");
	}
?>