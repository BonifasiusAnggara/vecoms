<?php if ($_GET['module'] == 'home') { ?>
	<section>
		<div class="row-fluid">
			<div class="span4 pull-left">
				<div class="info_akses span12">
					<img class="logo span12" src="assets/images/coderag_endframe_gavin.jpg">
					<h4><i class="icon-info-sign icon-white reponsive"></i> Info Akses</h4>
					<?php
						$fotouser = $row['photo'];
						if (empty($fotouser)) { ?>
							<div class="foto pull-left" style="background:url(photo_user/default.png) #fff center; background-size:cover;"></div>
					<?php } else { ?>
							<div class="foto pull-left" style="background:url(<?php echo "photo_user/".$fotouser;?>) center; background-size:cover;"></div>
					<?php } ?>
					<div class="span6 pull-left">						
						<div class="isi_akses">
							<span>Kode User</span>
							<span class="form"><?php echo $row['kodeUser'];?></span>
							<span>Nama Lengkap</span>
							<span class="form"><?php echo $row['first_name']." ".$row['last_name'];?></span>
							<hr>
							<span><a class="btn btn-info btn-small" data-toggle="modal" href="#myModal">Ganti Photo</a></span>
						</div>
					</div>
				</div>

				<!-- Modal -->
				<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-header">
						<button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 id="myModalLabel">Ganti Photo</h3>
					</div>
					<div class="modal-body">
						<p>
						<?php
							$fotouser = $row['photo'];
							if (empty($fotouser)) { ?>
								<div class="fotos pull-left" style="background:url(photo_user/default.png) center; background-size:cover;"></div>
						<?php } else { ?>
								<div class="fotos pull-left" style="background:url(<?php echo "photo_user/".$fotouser;?>) center; background-size:cover"></div>
						<?php } ?>
							<form method="post" action="upload_foto.php" enctype="multipart/form-data">
								<input type="hidden" name="kodeuser" value="<?php echo $row['kodeUser'];?>">
								<input type="file" name="fupload">
						</p>						
						</div>
						<div class="modal-footer">
							<button class="btn" data-dismiss="modal">Close</button>
							<button class="btn btn-primary" type="submit">Save Changes</button>
						</form>
					</div>
				</div>
				<!-- End Modal -->
			</div>
			
			<div class="span8 thumb pull-right">
				<div class="info_akses span12">
					<h4><i class="icon-info-sign icon-white reponsive"></i> Welcome to VeCoMS ! &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; < Vehicle Cost Monitoring System ></h4>
				</div>
				<h5>SHORTCUT</h5>
				<ul class="thumbnails">

				<?php if (($akses == '3') || ($akses == '2') || ($akses == '5')) { ?>
					<li class="span3">
						<legend class="span12" style="padding-left: 15px;">Statistik</legend>
						<a class="thumbnail" href="media.php?module=statistik">
							<img src="assets/images/Statistik.jpg" alt="" style="height: 150px">
						</a>
					</li>
					<li class="span3">
						<legend class="span12" style="padding-left: 15px;">Input Service</legend>
						<a class="thumbnail" href="media.php?module=service_mobil&&act=tambah">
							<img src="assets/images/REPAIR.jpg" alt="" style="height: 150px">
						</a>
					</li>
					<li class="span3">
						<legend class="span12" style="padding-left: 15px;">Ganti Spare Part</legend>
						<a class="thumbnail" href="media.php?module=ganti_sparepart&&act=tambah">
							<img src="assets/images/1284696602_121584896_1-Gambar--Bengkel-Bubut-dan-Kantruksi-Fabrikasi-Universal-Technical-Enggineering-1284696602.jpg" alt="" style="height: 150px">
						</a>
					</li>
				<?php } ?>

					<li class="span3">
						<legend class="span12" style="padding-left: 15px;">Kilometer Truck</legend>
						<a class="thumbnail" href="media.php?module=kilometer">
							<img src="assets/images/speedometer.jpg" alt="" style="height: 150px">
						</a>
					</li>

				</ul>
				
				<ul class="thumbnails">
					<?php if (($akses == '3') || ($akses == '2')) { ?>
						<li class="span3">
							<legend class="span12" style="padding-left: 15px;">Isi Bensin</legend>
							<a class="thumbnail" href="media.php?module=bensin&&act=tambah">
								<img src="assets/images/harga-avanza-bekas.jpg" alt="" style="height: 150px">
							</a>
						</li>
						<li class="span3">
							<legend class="span12" style="padding-left: 15px;">Perp. STNK</legend>
							<a class="thumbnail" href="media.php?module=stnk&&act=tambah">
								<img src="assets/images/STNK-Hilang-via-diervie.jpg" alt="" style="height: 150px">
							</a>
						</li>
						<li class="span3">
							<legend class="span12" style="padding-left: 15px;">Perp. KEUR</legend>
							<a class="thumbnail" href="media.php?module=keur&&act=tambah">
								<img src="assets/images/kir.jpg" alt="" style="height: 150px">
							</a>
						</li>
					<?php } ?>
					<?php if ($akses == '3') { ?>
						<li class="span3">
							<legend class="span12" style="padding-left: 15px;">Tambah Mobil</legend>
							<a class="thumbnail" href="media.php?module=data_mobil&&act=tambah">
								<img src="assets/images/engkel-box.jpg" alt="" style="height: 150px">
							</a>
						</li>
					<?php } ?>
				</ul>

				<hr>

				<?php if (($akses == '3') || ($akses == '2') || ($akses == '5')) { ?>

				<h5>LAPORAN</h5>

				<ul class="thumbnails">
					<li class="span3">
						<a class="thumbnail" data-toggle="modal" href="#statistik">
							<img src="assets/images/Statistik.jpg" alt="" style="height: 100px; width: 187px">
						</a>
						<legend style="padding-left: 15px;">Statistik</legend>
					</li>
					<li class="span3">
						<a class="thumbnail" data-toggle="modal" href="#rekam_service">
							<img src="assets/images/maxresdefault.jpg" alt="" style="height: 100px; width: 187px">
						</a>
						<legend style="padding-left: 15px;">Rekam Service</legend>
					</li>
					<li class="span3">
						<a class="thumbnail" data-toggle="modal" href="#ganti_sparepart">
							<img src="assets/images/978743_ec36dcb8-3b1d-4ad2-970d-85042cce4859.jpg" alt="" style="height: 100px; width: 187px">
						</a>
						<legend style="padding-left: 15px;">Ganti Sparepart</legend>
					</li>
					<li class="span3">
						<a class="thumbnail" data-toggle="modal" href="#kilometer">
							<img src="assets/images/engkel-box.jpg" alt="" style="height: 100px">
						</a>
						<legend style="padding-left: 15px;">Laporan Km Truck</legend>
					</li>
								
				</ul>
				<ul class="thumbnails">
					<li class="span3">
						<a class="thumbnail" data-toggle="modal" href="#bensin">
							<img src="assets/images/harga-avanza-bekas.jpg" alt="" style="height: 100px">
						</a>
						<legend style="padding-left: 15px;">Laporan Bensin</legend>
					</li>				
				</ul>
				<ul class="thumbnails">
					<li class="span3">
						<a class="thumbnail" href="laporan/v_mobil.php">
							<img src="assets/images/5ec527ee439a7ddc9cb26edafc3f3194.jpg" alt="" style="height: 100px">
						</a>
						<legend style="padding-left: 15px;">Data Mobil</legend>
					</li>
					<li class="span3">
						<a class="thumbnail" href="laporan/v_bengkel.php">
							<img src="assets/images/Bengkel-Mobil-Bersih.jpg" alt="" style="height: 100px">
						</a>
						<legend style="padding-left: 15px;">Data Bengkel</legend>
					</li>
					<li class="span3">
						<a class="thumbnail" data-toggle="modal" href="laporan/v_sparepart.php" style="height: 100px">
							<img src="assets/images/CarSpareParts.jpg" alt="" style="height: 100px; width: 187px">
						</a>
						<legend style="padding-left: 15px;">Jenis Sparepart</legend>
					</li>
					<li class="span3">
						<a class="thumbnail" href="laporan/v_kat_service.php">
							<img src="assets/images/service mobil baru tiap kilometer.jpg" alt="" style="height: 100px">
						</a>
						<legend style="padding-left: 15px;">Kategori Service</legend>
					</li>
				</ul>

				<!-- Modal-modal -->

				<div id="statistik" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-header">
						<button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3>Statistik</h3>
					</div>
					<div class="modal-body center">
						<form method="get" action="laporan/v_statistik.php">
							<label class="span12">Pilih Bulan</label>
							<div class="control-group">
							<div class="input-prepend">
								<span class="add-on"><i class="icon-calendar"></i></span>
								<select class="span12" id="yearmonth" name="yearmonth" required>
									<option value="<?php echo date('Y-m')?>" selected><?php echo date("M-Y")?></option>
								<?php
									$intmonth = array("01","02","03","04","05","06","07","08","09","10","11","12");
									$monthname = array("Jan","Feb","Mar","Apr","Mei","Jun","Jul","Aug","Sep","Okt","Nop","Des");
									$year = date('Y');
									for ($i=0; $i<12; $i++) {
									echo "<option value='$year-$intmonth[$i]'>$monthname[$i]-$year</option>";
									}
								?>
								</select>
							</div>
							</div>				
							<button class="btn btn-primary" type="submit">Cetak</button>
						</form>
					</div>
				</div>

				<div id="rekam_service" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-header">
						<button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3>Rekam Service</h3>
					</div>
					<div class="modal-body center">
						<form method="get" action="laporan/v_rekam_service.php">
							<label class="span4">Dari Tanggal</label><label class="span4">-</label><label class="span3">Sampai Tanggal</label>
							<input type="date" name="tgl1" id="tgl1"> - <input type="date" name="tgl2" id="tgl2">							
							<div class="control-group">
								<label class="control-label" for="inputPassword">No Plat Mobil</label>
								<div class="controls">

									<input class="span10" type="text" id="inputText" name="plat_no"></input>
								</div>
							</div>							
							<button class="btn btn-primary" type="submit">Cetak</button>
						</form>
					</div>
				</div>

				<div id="ganti_sparepart" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-header">
						<button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3>Penggantian Sparepart</h3>
					</div>
					<div class="modal-body center">
						<form method="get" action="laporan/v_ganti_sparepart.php">
							<label class="span4">Dari Tanggal</label><label class="span4">-</label><label class="span3">Sampai Tanggal</label>
							<input type="date" name="tgl1" id="tgl3"> - <input type="date" name="tgl2" id="tgl4">							
							<div class="control-group">
								<label class="control-label" for="inputPassword">No Plat Mobil</label>
								<div class="controls">

									<input class="span10" type="text" id="inputText" name="plat_no"></input>
								</div>
							</div>							
							<button class="btn btn-primary" type="submit">Cetak</button>
						</form>
					</div>
				</div>

				<div id="kilometer" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-header">
						<button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3>Kilometer Truck</h3>
					</div>
					<div class="modal-body center">
						<form method="get" action="laporan/v_kilometer.php">
							<label class="span4">Dari Tanggal</label><label class="span4">-</label><label class="span3">Sampai Tanggal</label>
							<input type="date" name="tgl5" id="tgl5"> - <input type="date" name="tgl6" id="tgl6">							
							<div class="control-group">
								<label class="control-label" for="inputPassword">No Plat Mobil</label>
								<div class="controls">

									<input class="span10" type="text" id="inputText" name="plat_no"></input>
								</div>
							</div>							
							<button class="btn btn-primary" type="submit">Cetak</button>
						</form>
					</div>
				</div>
				
				<div id="bensin" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-header">
						<button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3>Bensin Mobil</h3>
					</div>
					<div class="modal-body center">
						<form method="get" action="laporan/v_bensin.php">
							<label class="span4">Dari Tanggal</label><label class="span4">-</label><label class="span3">Sampai Tanggal</label>
							<input type="date" name="tgl7" id="tgl7"> - <input type="date" name="tgl8" id="tgl8">							
							<div class="control-group">
								<label class="control-label" for="inputPassword">No Plat Mobil</label>
								<div class="controls">

									<input class="span10" type="text" id="inputText" name="plat_no"></input>
								</div>
							</div>							
							<button class="btn btn-primary" type="submit">Cetak</button>
						</form>
					</div>
				</div>
				<?php } ?>

				<script type="text/javascript">
					$(document).ready(function(){
						$("#tgl1").datepicker({dateFormat:'yy/mm/dd'});
						$("#tgl2").datepicker({dateFormat:'yy/mm/dd'});
						$("#tgl3").datepicker({dateFormat:'yy/mm/dd'});
						$("#tgl4").datepicker({dateFormat:'yy/mm/dd'});
						$("#tgl5").datepicker({dateFormat:'yy/mm/dd'});
						$("#tgl6").datepicker({dateFormat:'yy/mm/dd'});
						$("#tgl7").datepicker({dateFormat:'yy/mm/dd'});
						$("#tgl8").datepicker({dateFormat:'yy/mm/dd'});
					});
				</script>
				<!-- End of Modal-modal -->

			</div>
		</div>
	</section>
<?php } elseif ($_GET['module'] == 'data_user') {
		if ($akses == '3') {
			include("mod_user/data_user.php");
		} else {
			echo "<script type='text/javascript'>
					alert('Mohon maaf, akses anda kami tolak !!');
					back.self();
				  </script>";
		}
	  } elseif ($_GET['module'] == 'service_mobil') {
	  	if ($akses == '3' OR $akses == '2' OR $akses == '5') {
	  		include("mod_rs/rekam_service.php");
	  	} else {
	  		echo "<script type='text/javascript'>
	  				alert('Mohon maaf, akses anda kami tolak !!');
	  				back.self();
	  			  </script>";
	  	} 
	  } elseif ($_GET['module'] == 'ganti_sparepart') {
	  	if ($akses == '3' OR $akses == '2' OR $akses == '5') {
	  		include("mod_gs/ganti_sparepart.php");
	  	} else {
	  		echo "<script type='text/javascript'>
	  				alert('Mohon maaf, akses anda kami tolak !!');
	  				back.self();
	  			  </script>";
	  	}
	  } elseif ($_GET['module'] == 'data_mobil') {
	  	if ($akses == '3' OR $akses == '2' OR $akses == '5') {
	  		include("mod_mobil/mobil.php");
	  	} else {
	  		echo "<script type='text/javascript'>
					alert('Mohon maaf, akses anda kami tolak !!');
					back.self();
				  </script>";
	  	}
	  } elseif ($_GET['module'] == 'data_bengkel') {
	  	if ($akses == '3' OR $akses == '2' OR $akses == '5') {
	  		include("mod_bengkel/bengkel.php");
	  	} else {
	  		echo "<script type='text/javascript'>
	  				alert('Mohon maaf, akses anda kami tolak !!');
	  				back.self();
	  			  </script>";
	  	}
	  } elseif ($_GET['module'] == 'data_pegawai') {
	  	if ($akses == '3' OR $akses == '2' OR $akses == '5') {
	  		include("mod_pegawai/pegawai.php");
	  	} else {
	  		echo "<script type='text/javascript'>
	  				alert('Mohon maaf, akses anda kami tolak !!');
	  				back.self();
	  			  </script>";
	  	}
	  } elseif ($_GET['module'] == 'service') {
	  	if ($akses == '3' OR $akses == '2' OR $akses == '5') {
	  		include("mod_service/kategori_service.php");
	  	} else {
	  		echo "<script type='text/javascript'>
	  				alert('Mohon maaf, akses anda kami tolak !!');
	  				back.self();
	  			  </script>";
	  	}
	  } elseif ($_GET['module'] == 'data_sparepart') {
	  	if ($akses == '3' OR $akses == '2' OR $akses == '5') {
	  		include("mod_sparepart/sparepart.php");
	  	} else {
	  		echo "<script type='text/javascript'>
	  				alert('Mohon maaf, akses anda kami tolak !!');
	  				back.self();
	  			  </script>";
	  	}
	  } elseif ($_GET['module'] == 'kilometer') {
	  	if ($akses == '3' OR $akses == '2' OR $akses == '4' OR $akses == '5') {
	  		include("mod_kilometer/kilometer.php");
	  	} else {
	  		echo "<script type='text/javascript'>
	  				alert('Mohon maaf, akses anda kami tolak !!');
	  				back.self();
	  			  </script>";
	  	}
	  } elseif ($_GET['module'] == 'bensin') {
	  	if ($akses == '3' OR $akses == '2' OR $akses == '5') {
	  		include("mod_bensin/bensin.php");
	  	} else {
	  		echo "<script type='text/javascript'>
	  				alert('Mohon maaf, akses anda kami tolak !!');
	  				back.self();
	  			  </script>";
	  	}
	  } elseif ($_GET['module'] == 'statistik') {
	  	if ($akses == '3' OR $akses == '2' OR $akses == '5') {
	  		include("mod_statistik/statistik.php");
	  	} else {
	  		echo "<script type='text/javascript'>
	  				alert('Mohon maaf, akses anda kami tolak !!');
	  				back.self();
	  			  </script>";
	  	}
	  } elseif ($_GET['module'] == 'stnk') {
	  	if ($akses == '3' OR $akses == '2' OR $akses == '5') {
	  		include("mod_stnk/stnk.php");
	  	} else {
	  		echo "<script type='text/javascript'>
	  				alert('Mohon maaf, akses anda kami tolak !!');
	  				back.self();
	  			  </script>";
	  	}
	  } elseif ($_GET['module'] == 'keur') {
	  	if ($akses == '3' OR $akses == '2' OR $akses == '5') {
	  		include("mod_keur/keur.php");
	  	} else {
	  		echo "<script type='text/javascript'>
	  				alert('Mohon maaf, akses anda kami tolak !!');
	  				back.self();
	  			  </script>";
	  	}
	  } elseif ($_GET['module'] == 'keluar') {
		session_start(); 
		session_destroy();
		echo "<script type='text/javascript'>
				alert('Silakan Login kembali !!');
				window.location.href='index.php';
			  </script>";
	  }