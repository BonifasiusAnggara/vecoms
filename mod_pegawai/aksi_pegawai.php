<?php
	include ("../config/koneksi.php");

	if ($_GET['module'] == 'tambah') {
		$id_dir = $_POST['id_dir'];
		$nip = $_POST['nip'];
		$nama_peg = $_POST['nama_peg'];		
		$jabatan = $_POST['jabatan'];
		$golongan = $_POST['golongan'];
		$tpt_lhr = $_POST['tpt_lhr'];
		$tgl_lhr = $_POST['tgl_lhr'];
		$alamat = $_POST['alamat'];
		$no_hp = $_POST['no_hp'];
		$no_sim = $_POST['no_sim'];
		$tgl_ber_sim = $_POST['tgl_ber_sim'];

		$query = mysqli_query($conn, "INSERT INTO pegawai (id_dir,NIP,nama_peg,jabatan,golongan,tpt_lhr,tgl_lhr,alamat,no_hp,no_sim,tgl_ber_sim)
								VALUES('$id_dir','$nip','$nama_peg','$jabatan','$golongan','$tpt_lhr','$tgl_lhr','$alamat','$no_hp','$no_sim','$tgl_ber_sim')");
		header("location:../media.php?module=data_pegawai");
	} elseif ($_GET['module'] == 'edit') {
		$id_peg = $_POST['id_peg'];
		$id_dir = $_POST['id_dir'];
		$nip = $_POST['nip'];
		$nama_peg = $_POST['nama_peg'];		
		$jabatan = $_POST['jabatan'];
		$golongan = $_POST['golongan'];
		$tpt_lhr = $_POST['tpt_lhr'];
		$tgl_lhr = $_POST['tgl_lhr'];
		$alamat = $_POST['alamat'];
		$no_hp = $_POST['no_hp'];
		$no_sim = $_POST['no_sim'];
		$tgl_ber_sim = $_POST['tgl_ber_sim'];

		$query = mysqli_query($conn, "UPDATE pegawai SET id_dir='$id_dir', nip='$nip', nama_peg='$nama_peg', jabatan='$jabatan', golongan='$golongan', tpt_lhr='$tpt_lhr', tgl_lhr='$tgl_lhr', alamat='$alamat', no_hp='$no_hp', no_sim='$no_sim', tgl_ber_sim='$tgl_ber_sim' WHERE id_peg='$id_peg'");
		header("location:../media.php?module=data_pegawai");
	} elseif ($_GET['module'] == 'hapus') {
		$id_pegawai = $_GET['id_pegawai'];
		$query = mysqli_query($conn, "DELETE FROM pegawai WHERE id_peg='$id_pegawai'");
		header("location:../media.php?module=data_pegawai");
	}
?>