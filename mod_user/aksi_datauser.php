<?php
	include ("../config/koneksi.php");
	include ("../config/fungsi_thumb.php");
	if ($_GET['module'] == 'tambah') {
		$t1 = $_POST['t1'];
		$t2 = $_POST['t2'];
		$t3 = $_POST['t3'];
		$t4 = $_POST['t4'];
		$t5 = $_POST['t5'];
		$t6 = $_POST['t6'];
		$t7 = $_POST['t7'];
		$t8 = $_POST['t8'];
		$t9 = sha1($_POST['t9']);
		$t10 = $_POST['t10'];
		$level = $_POST['level'];
		$photo = $_FILES['fupload']['name'];
		uploadFoto($photo);
		$query = mysqli_query($conn, "INSERT INTO user_man (kodeUser, first_name, last_name, jk, alamat, no_hp, tgl_lahir, username, password, email, photo, akses)
								VALUES ('$t1','$t2','$t3','$t4','$t5','$t6','$t7','$t8','$t9','$t10','$photo','$level')");
		header("location:../media.php?module=data_user");

	} else if ($_GET['module'] == 'hapus') {
		$iduser = $_GET['iduser'];
		$query = mysqli_query($conn, "DELETE FROM user_man WHERE id_user='$iduser'");
		header("location:../media.php?module=data_user");

	} else if ($_GET['module'] == 'ganti_pass') {
		$kodeuser = $_POST['kodeUser'];
		$pas_old = sha1($_POST['pas_old']);
		$pas_new = sha1($_POST['pas_new']);
		$query = mysqli_query($conn, "SELECT * FROM user_man WHERE kodeUser='$kodeuser' AND password='$pas_old'");
		$num = mysqli_num_rows($query);
		if ($num >= 1) {
			$query_ubah = mysqli_query($conn, "UPDATE user_man SET password='$pas_new' WHERE kodeUser='$kodeuser'");
?>
		<script type="text/javascript">
			alert('Password berhasil diubah');
			window.location.href='../media.php?module=home';
		</script>
<?php
		} else {
?>
			<script type="text/javascript">
				alert('Password lama anda salah ! \n Coba lagi !');
				window.location.href='../media.php?module=home';
			</script>
<?php
		}
	} else if ($_GET['module'] == 'edit') {
		$t1 = $_POST['t1'];
		$t2 = $_POST['t2'];
		$t3 = $_POST['t3'];
		$t4 = $_POST['t4'];
		$t5 = $_POST['t5'];
		$t6 = $_POST['t6'];
		$t7 = $_POST['t7'];
		$t8 = $_POST['t8'];
		$t9 = sha1($_POST['t9']);
		$t10 = $_POST['t10'];
		$level = $_POST['level'];
		$photo = $_FILES['fupload']['name'];
		uploadFoto($photo);

		if (empty($photo)) {
			$query = mysqli_query($conn, "UPDATE user_man SET first_name='$t2', last_name='$t3', jk='$t4', alamat='$t5', no_hp='$t6', tgl_lahir='$t7',
									username='$t8', password='$t9', email='$t10', akses='$level' WHERE kodeUser='$t1'");
			header("location:../media.php?module=data_user");
		} else {
			$query = mysqli_query($conn, "UPDATE user_man SET first_name='$t2', last_name='$t3', jk='$t4', alamat='$t5', no_hp='$t6', tgl_lahir='$t7',
									username='$t8', password='$t9', email='$t10', photo='$photo', akses='$level' WHERE kodeUser='$t1'");
			header("location:../media.php?module=data_user");
		}
	}
?>