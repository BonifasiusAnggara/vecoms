<?php
	$aksi = "mod_kilometer/aksi_kilometer.php";
	switch ($_GET['act']) {
		default:
?>
		<script type="text/javascript">
			$(document).ready(function(){
				<!-- event textbox keyup
				$("#txtcari").keyup(function(){
					var strcari = $("#txtcari").val();
					var akses = $("#akses").val();
					if (strcari != "") {
						$("#tabel_awal").css("display","none");
						$("#hasil").html("<img src='assets/images/loader.gif'/>")
						$.ajax({
							type: "POST",
							url : "mod_kilometer/cari.php",
							data: "q="+strcari+"&akses="+akses,
							success: function(data){
								$("#hasil").css("display","block");
								$("#hasil").html(data);
							}
						});
					} else {
						$("#hasil").css("display","none");
						$("#tabel_awal").css("display","block");
					}
				});
			});
		</script>
	<?php
		$p = new Paging;
		$batas = 10;
		$posisi = $p->cariPosisi($batas);
	?>
		<section>
			<input type="hidden" value="<?php echo $_SESSION['akses'] ?>" id="akses">
			<ul class="breadcrumb" style="margin-bottom:5px;">
				<li class="active">Data Kilometer</li>				
			</ul>
			<div class="control-group pull-left">
				<button class="btn btn-success" type="button" onclick="window.location='media.php?module=kilometer&&act=tambah'"><i class="icon-chevron-right icon-white"></i> Input Mobil</button>
			</div>
			<form class="form-search pull-right">
				<div class="input-prepend">
					<span class="add-on"><i class="icon-search"></i></span>
					<input class="span3" id="txtcari" type="text" placeholder="Search ..."></input>
				</div>
			</form>
			<hr>
			<div class="row-fluid">
				<div class="span12 pull-left">
					<div id="hasil"></div>
					<div id="tabel_awal">
						<table class="table table-striped">
							<thead>
								<tr class="head2">
									<td>No.</td>
									<td>Plat No Mobil</td>
									<td>Driver</td>
									<td>Rayon</td>
									<td>Km Berangkat</td>
									<td>Jam Berangkat</td>
									<td>Km Pulang</td>
									<td>Jam Pulang</td>
									<td>Jarak Tempuh</td>
									<td>Litter Solar</td>
									<td>Km Solar</td>
									<td>Rasio Solar</td>
									<td></td>
								</tr>
							</thead>
							<tbody>
							<?php
								$query = mysqli_query($conn, "SELECT * FROM kilometer, mobil, pegawai WHERE kilometer.id_mobil=mobil.id_mobil AND kilometer.id_peg=pegawai.id_peg ORDER BY id_km DESC LIMIT $posisi, $batas");
								$no = $posisi+1;
								while ($r = mysqli_fetch_array($query)) {
							?>
								<tr>
									<td><?php echo $no.".";?></td>
									<td><?php echo $r['plat_no'];?></td>
									<td><?php echo $r['nama_peg'];?></td>
									<td><?php echo $r['rayon'] ?></td>

									<?php if ($r['km_brkt'] == 0) { ?>
									<td>
										<button class="btn btn-warning" onclick="window.location='media.php?module=kilometer&&act=km_awal&&id_km=<?php echo $r['id_km'] ?>&&id_mobil=<?php echo $r['id_mobil'] ?>'">Input Km</button>
									</td>
									<?php } else { ?>
									<td><?php echo format_ribuan($r['km_brkt']) ?></td>
									<?php } ?>
									
									<?php if ($r['jam_brkt'] == "0000-00-00 00:00:00") { ?>
									<td></td>
									<?php } else { ?>
									<td><?php echo tgl_indo2($r['jam_brkt']) ?></td>
									<?php } ?>

									<?php if ($r['km_plg'] == 0) { ?>
									<td>
										<button class="btn btn-warning" onclick="window.location='media.php?module=kilometer&&act=km_akhir&&id_km=<?php echo $r['id_km'] ?>&&id_mobil=<?php echo $r['id_mobil'] ?>'" <?php if ($r['km_brkt'] == 0) { ?> disabled <?php } ?>>Input Km</button>
									</td>
									<?php } else { ?>
									<td><?php echo format_ribuan($r['km_plg']) ?></td>
									<?php } ?>
									
									<?php if ($r['jam_plg'] == "0000-00-00 00:00:00") { ?>
									<td></td>
									<?php } else { ?>
									<td><?php echo tgl_indo2($r['jam_plg']) ?></td>
									<?php } ?>

									<td><?php echo format_ribuan($r['jarak_tempuh']).' Km';?></td>
									<td>

									<?php if ($akses != 4) { ?>
										<table>
											<tr>
												<?php if ($r['solar_1'] == 0) { 
													$filter = mysqli_query($conn, "SELECT MAX(km_solar1) max_km_solar1 FROM kilometer WHERE id_mobil = '$r[id_mobil]'");
													$row = mysqli_fetch_array($filter);
												?>											
												<td>
													<button class="btn btn-warning" onclick="window.location='media.php?module=kilometer&&act=input_solar1&&id_km=<?php echo $r['id_km'] ?>&&id_mobil=<?php echo $r['id_mobil'] ?>'" <?php if ($akses == 4 || $r['km_plg'] == 0 || ($row['max_km_solar1'] > $r['km_brkt'])) { ?> disabled <?php } ?>>Input Solar 1</button>
												</td>
											
												<?php } else { ?>
											
												<td><?php echo format_ribuan2($r['solar_1']);?></td>
												<?php } ?>
											</tr>

											<tr>
											<?php if ($r['solar_1'] == 0) { ?>
												<td></td>
											<?php }  else if (($r['solar_1'] != 0) && ($r['solar_2'] == 0)) { ?>
											
												<td>
													<button class="btn btn-warning" onclick="window.location='media.php?module=kilometer&&act=input_solar2&&id_km=<?php echo $r['id_km'] ?>&&id_mobil=<?php echo $r['id_mobil'] ?>'" <?php if ($akses == 4 || $r['rasio_solar1'] != 0) { ?> disabled <?php } ?>>Input Solar 2</button>
												</td>
											
												<?php } else if ($r['solar_2'] != 0) { ?>
											
												<td><?php echo format_ribuan2($r['solar_2']);?></td>
											
												<?php } ?>
											</tr>

											<tr>
											<?php if ($r['solar_2'] == 0) { ?>
												<td></td>
											<?php } else if (($r['solar_2'] != 0) && ($r['solar_3'] == 0)) { ?>
											
												<td>
													<button class="btn btn-warning" onclick="window.location='media.php?module=kilometer&&act=input_solar3&&id_km=<?php echo $r['id_km'] ?>&&id_mobil=<?php echo $r['id_mobil'] ?>'" <?php if ($akses == 4 || $r['rasio_solar2'] != 0) { ?> disabled <?php } ?>>Input Solar 3</button>
												</td>
											
												<?php } else if ($r['solar_3'] != 0) { ?>
											
												<td><?php echo format_ribuan2($r['solar_3']);?></td>
											
												<?php } ?>
											</tr>
										</table>
									<?php } ?>
									</td>

									<td>
									<?php if ($akses != 4) { ?>
										<table>
											<tr>
											<?php if ($r['km_solar1'] == 0) { ?>
												<td></td>
											<?php } else { ?>
												<td><?php echo format_ribuan($r['km_solar1']) ?></td>
											<?php } ?>
											</tr>
											<tr>
											<?php if ($r['km_solar2'] == 0) { ?>
												<td></td>
											<?php } else { ?>
												<td><?php echo format_ribuan($r['km_solar2']) ?></td>
											<?php } ?>
											</tr>
											<tr>
											<?php if ($r['km_solar3'] == 0) { ?>
												<td></td>
											<?php } else { ?>
												<td><?php echo format_ribuan($r['km_solar3']) ?></td>
											<?php } ?>
											</tr>
										</table>
									<?php } ?>
									</td>

									<td>
									<?php if ($akses != 4) { ?>
										<table>
											<tr>
											<?php if ($r['rasio_solar1'] == 0) { ?>
												<td></td>
											<?php } else { ?>
												<td><?php echo format_ribuan2($r['rasio_solar1']) ?></td>
											<?php } ?>
											</tr>
											<tr>
											<?php if ($r['rasio_solar2'] == 0) { ?>
												<td></td>
											<?php } else { ?>
												<td><?php echo format_ribuan2($r['rasio_solar2']) ?></td>
											<?php } ?>
											</tr>
											<tr>
											<?php if ($r['rasio_solar3'] == 0) { ?>
												<td></td>
											<?php } else { ?>
												<td><?php echo format_ribuan2($r['rasio_solar3']) ?></td>
											<?php } ?>
											</tr>
										</table>
									<?php } ?>
									</td>

									<?php if ($akses == 3 OR $akses == 2) { ?>
									<td>
										<div class="btn-group">
											<a class="btn btn-success" href="#"><i class="icon-wrench icon-white"></i> Actions</a>
											<a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
											<ul class="dropdown-menu">

												<li><a href="<?php echo "$aksi?module=hapus&&id_km=$r[id_km]";?>" onclick="return confirm('Apakah anda yakin, ingin menghapus data Kilometer <?php echo $r['plat_no'];?> ?')"><i class="icon-trash"></i> Delete</a></li>
											</ul>
										</div>
									</td>
									<?php } else { ?> <td></td> <?php } ?>

								</tr>
							<?php $no++;
								}
							?>
								<tr>
									<td colspan="12">
									<?php
										$jmldata = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM kilometer"));
										$jmlhalaman = $p->jumlahHalaman($jmldata,$batas);
										$linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
										echo "$linkHalaman";
									?>
									</td>
									<td>
										Jumlah Record <?php echo $jmldata;?>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</section>
<?php
	break;
		case "tambah":
?>	
		<section>
			<ul class="breadcrumb" style="margin-bottom:5px;">
				<li><a href="media.php?module=kilometer">Data Kilometer</a> <span class="divider"><b>&gt;</b></span></li>
				<li class="active">Input Mobil</li>
			</ul>

			<div class="row-fluid">
				<div class="span12 pull-left">
					<form method="post" enctype="multipart/form-data" action="<?php echo "$aksi?module=tambah";?>">
						<input class="span10" type="hidden" id="inputText" value="<?php echo $kodeuser;?>" name="kode_user"></input>
						<fieldset>
							<legend class="span7 offset1">Input Mobil</legend>
							<div class="clear"></div>
							<div class="span3 offset1" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
								<div class="control-group">
									<label class="control-label" for="inputPassword">Mobil</label>
									<select name="id_mobil" class="span10" id="id_mobil" required>
										<div class="controls">
											<option>~ Mobil ~</option>
											<?php
												$query = mysqli_query($conn, "SELECT * FROM mobil WHERE type_code = '1'");
												;
												while ($mbl = mysqli_fetch_array($query)) {
											?>
												<option value="<?php echo $mbl['id_mobil'] ?>"><?php echo $mbl['plat_no'] ?></option>
											<?php } ?>
										</div>
									</select>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Driver</label>
									<select name="id_peg" class="span10" required>
										<div class="controls">
											<option>~ Driver ~</option>
											<?php
												$query = mysqli_query($conn, "SELECT * FROM pegawai WHERE golongan = '1' OR golongan = '3'");
												;
												while ($peg = mysqli_fetch_array($query)) {
											?>
												<option value="<?php echo $peg['id_peg'] ?>"><?php echo $peg['nama_peg'] ?></option>
											<?php } ?>
										</div>
									</select>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Rayon</label>
									<div class="controls">
										<input class="span10" type="text" id="inputText" name="rayon" required></input>
									</div>
								</div>
								<hr>
								<div class="control-group">
									<div class="controls">
										<button class="btn btn-success" type="submit"><i class="icon-ok-circle icon-white"></i> Simpan</button>
										<button class="btn btn-warning" type="reset"><i class="icon-refresh icon-white"></i> Reset</button>
									</div>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</section>
<?php
	break;
		case "km_awal":
		$id_km = $_GET['id_km'];
		$id_mobil = $_GET['id_mobil'];
		$query = mysqli_query($conn, "SELECT * FROM mobil WHERE id_mobil='$id_mobil'");
		$row = mysqli_fetch_array($query);
?>
		<script type="text/javascript">
			$(document).ready(function(){
				var id_mobil = $("#id_mobil").val();
				if (id_mobil != "") {
					$("#hasil_km").html("<img src='assets/images/loader.gif'/>")
					$.ajax({
						type: "POST",
						url : "mod_kilometer/cari_km_akhir.php",
						data: "q="+id_mobil,
						success: function(data){
							$("#hasil_km").css("display","none");
							$("#hasil_km").html(data);
						}
					})
				}
			});
		</script>
		
		<section>
			<ul class="breadcrumb" style="margin-bottom: 5px">
				<li><a href="media.php?module=kilometer">Data Kilometer</a> <span class="divider"><b>&gt;</b></span></li>
				<li class="active">Input Km Berangkat</li>
			</ul>

			<div class="row-fluid">
				<div class="span12 pull-left">
					<form method="post" enctype="multipart/form-data" action="<?php echo "$aksi?module=km_awal" ?>">
						<fieldset>
							<legend class="span7 offset1">Input Km Berangkat</legend>
							<div class="clear"></div>

							<div class="span3 offset1" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
								
								<img src="assets/images/IMG_9000_zps8c11f63a.jpg" alt="" style="height: 150px; margin-left: 40px;">
								<br>
								<br>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Plat No. Mobil</label>
									<div class="controls">
										<input class="span10" type="text" value="<?php echo $row['plat_no'] ?>" disabled></input>
										<input class="span10" type="hidden" id="id_mobil" value="<?php echo $id_mobil;?>" name="id_mobil"></input>
									</div>
								</div>
								<div id="hasil_km"></div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Kilo Meter(s)</label>
									<div class="controls">
										<input class="span10" type="hidden" id="id_km" value="<?php echo $id_km;?>" name="id_km"></input>
										<input class="span10" type="text" name="km_awal" required></input>
									</div>
								</div>
								<hr>
								<div class="control-group">
									<div class="controls">
										<button class="btn btn-success" type="submit"><i class="icon-ok-circle icon-white"></i> Simpan</button>
										<button class="btn btn-warning" type="reset"><i class="icon-refresh icon-white"></i> Reset</button>
									</div>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</section>
<?php
	break;
		case "km_akhir":
		$id_km = $_GET['id_km'];
		$id_mobil = $_GET['id_mobil'];
		$query = mysqli_query($conn, "SELECT * FROM mobil WHERE id_mobil='$id_mobil'");
		$row = mysqli_fetch_array($query);
?>		
		<section>
			<ul class="breadcrumb" style="margin-bottom: 5px">
				<li><a href="media.php?module=kilometer">Data Kilometer</a> <span class="divider"><b>&gt;</b></span></li>
				<li class="active">Input Km Berangkat</li>
			</ul>

			<div class="row-fluid">
				<div class="span12 pull-left">
					<form method="post" enctype="multipart/form-data" action="<?php echo "$aksi?module=km_akhir" ?>">
						<fieldset>
							<legend class="span7 offset1">Input Km Pulang</legend>
							<div class="clear"></div>

							<div class="span3 offset1" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
								
								<img src="assets/images/IMG_9000_zps8c11f63a.jpg" alt="" style="height: 150px; margin-left: 40px;">
								<br>
								<br>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Plat No. Mobil</label>
									<div class="controls">
										<input class="span10" type="text" value="<?php echo $row['plat_no'] ?>" disabled></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Kilo Meter(s)</label>
									<div class="controls">
										<input class="span10" type="hidden" id="id_km" value="<?php echo $id_km;?>" name="id_km"></input>
										<input class="span10" type="hidden" id="id_mobil" value="<?php echo $id_mobil;?>" name="id_mobil"></input>
										<input class="span10" type="text" name="km_akhir" required></input>
									</div>
								</div>
								<hr>
								<div class="control-group">
									<div class="controls">
										<button class="btn btn-success" type="submit"><i class="icon-ok-circle icon-white"></i> Simpan</button>
										<button class="btn btn-warning" type="reset"><i class="icon-refresh icon-white"></i> Reset</button>
									</div>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</section>
<?php
	break;
		case "input_solar1":
		$id_km = $_GET['id_km'];
		$id_mobil = $_GET['id_mobil'];
		$query = mysqli_query($conn, "SELECT * FROM mobil WHERE id_mobil='$id_mobil'");
		$row = mysqli_fetch_array($query);
?>
		<script type="text/javascript">
			$(document).ready(function(){
				var id_mobil = $("#id_mobil").val();
				if (id_mobil != "") {
					$("#hasil_km").html("<img src='assets/images/loader.gif'/>")
					$.ajax({
						type: "POST",
						url : "mod_kilometer/cari_km.php",
						data: "q="+id_mobil,
						success: function(data){
							$("#hasil_km").css("display","none");
							$("#hasil_km").html(data);
						}
					})
				}
			});
		</script>
		
		<section>
			<ul class="breadcrumb" style="margin-bottom: 5px">
				<li><a href="media.php?module=kilometer">Data Kilometer</a> <span class="divider"><b>&gt;</b></span></li>
				<li class="active">Input Pembelian Solar Pertama</li>
			</ul>

			<div class="row-fluid">
				<div class="span12 pull-left">
					<form method="post" enctype="multipart/form-data" action="<?php echo "$aksi?module=solar1" ?>">
						<fieldset>
							<legend class="span7 offset1">Input Litter Solar</legend>
							<div class="clear"></div>

							<div class="span3 offset1" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
								
								<img src="assets/images/Kran Bensin.jpg" alt="" style="height: 150px; margin-left: 40px;">
								<br>
								<br>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Plat No. Mobil</label>
									<div class="controls">
										<input class="span10" type="text" value="<?php echo $row['plat_no'] ?>" disabled></input>
									</div>
								</div>
								<div id="hasil_km"></div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Litter(s) Solar</label>
									<div class="controls">
										<input class="span10" type="hidden" id="id_km" value="<?php echo $id_km;?>" name="id_km"></input>
										<input class="span10" type="hidden" id="id_mobil" value="<?php echo $id_mobil;?>" name="id_mobil"></input>
										<input class="span10" type="text" name="solar" required></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Km isi Solar</label>
									<div class="controls">
										<input class="span10" type="text" name="km_solar" required></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Harga</label>
									<div class="controls">
										<input class="span10" type="text" name="harga_solar" required></input>
									</div>
								</div>
								<hr>
								<div class="control-group">
									<div class="controls">
										<button class="btn btn-success" type="submit"><i class="icon-ok-circle icon-white"></i> Simpan</button>
										<button class="btn btn-warning" type="reset"><i class="icon-refresh icon-white"></i> Reset</button>
									</div>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</section>
<?php
	break;
		case "input_solar2":
		$id_km = $_GET['id_km'];
		$id_mobil = $_GET['id_mobil'];
		$query = mysqli_query($conn, "SELECT * FROM mobil WHERE id_mobil='$id_mobil'");
		$row = mysqli_fetch_array($query);
?>
		<section>
			<ul class="breadcrumb" style="margin-bottom: 5px">
				<li><a href="media.php?module=kilometer">Data Kilometer</a> <span class="divider"><b>&gt;</b></span></li>
				<li class="active">Input Pembelian Solar Kedua</li>
			</ul>

			<div class="row-fluid">
				<div class="span12 pull-left">
					<form method="post" enctype="multipart/form-data" action="<?php echo "$aksi?module=solar2" ?>">
						<fieldset>
							<legend class="span7 offset1">Input Litter Solar</legend>
							<div class="clear"></div>

							<div class="span3 offset1" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
								
								<img src="assets/images/Kran Bensin.jpg" alt="" style="height: 150px; margin-left: 40px;">
								<br>
								<br>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Plat No. Mobil</label>
									<div class="controls">
										<input class="span10" type="text" value="<?php echo $row['plat_no'] ?>" disabled></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Litter(s) Solar</label>
									<div class="controls">
										<input class="span10" type="hidden" id="id_km" value="<?php echo $id_km;?>" name="id_km"></input>
										<input class="span10" type="hidden" id="id_mobil" value="<?php echo $id_mobil;?>" name="id_mobil"></input>
										<input class="span10" type="text" name="solar" required></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Km isi Solar</label>
									<div class="controls">
										<input class="span10" type="text" name="km_solar" required></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Harga</label>
									<div class="controls">
										<input class="span10" type="text" name="harga_solar" required></input>
									</div>
								</div>
								<hr>
								<div class="control-group">
									<div class="controls">
										<button class="btn btn-success" type="submit"><i class="icon-ok-circle icon-white"></i> Simpan</button>
										<button class="btn btn-warning" type="reset"><i class="icon-refresh icon-white"></i> Reset</button>
									</div>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</section>
<?php
	break;
		case "input_solar3":
		$id_km = $_GET['id_km'];
		$id_mobil = $_GET['id_mobil'];
		$query = mysqli_query($conn, "SELECT * FROM mobil WHERE id_mobil='$id_mobil'");
		$row = mysqli_fetch_array($query);
?>
		<section>
			<ul class="breadcrumb" style="margin-bottom: 5px">
				<li><a href="media.php?module=kilometer">Data Kilometer</a> <span class="divider"><b>&gt;</b></span></li>
				<li class="active">Input Pembelian Solar Ketiga</li>
			</ul>

			<div class="row-fluid">
				<div class="span12 pull-left">
					<form method="post" enctype="multipart/form-data" action="<?php echo "$aksi?module=solar3" ?>">
						<fieldset>
							<legend class="span7 offset1">Input Litter Solar</legend>
							<div class="clear"></div>

							<div class="span3 offset1" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
								
								<img src="assets/images/Kran Bensin.jpg" alt="" style="height: 150px; margin-left: 40px;">
								<br>
								<br>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Plat No. Mobil</label>
									<div class="controls">
										<input class="span10" type="text" value="<?php echo $row['plat_no'] ?>" disabled></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Litter(s) Solar</label>
									<div class="controls">
										<input class="span10" type="hidden" id="id_km" value="<?php echo $id_km;?>" name="id_km"></input>
										<input class="span10" type="hidden" id="id_mobil" value="<?php echo $id_mobil;?>" name="id_mobil"></input>
										<input class="span10" type="text" name="solar" required></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Km isi Solar</label>
									<div class="controls">
										<input class="span10" type="text" name="km_solar" required></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Harga</label>
									<div class="controls">
										<input class="span10" type="text" name="harga_solar" required></input>
									</div>
								</div>
								<hr>
								<div class="control-group">
									<div class="controls">
										<button class="btn btn-success" type="submit"><i class="icon-ok-circle icon-white"></i> Simpan</button>
										<button class="btn btn-warning" type="reset"><i class="icon-refresh icon-white"></i> Reset</button>
									</div>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</section>
<?php
	break;
	}
?>