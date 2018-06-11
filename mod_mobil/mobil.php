<?php
	$aksi = "mod_mobil/aksi_mobil.php";
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
						url : "mod_mobil/cari.php",
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
		$p = new paging;
		$batas = 10;
		$posisi = $p->cariPosisi($batas);
	?>
		<section>
			<input type="hidden" value="<?php echo $_SESSION['akses'] ?>" id="akses">
			<ul class="breadcrumb" style="margin-bottom:5px;">
				<li class="active">Data Mobil</li>
				
			<?php								
				$query1 = mysqli_query($conn, "SELECT *, TIMESTAMPDIFF(DAY, CURRENT_DATE, ms_ber_stnk) AS stnk, TIMESTAMPDIFF(DAY, CURRENT_DATE, ms_ber_keur) AS keur FROM mobil, pegawai WHERE mobil.id_peg=pegawai.id_peg");

				while ($row = mysqli_fetch_array($query1)) {
					if ($row['stnk'] < 30 && $row['stnk'] > 0) {
						echo "
							<li style='padding:5px; color:#F15757;'><span class='divider'><b>&gt;</b></span><i class='fa fa-car'></i> Mobil dengan Plat No <b>$row[plat_no]</b>, masa berlaku STNK nya sudah mau habis !! kurang $row[stnk] hari lagi</li>";

					}
					if ($row['keur'] < 30 && $row['keur'] > 0) {
						echo "<li style='padding:5px; color:#F15757;'><span class='divider'><b>&gt;</b></span><i class='fa fa-car'></i> Mobil dengan Plat No <b>$row[plat_no]</b>, masa berlaku KEUR nya sudah mau habis !! kurang $row[keur] hari lagi</li>";

					}
				}
			?>
			
			</ul>

			<?php if ($akses == '3') { ?>
			<div class="control-group pull-left">
				<button class="btn btn-info" type="button" onclick="window.location='media.php?module=data_mobil&&act=tambah'"><i class="icon-plus icon-white"></i> Tambah Mobil</button>
			</div>
			<?php } ?>
			
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
								<tr class="head">
									<td>No.</td>
									<td>Photo</td>
									<td>Plat No</td>
									<td>Type</td>
									<td>Nama Pemilik</td>
									<td>Jabatan</td>
									<td>Direktorat</td>					
									<td>Masa Berlaku STNK</td>
									<td>Masa Berlaku KEUR</td>
									<td>Due Date STNK</td>
									<td>Due Date KEUR</td>
									<td></td>
								</tr>
							</thead>
							<tbody>
							<?php							
								$query1 = mysqli_query($conn, "SELECT *, TIMESTAMPDIFF(DAY, CURRENT_DATE, ms_ber_stnk) AS stnk, TIMESTAMPDIFF(DAY, CURRENT_DATE, ms_ber_keur) AS keur FROM mobil, pegawai WHERE mobil.id_peg=pegawai.id_peg");

								while ($row = mysqli_fetch_array($query1)) {
									if ($row['stnk'] < 30 && $row['stnk'] > 0) {
										include_once("stnk.php");
																
									}
									if ($row['keur'] < 30 && $row['keur'] > 0) {
										
										include_once("keur.php");
									}
								}

								$query = mysqli_query($conn, "SELECT *, TIMESTAMPDIFF(DAY, CURRENT_DATE, ms_ber_stnk) AS stnk, TIMESTAMPDIFF(DAY, CURRENT_DATE, ms_ber_keur) AS keur FROM mobil, direktorat, pegawai WHERE mobil.id_dir=direktorat.id_dir AND mobil.id_peg=pegawai.id_peg ORDER BY direktorat.id_dir ASC LIMIT $posisi, $batas");
								$no = $posisi+1;
								while ($r = mysqli_fetch_array($query)) {
							?>
								<tr>
									<td><?php echo $no.".";?></td>
									<td><?php
										$foto = $r['photo'];
										if (isset($foto)) {
											echo "<img src='photo_mobil/$foto' style='width:170px; height:100px;' class='thumbnail'>";
										}
									?></td>
									<td><?php echo $r['plat_no'];?></td>
									<td><?php echo $r['type'];?></td>
									<td><?php echo $r['nama_peg'];?></td>
									<td><?php echo $r['jabatan'];?></td>
									<td><?php echo $r['deskripsi'];?></td>
									<?php if ($r['ms_ber_stnk'] == 0000-00-00) { ?>
									<td></td>
									<?php } else { ?>
									<td><?php echo tgl_indo($r['ms_ber_stnk']);?></td>
									<?php } ?>
									<?php if ($r['ms_ber_keur'] == 0000-00-00) { ?>
									<td></td>
									<?php } else { ?>
									<td><?php echo tgl_indo($r['ms_ber_keur']);?></td>
									<?php } ?>

									<td <?php if ($r['stnk'] < 7) { ?> style="color: #FF0066" <?php } else if ($r['stnk'] < 30) { ?> style="color: #FF0F62" <?php } else if ($r['stnk'] < 90) { ?> style="color: #00CC00" <?php } ?>"><?php echo $r['stnk'].' Hari';?></td>
									<td <?php if ($r['keur'] < 7) { ?> style="color: #FF0066" <?php } else if ($r['keur'] < 30) { ?> style="color: #FF0F62" <?php } else if ($r['keur'] < 90) { ?> style="color: #00CC00" <?php } ?>"><?php echo $r['keur'].' Hari';?></td>

									<?php if ($akses != 3) { ?> 
									<td></td>
									<?php } else { ?>
									<td>
										<div class="btn-group">
											<a class="btn btn-info" href="#"><i class="icon-wrench icon-white"></i> Actions</a>
											<a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
											<ul class="dropdown-menu">
												<li>
													<a href="media.php?module=data_mobil&&act=edit&&id_mobil=<?php echo sha1($r['id_mobil']);?>"><i class="icon-pencil"></i> Edit</a>
												</li>
												<li>
													<a href="media.php?module=data_mobil&&act=detail&&id_mobil=<?php echo sha1($r['id_mobil']);?>"><i class="icon-flag"></i> Detail</a>
												</li>
												<li>
													<a href="media.php?module=data_mobil&&act=seri_ban&&id_mobil=<?php echo sha1($r['id_mobil']);?>"><i class="icon-ban-circle"></i> No Seri Ban</a>
												</li>
												<li>
													<a href="<?php echo "$aksi?module=hapus&&id_mobil=$r[id_mobil]";?>" onclick="return confirm('Apakah anda yakin ingin menghapus data mobil <?php echo $r['plat_no'];?> ??')"><i class="icon-trash"></i> Delete</a>
												</li>
											</ul>
										</div>
									</td>
									<?php } ?>
								</tr>
							<?php $no++;
								}
							?>
								<tr>
									<td colspan="11">
									<?php
										$jmldata = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM mobil"));
										$jmlhalaman = $p->jumlahHalaman($jmldata,$batas);
										$linkHalaman = $p->navHalaman($_GET['halaman'],$jmlhalaman);
										echo "$linkHalaman";
									?>
										<td>Jumlah Record <?php echo $jmldata;?></td>
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
		<script type="text/javascript">
			$(document).ready(function(){
				<!-- event textbox keyup
				$("#pegawai").keyup(function(){
					var strcari = $("#pegawai").val();
					if (strcari != "") {
						$("#hasil_pegawai").html("<img src='img/loader.gif'/>")
						$.ajax({
							type: "POST",
							url : "mod_mobil/cari_pegawai.php",
							data: "q="+strcari,
							success: function(data){
								$("#hasil_pegawai").css("display","block");
								$("#hasil_pegawai").html(data);
							}
						});
					} else {
						$("#hasil_pegawai").css("display","none");
					}
				});
			})
		</script>

		<section>
			<ul class="breadcrumb" style="margin-bottom:5px;">
				<li><a href="media.php?module=data_mobil">Data Mobil</a> <span class="divider"><b>&gt;</b></span></li>
				<li class="active">Tambah Mobil</li>
			</ul>

			<div class="row-fluid">
				<div class="span12 pull-left">
					<form method="post" enctype="multipart/form-data" action="<?php echo "$aksi?module=tambah";?>">
						<fieldset>
							<legend class="span7 offset1">Tambah Mobil
								<input class="span4" type="text" id="pegawai" name="t4" required>
							</legend>
							<div class="clear"></div>
							<div class="span3 offset1">
								<div id="hasil_pegawai"></div>
							</div>
							<div class="span3" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
								<div class="control-group">
									<label class="control-label" for="inputPassword">Plat Nomor</label>
									<div class="controls">
										<input class="span-10" type="hidden" name="id_mobil"></input>
										<input class="span10" type="text" id="inputText" name="plat_no" required></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Type</label>
									<div class="controls">
										<input class="span10" type="text" id="inputText" name="type" required></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Type Code</label>
									<div class="controls">
										<input class="span2" type="Radio" id="inputText" name="type_code" value="1" checked>Operasional</sup></input>
										<input class="span2" type="Radio" id="inputText" name="type_code" value="2">Inventaris</input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Masa Berlaku STNK</label>
									<div class="controls">
										<input class="span10" type="date" id="tgl1" name="ms_ber_stnk" required></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Masa Berlaku KEUR</label>
									<div class="controls">
										<input class="span10" type="date" id="tgl2" name="ms_ber_keur" required></input>
									</div>
								</div>
							</div>
							<div class="span3" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
								<div class="control-group">
									<label class="control-label" for="inputPassword">No Mesin</label>
									<div class="controls">
										<input class="span10" type="text" id="inputText" name="no_mesin" required></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">No Rangka</label>
									<div class="controls">
										<input class="span10" type="text" id="inputText" name="no_rangka" required></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">No BPKB</label>
									<div class="controls">
										<input class="span10" type="text" id="inputText" name="no_bpkb" required></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Photo</label>
									<div class="controls">
										<input type="file" name="fupload"></input>
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
		<script type="text/javascript">
			$(document).ready(function(){
				$("#tgl1").datepicker({dateFormat:'yy/mm/dd'});
				$("#tgl2").datepicker({dateFormat:'yy/mm/dd'});
			});
		</script>
