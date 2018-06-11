<?php
	session_start();
	if (empty($_SESSION['iduser'])) {
		echo "<script type='text/javascript'>
				alert('Mohon maaf, Silakan Login terlebih dahulu !!');
				window.location.href='index.php';
			  </script>";
	} elseif (isset($_SESSION['iduser'])) {
		include ("config/koneksi.php");
		include ("config/akses.php");
		include ("config/class_paging.php");
		include("config/fungsi_indotgl.php");
		include("config/fungsi_rupiah.php");

		$akses = $_SESSION['akses'];
		$kodeuser = $_SESSION['kodeuser'];
		error_reporting(E_ALL^(E_NOTICE));
?>
	<!DOCTYPE html>
	<html lang="id">
	<head>
		<title><?php include ("config/title.php");?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="assets/css/custom.css" media="screen">
		<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" media="screen">
		<link rel="stylesheet" type="text/css" href="assets/css/bootstrap-responsive.min.css">
		<link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="assets/js/jquery-ui/jquery-ui.css">
		<script type="text/javascript" src="assets/js/jquery.js"></script>
		<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="assets/js/jquery-ui/jquery-ui.js"></script>
		<link rel="shortcut icon" type="text/css" href="assets/logo/Logo Enseval Crop.jpg">
	</head>
	<body>
		<header>
			<div class="navbar">
				<div class="navbar-inner">
					<div class="container">
						<!-- Menampilkan tombol trigger -->
						<a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</a>
						<!-- Akhir dari tombol trigger -->

						<!-- Komponen Navbar -->
						<div class="nav-collapse collapse navbar-responsive-collapse">
							<ul class="nav">
								<li <?php if ($_GET['module'] == "home") { ?> class="active" <?php } ?>><a href="media.php?module=home"><i class="fa fa-home"></i> Home</a></li>

							<?php if ($akses == '3') { ?>
								<li <?php if ($_GET['module'] == "data_user") { ?> class="active" <?php } ?>><a href="media.php?module=data_user"><i class="fa fa-users"></i> Data User</a></li>
							<?php } ?>

							<?php if ($akses == '3') { ?>
								<li <?php if ($_GET['module'] == "data_pegawai") { ?> class="active" <?php } ?>><a href="media.php?module=data_pegawai"><i class="fa fa-users"></i> Data Pegawai</a></li>
							<?php } ?>
							
								<li <?php if ($_GET['module'] == "data_mobil") { ?> class="active" <?php } ?>><a href="media.php?module=data_mobil"><i class="fa fa-car"></i> Data Mobil</a></li>

								<li <?php if ($_GET['module'] == "data_bengkel") { ?> class="active" <?php } ?>><a href="media.php?module=data_bengkel"><i class="fa fa-sitemap"></i> Data Bengkel</a></li>

								<li <?php if ($_GET['module'] == "service") { ?> class="active" <?php } ?>><a href="media.php?module=service"><i class="fa fa-wrench"></i> Kategori Service</a></li>

								<li <?php if ($_GET['module'] == "data_sparepart") { ?> class="active" <?php } ?>><a href="media.php?module=data_sparepart"><i class="fa fa-shopping-basket"></i> Data Sparepart</a></li>

								<li <?php if (($_GET['module'] == "service_mobil") || ($_GET['module'] == "ganti_sparepart") || ($_GET['module'] == "kilometer") || ($_GET['module'] == "bensin") || ($_GET['module'] == "statistik")) { ?> class="dropdown active" <?php } else { ?> class="dropdown" <?php } ?>>
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> Monitoring <b class="caret"></b></a>
									<ul class="dropdown-menu">
										<li><a href="media.php?module=service_mobil">Service Mobil</a></li>
										<li><a href="media.php?module=ganti_sparepart">Ganti Sparepart</a></li>
										<li><a href="media.php?module=stnk">Perpanjangan STNK</a></li>
										<li><a href="media.php?module=keur">Perpanjangan KEUR</a></li>
										<li><a href="media.php?module=kilometer">Kilometer Truck</a></li>
										<li><a href="media.php?module=bensin">Bensin Mobil</a></li>
										<li><a href="media.php?module=statistik">Statistik</a></li>
									</ul>
								</li>
							</ul>

							<ul class="nav pull-right">
								<li class="divider-vertical"></li>
								<li class="dropdown">
									<a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="icon-user"></i> Settings <b class="caret"></b></a>
									<ul class="dropdown-menu">
										<li><a href="#changePass" data-toggle="modal"><i class="icon-refresh"></i> Ganti Password</a></li>
										<li class="divider"></li>
										<li><a href="media.php?module=keluar"><i class="icon-off"></i> Keluar</a></li>
									</ul>
								</li>
							</ul>
						</div><!-- /.nav-collapse -->
					</div>
				</div><!-- /navbar-inner -->
			</div><!-- /navbar -->
		</header>

		<div id="changePass" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>Ganti Password</h3>
			</div>
			<div class="modal-body">				
				<form method="post" action="mod_user/aksi_datauser.php?module=ganti_pass">
					<div class="control-group">
						<label class="control-label" for="inputPassword">Masukkan Password Lama</label>
						<div class="controls">
							<input id="inputText" type="hidden" value="<?php echo $row['kodeUser'];?>" name="kodeUser" required></input>
							<input id="inputText" type="text" name="pas_old" required></input>							
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="inputPassword">Masukkan Password Baru</label>
						<div class="controls">
							<input id="inputText" type="text" name="pas_new" required></input>
						</div>
					</div>
					<button class="btn btn-primary" type="submit">Ganti</button>
				</form>
			</div>
		</div>

		<?php include("konten.php"); ?>
		<script type="text/javascript">
			$(function(){
				$(".btn").popover('show');
			});
		</script>
	</body>
	</html>
<?php
	} else {

	} ?>