<?php
	include ("../config/koneksi.php");
	$kode_bkl = $_GET['kode_bkl'];
	if ($_GET['module'] == 'tambah') {
		$kode_bkl = $_POST['kode_bkl'];
		$nama_bkl = $_POST['nama_bkl'];
		$alamat = $_POST['alamat'];
		$no_telp = $_POST['no_telp'];
		$contact_person = $_POST['contact_person'];
		$no_kontrak = $_POST['no_kontrak'];
		$tgl_berlaku_kontrak = $_POST['tgl_berlaku_kontrak'];

		$query = mysqli_query($conn, "INSERT INTO bengkel (kode_bkl, nama_bkl, alamat, no_telp, contact_person, no_kontrak, tgl_berlaku_kontrak)
								VALUES ('$kode_bkl','$nama_bkl','$alamat','$no_telp','$contact_person','$no_kontrak','$tgl_berlaku_kontrak')");
		header("location:../media.php?module=data_bengkel");
	} elseif ($_GET['module'] == 'edit') {
		$kode_bkl = $_POST['kode_bkl'];
		$nama_bkl = $_POST['nama_bkl'];
		$alamat = $_POST['alamat'];
		$no_telp = $_POST['no_telp'];
		$contact_person = $_POST['contact_person'];
		$no_kontrak = $_POST['no_kontrak'];
		$tgl_berlaku_kontrak = $_POST['tgl_berlaku_kontrak'];
		
		$query = mysqli_query($conn, "UPDATE bengkel set nama_bkl='$nama_bkl', alamat='$alamat', no_telp='$no_telp', contact_person='$contact_person', no_kontrak='$no_kontrak', tgl_berlaku_kontrak='$tgl_berlaku_kontrak' WHERE kode_bkl='$kode_bkl'");
		header("location:../media.php?module=data_bengkel");
	} elseif ($_GET['module'] == 'hapus') {
		$query = mysqli_query($conn, "DELETE FROM bengkel WHERE kode_bkl='$kode_bkl'");
		$query2 = mysqli_query($conn, "DELETE FROM kat_service WHERE kode_bkl='$kode_bkl'");
		$query3 = mysqli_query($conn, "DELETE FROM sparepart WHERE kode_bkl='$kode_bkl'");
		header("location:../media.php?module=data_bengkel");
	}
?>