<?php break;
	case "edit":
	$id_mobil = $_GET['id_mobil'];
	$query = mysqli_query($conn, "SELECT * FROM mobil, direktorat, pegawai WHERE mobil.id_dir=direktorat.id_dir AND mobil.id_peg=pegawai.id_peg AND sha1(id_mobil)='$id_mobil'");
	$r = mysqli_fetch_array($query);
?>
		<section>
			<ul class="breadcrumb" style="margin-bottom:5px;">
				<li><a href="media.php?module=data_mobil">Data Mobil</a> <span class="divider"><b>&gt;</b></span></li>
				<li class="active">Update Mobil</li>
			</ul>

			<div class="row-fluid">
				<div class="span12 pull-left">
					<form method="post" enctype="multipart/form-data" action="<?php echo "$aksi?module=edit";?>">
						<input class="span11" type="hidden" id="inputText" name="id_mobil" value="<?php echo $r['id_mobil'] ?>"></input>
						<fieldset>
							<legend class="span7 offset1">Update Mobil</legend>
							<div class="clear"></div>
							<div class="span3 offset1" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
								<div class="control-group">
									<label class="control-label" for="inputPassword">Plat Nomor</label>
									<div class="controls">
										<input class="span10" type="text" id="inputText" name="plat_no" required value="<?php echo $r['plat_no']; ?>"></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Nama Pemilik</label>
									<select name="id_peg">
										<div class="controls">
											<option value="<?php echo $r['id_peg'] ?>"><?php echo $r['nama_peg'] ?></option>
											<?php
												$query = mysqli_query($conn, "SELECT * FROM pegawai");
												;
												while ($peg = mysqli_fetch_array($query)) {
											?>
												<option value="<?php echo $peg['id_peg'] ?>"><?php echo $peg['nama_peg'] ?></option>
											<?php } ?>
										</div>
									</select>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Direktorat</label>
									<select name="id_dir">
										<div class="controls">
											<option value="<?php echo $r['id_dir'] ?>"><?php echo $r['deskripsi'] ?></option>
											<?php
												$query = mysqli_query($conn, "SELECT * FROM direktorat");
												;
												while ($dir = mysqli_fetch_array($query)) {
											?>
												<option value="<?php echo $dir['id_dir'] ?>"><?php echo $dir['deskripsi'] ?></option>
											<?php } ?>
										</div>
									</select>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Type</label>
									<div class="controls">
										<input class="span-10" type="hidden" name="id_tg"></input>
										<input class="span10" type="text" id="inputText" name="type" required value="<?php echo $r['type'] ?>"></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Type Code</label>
									<div class="controls">
										<input class="span2" type="Radio" name="type_code" value="1" <?php if ($r['type_code'] == '1') { ?> checked <?php } ?>>Operasional</sup></input>
										<input class="span3" type="Radio" name="type_code" value="2" <?php if ($r['type_code'] == '2') { ?> checked <?php } ?>>Inventaris</input>
									</div>
								</div>							
							</div>						
							<div class="span3" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
								<div class="control-group">
									<label class="control-label" for="inputPassword">Masa Berlaku KEUR</label>
									<div class="controls">
										<input class="span10" type="date" id="tgl2" name="ms_ber_keur" required value="<?php echo $r['ms_ber_keur'] ?>"></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Masa Berlaku STNK</label>
									<div class="controls">
										<input class="span10" type="date" id="tgl1" name="ms_ber_stnk" required value="<?php echo $r['ms_ber_stnk']; ?>"></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">No Mesin</label>
									<div class="controls">
										<input class="span10" type="text" id="inputText" name="no_mesin" required value="<?php echo $r['no_mesin']; ?>"></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">No Rangka</label>
									<div class="controls">
										<input class="span10" type="text" id="inputText" name="no_rangka" required value="<?php echo $r['no_rangka']; ?>"></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">No BPKB</label>
									<div class="controls">
										<input class="span10" type="text" id="inputText" name="no_bpkb" required value="<?php echo $r['no_bpkb']; ?>"></input>
									</div>
								</div>							
							</div>
							<div class="span3" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
								<?php
									$foto = $r['photo'];
									if (isset($foto)) {
										echo "<img src='photo_mobil/$foto' style='width:150px; height:170px;'>";
									}
								?>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Photo</label>
									<div class="controls">
										<input type="file" name="fupload"></input>
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
		<script type="text/javascript">
			$(document).ready(function(){
				$("#tgl1").datepicker({dateFormat:'yy/mm/dd'});
				$("#tgl2").datepicker({dateFormat:'yy/mm/dd'});
			});
		</script>
