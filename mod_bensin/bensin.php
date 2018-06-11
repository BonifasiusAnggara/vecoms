<?php
	$aksi = "mod_bensin/aksi_bensin.php";
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
							url : "mod_bensin/cari.php",
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
				<li class="active">Data Bensin</li>
			</ul>
			<div class="control-group pull-left">
				<button class="btn btn-info" type="button" onclick="window.location='media.php?module=bensin&&act=tambah'"><i class="icon-chevron-right icon-white"></i> Input Pengisian Bensin</button>
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
								<tr class="head">
									<td>No.</td>
									<td>Plat No Mobil</td>
									<td>Owner Mobil</td>
									<td>Litter Bensin</td>
									<td>Km Bensin</td>
									<td>Harga Bensin</td>
									<td>Tanggal Isi</td>
									<td>Rasio Bensin</td>
									<td></td>
								</tr>
							</thead>
							<tbody>
							<?php
								$query = mysqli_query($conn, "SELECT * FROM bensin, mobil, pegawai WHERE bensin.id_mobil=mobil.id_mobil AND bensin.id_peg=pegawai.id_peg ORDER BY id_bensin DESC LIMIT $posisi, $batas");
								$no = $posisi+1;
								while ($r = mysqli_fetch_array($query)) {
							?>
								<tr>
									<td><?php echo $no.".";?></td>
									<td><?php echo $r['plat_no'];?></td>
									<td><?php echo $r['nama_peg'];?></td>
									<td><?php echo format_ribuan2($r['bensin']) ?></td>
									<td><?php echo format_ribuan($r['km_bensin'])?></td>
									<td><?php echo format_rupiah($r['harga'])?></td>
									<td><?php echo tgl_indo($r['tgl_isi'])?></td>
									<td><?php echo format_ribuan2($r['rasio'])?></td>

									<?php if ($akses == 3 OR $akses == 2) { ?>
									<td>
										<div class="btn-group">
											<a class="btn btn-success" href="#"><i class="icon-wrench icon-white"></i> Actions</a>
											<a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
											<ul class="dropdown-menu">
												<li><a href="<?php echo "$aksi?module=hapus&&id_bensin=$r[id_bensin]";?>" onclick="return confirm('Apakah anda yakin, ingin menghapus data Bensin<?php echo $r['plat_no'];?> ?')"><i class="icon-trash"></i> Delete</a></li>
											</ul>
										</div>
									</td>
									<?php } else { ?> <td></td> <?php } ?>

								</tr>
							<?php $no++;
								}
							?>
								<tr>
									<td colspan="8">
									<?php
										$jmldata = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bensin"));
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
		<script type="text/javascript">
			$(document).ready(function(){
				<!-- event textbox change
				$("#hasil_km").css("display","block");
				$("#id_mobil").change(function(){
					var id_mobil = $("#id_mobil").val();
					if (id_mobil != "") {
						$("#hasil_km").html("<img src='assets/images/loader.gif'/>")
						$.ajax({
							type: "POST",
							url : "mod_bensin/cari_km.php",
							data: "q="+id_mobil,
							success: function(data){
								$("#hasil_km").css("display","block");
								$("#hasil_km").html(data);
							}
						})
					}
				});
			});
		</script>
		
		<section>
			<ul class="breadcrumb" style="margin-bottom:5px;">
				<li><a href="media.php?module=bensin">Data Bensin</a> <span class="divider"><b>&gt;</b></span></li>
				<li class="active">Input Pengisian Bensin</li>
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
												$query = mysqli_query($conn, "SELECT * FROM mobil WHERE type_code = '2'");
												;
												while ($mbl = mysqli_fetch_array($query)) {
											?>
												<option value="<?php echo $mbl['id_mobil'] ?>"><?php echo $mbl['plat_no'] ?></option>
											<?php } ?>
										</div>
									</select>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Owner</label>
									<select name="id_peg" class="span10" required>
										<div class="controls">
											<option>~ Owner ~</option>
											<?php
												$query = mysqli_query($conn, "SELECT * FROM pegawai WHERE golongan = '4' OR golongan = '5'");
												;
												while ($peg = mysqli_fetch_array($query)) {
											?>
												<option value="<?php echo $peg['id_peg'] ?>"><?php echo $peg['nama_peg'] ?></option>
											<?php } ?>
										</div>
									</select>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Tanggal isi Bensin</label>
									<div class="controls">
										<input class="span10" type="date" name="tgl_isi" id="tgl" required></input>
									</div>
								</div>
								<div id="hasil_km"></div>
							</div>

							<div class="span3" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
								<div class="control-group">
									<label class="control-label" for="inputPassword">Litter(s) Bensin</label>
									<div class="controls">
										<input class="span10" type="text" name="bensin" required></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Km isi Bensin</label>
									<div class="controls">
										<input class="span10" type="text" name="km_bensin" id="km_bensin" required></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Harga Bensin</label>
									<div class="controls">
										<input class="span10" type="text" name="harga" id="harga" required></input>
									</div>
								</div>				
								<hr>
								<div class="control-group">
									<div class="controls">
										<button class="btn btn-success" type="submit"><i class="icon-ok-circle icon-white"></i> Simpan</button>
										<button class="btn btn-warning" type="reset"><i class="icon-refresh icon-white"></i> Reset</button>
									</div>
								</div>
								<script type="text/javascript">
									$(document).ready(function(){
										$("#tgl").datepicker({dateFormat:'yy/mm/dd'});
									});
								</script>
						</fieldset>
					</form>
				</div>
			</div>
		</section>
<?php
	break;
	}
?>