<?php
	$aksi = "mod_pegawai/aksi_pegawai.php";
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
						url : "mod_pegawai/cari.php",
						data: "q=" + strcari+"&akses="+akses,
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
		<ul class="breadcrumb" style="margin-bottom: 5px">
			<li class="active">Data Pegawai</li>
		</ul>

		<div class="control-group pull-left">
			<button class="btn btn-primary" type="button" onclick="window.location='media.php?module=data_pegawai&&act=tambah'"><i class="icon-plus icon-white"></i> Tambah Pegawai</button>
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
							<tr class="head1">
								<td>No.</td>			
								<td>NIK</td>
								<td>Nama Pegawai</td>								
								<td>Direktorat</td>								
								<td>Jabatan</td>								
								<td>Tanggal Lahir</td>
								<td>Alamat</td>
								<td>No HP</td>
								<td>No. SIM</td>
								<td>Tgl. Berlaku SIM</td>
								<td></td>
							</tr>	
						</thead>

						<tbody>
						<?php
							$query = mysqli_query($conn, "SELECT * FROM pegawai, direktorat WHERE pegawai.id_dir=direktorat.id_dir ORDER BY pegawai.id_dir ASC LIMIT $posisi, $batas");
							$no = $posisi+1;
							while ($r = mysqli_fetch_array($query)) { ?>
							<tr>
								<td><?php echo $no."."; ?></td>
								<td><?php echo $r['NIP']; ?></td>
								<td><?php echo $r['nama_peg']; ?></td>
								<td><?php echo $r['deskripsi']; ?></td>
								<td><?php echo $r['jabatan']; ?></td>
								<td><?php echo tgl_indo($r['tgl_lhr']); ?></td>
								<td><?php echo $r['alamat']; ?></td>
								<td><?php echo $r['no_hp'] ?></td>
								<td><?php echo $r['no_sim'] ?></td>
								<td><?php echo $r['tgl_ber_sim'] ?></td>
								<td>
									<div class="btn-group">
										<a class="btn btn-primary" href="#"><i class="icon-wrench icon-white"></i> Actions</a>
										<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
										<ul class="dropdown-menu">
											<li><a href="media.php?module=data_pegawai&&act=edit&&id_pegawai=<?php echo sha1($r['id_peg']) ?>"><i class="icon-pencil"></i> Edit</a></li>
											<li><a href="<?php echo "$aksi?module=hapus&&id_pegawai=$r[id_peg]"; ?>" onclick="return confirm('Apakah Anda yakin, ingin menghapus data pegawai <?php echo $r['nama_peg']; ?> ?')"><i class="icon-trash"></i> Delete</a></li>
										</ul>
									</div>
								</td>
							</tr>
					<?php $no++; } ?>
							<tr>
								<td colspan="10">
								<?php
									$jmldata = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pegawai"));
									$jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
									$linkhalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
									echo "$linkhalaman";
								?>
								<td>Jumlah Record <?php echo $jmldata; ?></td>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>

<?php break;
		case "tambah":
?>
	<script type="text/javascript">
		$(document).ready(function(){
			<!-- event textbox keyup
			$("#tgl").keyup(function(){
				var strtgl = $("#tgl").val();
				if (strtgl != "") {
					$("#hasil_umur").html("<img src='assets/images/loader.gif'/>")
					$.ajax({
						type: "POST",
						url : "mod_pegawai/umur.php",
						data: "q=" + strtgl,
						success: function(data){
							$("#hasil_umur").css("display","block");
							$("#hasil_umur").html(data);
						}
					});
				} else {
					$("#hasil_umur").css("display","none");
				}
			});

			$("#tgl").datepicker({dateFormat:'yy/mm/dd'});
			$("#tgl1").datepicker({dateFormat:'yy/mm/dd'});
		});
	</script>

	<section>
		<ul class="breadcrumb" style="margin-bottom: 5px">
			<li><a href="media.php?module=data_pegawai">Data Pegawai</a>
			<span class="divider"><b>&gt;</b></span></li>
			<li class="active">Tambah Pegawai</li>
		</ul>

		<div class="row-fluid">
			<div class="span12 pull-left">
				<form method="post" enctype="multipart/form-data" action="<?php echo "$aksi?module=tambah"; ?>">
					<fieldset>
						<legend class="span7 offset1">Tambah Pegawai</legend>
						<div class="clear"></div>
						<div class="span3 offset1" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
							<div class="control-group">
								<label class="control-label" for="inputPassword">NIP</label>
								<div class="controls">
									<input class="span11" type="hidden" name="id_peg" required></input>
									<input class="span11" type="text" id="inputText" name="nip" required></input>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputPassword">Nama Pegawai</label>
								<div class="controls">
									<input class="span11" type="text" id="inputText" name="nama_peg" required></input>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputPassword">Jabatan</label>
								<div class="controls">
									<input class="span11" type="text" id="inputText" name="jabatan" required></input>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputPassword">Tempat Lahir</label>
								<div class="controls">
									<input class="span11" type="text" id="inputText" name="tpt_lhr"></input>
								</div>
							</div>					
							<div class="control-group">
								<label class="control-label" for="inputPassword">Tanggal Lahir</label>
								<div class="controls">
									<input class="span11" type="text" id="tgl" name="tgl_lhr" required></input>
								</div>
							</div>
						</div>
						<div class="span3" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
							<div class="control-group">
								<label class="control-label" for="inputPassword">Direktorat</label>
								<select name="id_dir" required>
									<div class="controls">
										<option>~ Direktorat ~</option>
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
								<label class="control-label" for="inputPassword">Alamat</label>
								<div class="controls">
									<textarea class="span11" type="text" id="inputText" name="alamat" required></textarea>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputPassword">Golongan</label>
								<div class="controls">
									<input class="span11" type="text" id="inputText" name="golongan" required></input>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputPassword">No HP</label>
								<div class="controls">
									<input class="span11" type="text" id="inputText" name="no_hp"></input>
								</div>
							</div>
							<div id="hasil_umur"></div>
						</div>
						<div class="span3" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
							<div class="control-group">
								<label class="control-label" for="inputPassword">No SIM</label>
								<div class="controls">
									<input class="span11" type="text" id="inputText" name="no_sim"></input>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputPassword">Tgl. Berlaku SIM</label>
								<div class="controls">
									<input class="span11" type="text" id="tgl1" name="tgl_ber_sim" required></input>
								</div>
							</div>
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