<?php break;

case "seri_ban":
	$id_mobil = $_GET['id_mobil'];
	$query = mysqli_query($conn, "SELECT * FROM mobil, direktorat, pegawai WHERE mobil.id_dir=direktorat.id_dir AND mobil.id_peg=pegawai.id_peg AND sha1(id_mobil)='$id_mobil'");
	$r = mysqli_fetch_array($query);
?>
		<section>
			<ul class="breadcrumb" style="margin-bottom:5px;">
				<li><a href="media.php?module=data_mobil">Data Mobil</a> <span class="divider"><b>&gt;</b></span></li>
				<li class="active">Update Mobil</li>
			</ul>

			<div class="row-fluid">
				<div class="span12 pull-left">
					<form method="post" enctype="multipart/form-data" action="<?php echo "$aksi?module=seri_ban";?>">
						<input class="span11" type="hidden" id="inputText" name="id_mobil" value="<?php echo $r['id_mobil'] ?>"></input>
						<fieldset>
							<legend class="span7 offset1">Update Mobil</legend>
							<div class="clear"></div>
							<div class="span3 offset1" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
								<div class="control-group">
									<label class="control-label" for="inputPassword">No. Seri Ban A <sup>(Kiri Depan)</sup></label>
									<div class="controls">
										<input class="span10" type="text" id="inputText" name="no_seri_ban_a" value="<?php echo $r['no_seri_ban_a']; ?>"></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Tgl. Ganti Ban A <sup>(Kiri Depan)</sup></label>
									<div class="controls">
										<input class="span10" type="text" value="<?php echo tgl_indo($r['tgl_ganti_ban_a']); ?>" disabled></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">No. Seri Ban B <sup>(Kanan Depan)</sup></label>
									<div class="controls">
										<input class="span10" type="text" id="inputText" name="no_seri_ban_b" value="<?php echo $r['no_seri_ban_b']; ?>"></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Tgl. Ganti Ban B <sup>(Kanan Depan)</sup></label>
									<div class="controls">
										<input class="span10" type="text" value="<?php echo tgl_indo($r['tgl_ganti_ban_b']); ?>" disabled></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">No. Seri Ban C <sup>(Kiri Belakang)</sup></label>
									<div class="controls">
										<input class="span10" type="text" id="inputText" name="no_seri_ban_c" value="<?php echo $r['no_seri_ban_c']; ?>"></input>
									</div>
								</div>								
							</div>

							<div class="span3" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
								<div class="control-group">
									<label class="control-label" for="inputPassword">Tgl. Ganti Ban C <sup>(Kiri Belakang)</sup></label>
									<div class="controls">
										<input class="span10" type="text" value="<?php echo tgl_indo($r['tgl_ganti_ban_c']); ?>" disabled></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">No. Seri Ban D <sup>(Kanan Belakang)</sup></label>
									<div class="controls">
										<input class="span10" type="text" id="inputText" name="no_seri_ban_d" value="<?php echo $r['no_seri_ban_d']; ?>"></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Tgl. Ganti Ban D <sup>(Kanan Belakang)</sup></label>
									<div class="controls">
										<input class="span10" type="text" value="<?php echo tgl_indo($r['tgl_ganti_ban_d']); ?>" disabled></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">No. Seri Ban E <sup>(Ban Cadangan)</sup></label>
									<div class="controls">
										<input class="span10" type="text" id="inputText" name="no_seri_ban_e" value="<?php echo $r['no_seri_ban_e']; ?>"></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Tgl. Ganti Ban E <sup>(Ban Cadangan)</sup></label>
									<div class="controls">
										<input class="span10" type="text" value="<?php echo tgl_indo($r['tgl_ganti_ban_e']); ?>" disabled></input>
									</div>
								</div>
							</div>						
							<div class="span3" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
								<div class="control-group">
									<label class="control-label" for="inputPassword">Plat Nomor</label>
									<div class="controls">
										<input class="span10" type="text" value="<?php echo $r['plat_no']; ?>" disabled></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Nama Pemilik</label>
									<div class="controls">
										<?php
											$query = mysqli_query($conn, "SELECT * FROM pegawai WHERE id_peg='$r[id_peg]'");
											$row = mysqli_fetch_array($query);
										?>
										<input class="span10" type="text" value="<?php echo $row['nama_peg']; ?>" disabled></input>
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
		<script type="text/javascript">
			$(document).ready(function(){
				$("#tgl1").datepicker({dateFormat:'yy/mm/dd'});
				$("#tgl2").datepicker({dateFormat:'yy/mm/dd'});
			});
		</script>
<?php
	break;
		case "detail":
?>		
	<?php
		$id_mobil = $_GET['id_mobil'];
		$query = mysqli_query($conn, "SELECT * FROM mobil, pegawai, direktorat WHERE sha1(id_mobil)='$id_mobil' AND mobil.id_peg=pegawai.id_peg AND mobil.id_dir=direktorat.id_dir");
		$row = mysqli_fetch_array($query);
	?>
		<section>
			<ul class="breadcrumb" style="margin-bottom:5px;">
				<li><a href="media.php?module=data_mobil">Data Mobil</a> <span class="divider"><b>&gt;</b></span></li>
				<li class="active">Detail Mobil</li>
			</ul>
			<div class="row-fluid">
				<div class="span2 pull-left">
					<div class="rm_info">
						<div class="control-group">
							<div class="controls">
							<?php
								$foto = $row['photo'];
								if (isset($foto)) {
									echo "<img src='photo_mobil/$foto' style='width:170px; height:100px;' class='thumbnail'>";
								}
							?>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputText">Plat No</label>
							<div class="controls">
								<input class="span12" type="text" id="inputText" value="<?php echo $row['plat_no'];?>" disabled></input>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputText">Masa Berlaku STNK</label>
							<div class="controls">
								<input class="span12" type="text" id="inputText" value="<?php echo tgl_indo($row['ms_ber_stnk']);?>" disabled></input>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputText">Masa Berlaku KEUR</label>
							<div class="controls">
								<input class="span12" type="text" id="inputText" value="<?php echo tgl_indo($row['ms_ber_keur']);?>" disabled></input>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputText">No. Mesin</label>
							<div class="controls">
								<input class="span12" type="text" id="inputText" value="<?php echo $row['no_mesin'];?>" disabled></input>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputText">No. Rangka</label>
							<div class="controls">
								<input class="span12" type="text" id="inputText" value="<?php echo $row['no_rangka'];?>" disabled></input>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputText">No. BPKB</label>
							<div class="controls">
								<input class="span12" type="text" id="inputText" value="<?php echo $row['no_bpkb'];?>" disabled></input>
							</div>
						</div>						
					</div>
				</div>
				<div class="span10 thumb pull-right">
					<div class="tabbable" style="margin-bottom:18px;"> <!-- Begin of tabable -->
						<ul class="nav nav-tabs"> <!-- ini tombol" untuk berbagai pilihan aksi -->
							<li class="active"><a href="#data_owner" data-toggle="tab"><span class="fa fa-user"></span> Data Pemilik</a></li>
							<li><a href="#data_service" data-toggle="tab"><span class="fa fa-wrench"></span> Data Service</a></li>
							<li><a href="#data_gntspr" data-toggle="tab"><span class="fa fa-shopping-basket"></span> Data Ganti Sparepart</a></li>
							<li><a href="#data_bbm" data-toggle="tab"><span class="fa fa-tint"></span> Data BBM</a></li>
						</ul>
						<div class="tab-content" style="padding-bottom:9px;border-bottom:2px solid #d7d7d7">
							<div class="tab-pane active" id="data_owner">
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Owner</th>
											<th>Direktorat</th>
											<th>Jabatan</th>
											<th>Type Mobil</th>
											<th>Type Code</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><?php echo $row['nama_peg'] ?></td>
											<td><?php echo $row['deskripsi'] ?></td>
											<td><?php echo $row['jabatan'] ?></td>
											<td><?php echo $row['type'] ?></td>

											<?php
											if ($row['type_code'] == 1) { ?>
												<td>Operasional</td>
											<?php } else if($row['type_code'] == 2) { ?>
												<td>Inventaris</td>
											<?php } ?>												
										</tr>
									</tbody>
								</table>
							</div>

							<div class="tab-pane" id="data_service">
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>#</th>
											<th>Kode Service</th>
											<th>Bengkel</th>
											<th>Jenis Service</th>
											<th>Tanggal Request</th>
											<th>Status</th>
											<th>Tanggal Approve</th>
											<th>Estimasi Biaya</th>
											<th>Realisasi Biaya</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$p = new Paging;
											$batas = 5;
											$posisi = $p->cariPosisi($batas);
											$query = mysqli_query($conn, "SELECT * FROM service, bengkel WHERE sha1(id_mobil)='$id_mobil' AND service.id_bkl=bengkel.id_bkl ORDER BY id_svc DESC LIMIT $posisi, $batas");
											$no = $posisi+1;
											while ($r = mysqli_fetch_array($query)) {
										?>
											<tr>
												<td><?php echo $no ?></td>
												<td><?php echo $r['kode_svc'] ?></td>
												<td><?php echo $r['nama_bkl'] ?></td>
												<td>
												<table>
												<?php
													$query1 = mysqli_query($conn, "SELECT nama_serv AS nama_svc, harga_serv AS harga FROM detail_service WHERE kode_svc='$r[kode_svc]'");
													while ($det = mysqli_fetch_array($query1)) { ?>

													<tr>
														<td><?php echo $det['nama_svc'] ?></td>
														<td><?php echo format_rupiah($det['harga']) ?></td>
													</tr>
												<?php } ?>
												</table>
												</td>
												<td><?php echo tgl_indo($r['req_date']) ?></td>
												<td><?php echo $r['status'] ?></td>
												<td><?php echo tgl_indo($r['app2_date']) ?></td>
												<td><?php echo format_rupiah($r['cost_est']) ?></td>
												<td><?php echo format_rupiah($r['cost_real']) ?></td>
											</tr>
										<?php $no++; } ?>

											<tr>
												<td colspan="8">
												<?php
													$jmldata = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM service WHERE id_mobil='$id_mobil'"));
													$jmlhalaman = $p->jumlahHalaman($jmldata,$batas);
													$linkHalaman = $p->navHalamanact($_GET['halaman'], $jmlhalaman);
													echo "$linkHalaman";
												?>
													<td>Jumlah Record <?php echo $jmldata;?></td>
												</td>
											</tr>
									</tbody>
								</table>
							</div>

							<div class="tab-pane" id="data_gntspr">
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>#</th>
											<th>Kode Ganti Sparepart</th>
											<th>Bengkel</th>
											<th>Jenis Sparepart</th>
											<th>Tanggal Request</th>
											<th>Status</th>
											<th>Tanggal Approve</th>
											<th>Estimasi Biaya</th>
											<th>Realisasi Biaya</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$p = new Paging;
											$batas = 5;
											$posisi = $p->cariPosisi($batas);
											$query = mysqli_query($conn, "SELECT * FROM ganti_sparepart, bengkel WHERE sha1(id_mobil)='$id_mobil' AND ganti_sparepart.id_bkl=bengkel.id_bkl ORDER BY id_spr DESC LIMIT $posisi, $batas");
											$no = $posisi+1;
											while ($r = mysqli_fetch_array($query)) {
										?>
											<tr>
												<td><?php echo $no ?></td>
												<td><?php echo $r['kode_spr'] ?></td>
												<td><?php echo $r['nama_bkl'] ?></td>
												<td>
												<table>
												<?php
													$query1 = mysqli_query($conn, "SELECT nama_sprt AS nama_spr, harga_sprt AS harga FROM detail_gs WHERE kode_spr='$r[kode_spr]'");
													while ($det = mysqli_fetch_array($query1)) { ?>

													<tr>
														<td><?php echo $det['nama_spr'] ?></td>
														<td><?php echo format_rupiah($det['harga']) ?></td>
													</tr>
												<?php } ?>
												</table>
												</td>
												<td><?php echo tgl_indo($r['req_date']) ?></td>
												<td><?php echo $r['status'] ?></td>
												<td><?php echo tgl_indo($r['app2_date']) ?></td>
												<td><?php echo format_rupiah($r['cost_est']) ?></td>
												<td><?php echo format_rupiah($r['cost_real']) ?></td>
											</tr>
										<?php $no++; } ?>

											<tr>
												<td colspan="8">
												<?php
													$jmldata = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM ganti_sparepart WHERE sha1(id_mobil)='$id_mobil'"));
													$jmlhalaman = $p->jumlahHalaman($jmldata,$batas);
													$linkHalaman = $p->navHalamanact($_GET['halaman'], $jmlhalaman);
													echo "$linkHalaman";
												?>
													<td>Jumlah Record <?php echo $jmldata;?></td>
												</td>
											</tr>
									</tbody>
								</table>
							</div>

							<div class="tab-pane" id="data_bbm">
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>#</th>
											<th>Tgl Beli</th>
											<th>Kilometer</th>
											<th>Litter</th>
											<th>Value</th>
											<th>Rasio</th>
										</tr>
									</thead>
									<tbody>
									<?php
									$p = new Paging;
									$batas = 5;
									$posisi = $p->cariPosisi($batas);
									$no = $posisi+1;
									if ($row['type_code'] == 1) { ?>
										<?php
										
										$query1 = mysqli_query($conn, "SELECT * FROM kilometer WHERE sha1(id_mobil)='$id_mobil' AND solar_1 <> 0 ORDER BY jam_plg DESC LIMIT $posisi, $batas");
										while ($r = mysqli_fetch_array($query1)) { ?> 

										<tr>
											<td><?php echo $no ?></td>
											<td><?php echo tgl_indo($r['jam_plg']) ?></td>
											<td>
												<table>
													<tr>
														<td><?php echo format_ribuan($r['km_solar1']) ?></td>
													</tr>
													<tr>
														<td><?php echo format_ribuan($r['km_solar2']) ?></td>
													</tr>
													<tr>
														<td><?php echo format_ribuan($r['km_solar3']) ?></td>
													</tr>
												</table>
											</td>
											<td>
												<table>
													<tr>
														<td><?php echo format_ribuan2($r['solar_1']) ?></td>
													</tr>
													<tr>
														<td><?php echo format_ribuan2($r['solar_2']) ?></td>
													</tr>
													<tr>
														<td><?php echo format_ribuan2($r['solar_3']) ?></td>
													</tr>
												</table>
											</td>
											<td>
												<table>
													<tr>
														<td><?php echo format_rupiah($r['harga_solar1']) ?></td>
													</tr>
													<tr>
														<td><?php echo format_rupiah($r['harga_solar2']) ?></td>
													</tr>
													<tr>
														<td><?php echo format_rupiah($r['harga_solar3']) ?></td>
													</tr>
												</table>
											</td>
											<td>
												<table>
													<tr>
														<td><?php echo format_ribuan2($r['rasio_solar1']) ?></td>
													</tr>
													<tr>
														<td><?php echo format_ribuan2($r['rasio_solar2']) ?></td>
													</tr>
													<tr>
														<td><?php echo format_ribuan2($r['rasio_solar3']) ?></td>
													</tr>
												</table>
											</td>
										</tr>
										<?php $no++; } ?>
										<tr>
											<td colspan="5">
											<?php
												$jmldata = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM kilometer WHERE sha1(id_mobil)='$id_mobil' AND solar_1 <> 0"));
												$jmlhalaman = $p->jumlahHalaman($jmldata,$batas);
												$linkHalaman = $p->navHalamanact($_GET['halaman'], $jmlhalaman);
												echo "$linkHalaman";
											?>
												<td>Jumlah Record <?php echo $jmldata;?></td>
											</td>
										</tr>
									<?php } else if ($row['type_code'] == 2) { ?>
										<?php
										
										$query1 = mysqli_query($conn, "SELECT * FROM bensin WHERE sha1(id_mobil)='$id_mobil' ORDER BY tgl_isi DESC LIMIT $posisi, $batas");
										while ($r = mysqli_fetch_array($query1)) { ?> 

										<tr>
											<td><?php echo $no ?></td>
											<td><?php echo tgl_indo($r['tgl_isi']) ?></td>
											<td><?php echo format_ribuan($r['km_bensin']) ?></td>
											<td><?php echo format_ribuan2($r['bensin']) ?></td>
											<td><?php echo format_rupiah($r['harga']) ?></td>
											<td><?php echo format_ribuan2($r['rasio']) ?></td>
										</tr>
										<?php $no++; } ?>
										<tr>
											<td colspan="5">
											<?php
												$jmldata = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bensin WHERE sha1(id_mobil)='$id_mobil'"));
												$jmlhalaman = $p->jumlahHalaman($jmldata,$batas);
												$linkHalaman = $p->navHalamanact($_GET['halaman'], $jmlhalaman);
												echo "$linkHalaman";
											?>
												<td>Jumlah Record <?php echo $jmldata;?></td>
											</td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

<?php break;
	}
?>