<?php break; 
		case "edit":
?>
	<script type="text/javascript">
		$(document).ready(function(){
			<!-- event textbox keyup
			$("#tgl").keyup(function(){
				var strtgl = $("#tgl").val();
				if (strtgl != "") {
					$("#hasil_umur").html("<img src='assets/images/loader.gif'/>")
					$.ajax({
						type: "POST",
						url : "mod_pegawai/umur.php",
						data: "q=" + strtgl,
						success: function(data){
							$("#hasil_umur").css("display","block");
							$("#hasil_umur").html(data);
						}
					});
				} else {
					$("#hasil_umur").css("display","none");
				}
			});

			$("#tgl").datepicker({dateFormat:'yy/mm/dd'});
			$("#tgl1").datepicker({dateFormat:'yy/mm/dd'});
		});
	</script>

<?php
	$id_pegawai = $_GET['id_pegawai'];
	$query = mysqli_query($conn, "SELECT * FROM pegawai, direktorat WHERE pegawai.id_dir=direktorat.id_dir AND sha1(id_peg)='$id_pegawai'");
	$r = mysqli_fetch_array($query);
?>
	<section>
		<ul class="breadcrumb" style="margin-bottom: 5px">
			<li><a href="media.php?module=data_pegawai">Data Pegawai</a>
			<span class="divider"><b>&gt;</b></span></li>
			<li class="active">Update Pegawai</li>
		</ul>

		<div class="row-fluid">
			<div class="span12 pull-left">
				<form method="post" enctype="multipart/form-data" action="<?php echo "$aksi?module=edit" ?>">
					<input class="span11" type="hidden" id="inputText" name="id_peg" value="<?php echo $r['id_peg'] ?>"></input>
					<fieldset>
						<legend class="span7 offset1">Update Pegawai</legend>
						<div class="clear"></div>
						<div class="span3 offset1" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
							<div class="control-group">
								<label class="control-label" for="inputPassword">NIP</label>
								<div class="controls">
									<input class="span11" type="text" id="inputText" name="nip" value="<?php echo $r['NIP'] ?>"></input>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputPassword">Nama Pegawai</label>
								<div class="controls">
									<input class="span11" type="text" id="inputText" name="nama_peg" value="<?php echo $r['nama_peg'] ?>"></input>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputPassword">Jabatan</label>
								<div class="controls">
									<input class="span11" type="text" id="inputText" name="jabatan" value="<?php echo $r['jabatan'] ?>"></input>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputPassword">Tempat Lahir</label>
								<div class="controls">
									<input class="span11" type="text" id="inputText" name="tpt_lhr" value="<?php echo $r['tpt_lhr'] ?>"></input>
								</div>
							</div>							
							<div class="control-group">
								<label class="control-label" for="inputPassword">Tanggal Lahir</label>
								<div class="controls">
									<input class="span11" type="text" id="tgl" name="tgl_lhr" value="<?php echo $r['tgl_lhr'] ?>"></input>
								</div>
							</div>
						</div>
						<div class="span3" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
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
								<label class="control-label" for="inputPassword">Alamat</label>
								<div class="controls">
									<textarea class="span11" type="text" id="inputText" name="alamat"><?php echo $r['alamat'] ?></textarea>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputPassword">Golongan</label>
								<div class="controls">
									<input class="span11" type="text" id="inputText" name="golongan" value="<?php echo $r['golongan'] ?>"></input>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputPassword">No HP</label>
								<div class="controls">
									<input class="span11" type="text" id="inputText" name="no_hp" value="<?php echo $r['no_hp'] ?>"></input>
								</div>
							</div>
							<div id="hasil_umur"></div>							
						</div>
						<div class="span3" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
							<div class="control-group">
								<label class="control-label" for="inputPassword">No SIM</label>
								<div class="controls">
									<input class="span11" type="text" id="inputText" name="no_sim" value="<?php echo $r['no_sim'] ?>"></input>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputPassword">Tgl. Berlaku SIM</label>
								<div class="controls">
									<input class="span11" type="text" id="tgl1" name="tgl_ber_sim" value="<?php echo $r['tgl_ber_sim'] ?>"></input>
								</div>
							</div>
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
	
<?php break; } ?>