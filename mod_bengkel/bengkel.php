<?php
	$aksi = "mod_bengkel/aksi_bengkel.php";
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
							url : "mod_bengkel/cari.php",
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
				<li class="active">Data Bengkel</li>
			</ul>
			<div class="control-group pull-left">
				<button class="btn btn-success" type="button" onclick="window.location='media.php?module=data_bengkel&&act=tambah'"><i class="icon-plus icon-white"></i> Tambah Bengkel</button>
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
									<td>Kode Bengkel</td>
									<td>Nama Bengkel</td>
									<td>Alamat</td>
									<td>No Telephone</td>
									<td>Contact Person</td>
									<td>Nomor Kontrak</td>
									<td>Tgl. Berlaku Kontrak</td>
									<td></td>
								</tr>
							</thead>
							<tbody>
							<?php
								$query = mysqli_query($conn, "SELECT * FROM bengkel ORDER BY nama_bkl ASC LIMIT $posisi, $batas");
								$no = $posisi+1;
								while ($r = mysqli_fetch_array($query)) {
							?>
								<tr>
									<td><?php echo $no.".";?></td>
									<td><?php echo $r['kode_bkl'];?></td>
									<td><?php echo $r['nama_bkl'];?></td>
									<td><?php echo $r['alamat'];?></td>
									<td><?php echo $r['no_telp'];?></td>
									<td><?php echo $r['contact_person'];?></td>
									<td><?php echo $r['no_kontrak'] ?></td>
									<td><?php echo $r['tgl_berlaku_kontrak'] ?></td>
									<?php if ($akses != '3') { ?> 
									<td></td>
									<?php } else { ?>
									<td>
										<div class="btn-group">
											<a class="btn btn-success" href="#"><i class="icon-wrench icon-white"></i> Actions</a>
											<a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
											<ul class="dropdown-menu">
												<li><a href="media.php?module=data_bengkel&&act=edit&&kode_bkl=<?php echo sha1($r['kode_bkl']);?>"><i class="icon-pencil"></i> Edit</a></li>
												<li><a href="<?php echo "$aksi?module=hapus&&kode_bkl=$r[kode_bkl]";?>" onclick="return confirm('Apakah anda yakin, ingin menghapus data bengkel <?php echo $r['nama_bkl'];?> ?')"><i class="icon-trash"></i> Delete</a></li>
											</ul>
										</div>
									</td>
									<?php } ?> 
								</tr>
							<?php $no++;
								}
							?>
								<tr>
									<td colspan="8">
									<?php
										$jmldata = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bengkel"));
										$jmlhalaman = $p->jumlahHalaman($jmldata,$batas);
										$linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
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
		$time_stamp = date("sdy");
		$acak1 = $time_stamp;

		function acakangkahuruf($panjang) {
			$karakter = '0123456789';
			$string = '';
			for ($i = 0; $i < $panjang; $i++) {
				$pos = rand(0, strlen($karakter)-1);
				$string .= $karakter{$pos};
			}
			return $string;
		}

		$acak2 = acakangkahuruf(3);
		$nounik = "BKL-".$acak1.$acak2;
?>		
		<script type="text/javascript">
			$(document).ready(function(){
				$("#tgl").datepicker({dateFormat:'yy/mm/dd'});
			});
		</script>

		<section>
			<ul class="breadcrumb" style="margin-bottom:5px;">
				<li><a href="media.php?module=data_bengkel">Data Bengkel</a> <span class="divider"><b>&gt;</b></span></li>
				<li class="active">Tambah Bengkel</li>
			</ul>

			<div class="row-fluid">
				<div class="span12 pull-left">
					<form method="post" enctype="multipart/form-data" action="<?php echo "$aksi?module=tambah";?>">
						<input class="span10" type="hidden" id="inputText" value="<?php echo $row['kodeUser'];?>" name="t7"></input>
						<fieldset>
							<legend class="span7 offset1">Tambah Bengkel</legend>
							<div class="clear"></div>
							<div class="span3 offset1" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
								<div class="control-group">
									<label class="control-label" for="inputPassword">Nama Bengkel</label>
									<div class="controls">
										<input class="span10" type="text" id="inputText" name="nama_bkl"></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">No Telephone</label>
									<div class="controls">
										<input class="span10" type="text" id="inputText" name="no_telp"></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Contact Person</label>
									<div class="controls">
										<input class="span10" type="text" id="inputText" name="contact_person"></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">No. Kontrak</label>
									<div class="controls">
										<input class="span10" type="text" id="inputText" name="no_kontrak"></input>
									</div>
								</div>								
							</div>
							<div class="span3" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
								<div class="control-group">
									<label class="control-label" for="inputPassword">Kode Bengkel</label>
									<div class="controls">
										<input class="span6" type="text" value="<?php echo $nounik;?>" disabled></input>
										<input class="span6" type="hidden" value="<?php echo $nounik;?>" name="kode_bkl"></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Alamat</label>
									<div class="controls">
										<textarea name="alamat"></textarea>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Tgl. Berlaku Kontrak</label>
									<div class="controls">
										<input class="span10" type="text" id="tgl" name="tgl_berlaku_kontrak"></input>
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
		case "edit":
		$kode_bkl = $_GET['kode_bkl'];
		$query = mysqli_query($conn, "SELECT * FROM bengkel WHERE sha1(kode_bkl)='$kode_bkl'");
		$r = mysqli_fetch_array($query);
?>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#tgl").datepicker({dateFormat:'yy/mm/dd'});
			});
		</script>
		
		<section>
			<ul class="breadcrumb" style="margin-bottom:5px;">
				<li><a href="media.php?module=data_bengkel">Data Bengkel</a> <span class="divider"><b>&gt;</b></span></li>
				<li class="active">Update Bengkel</li>
			</ul>

			<div class="row-fluid">
				<div class="span12 pull-left">
					<form method="post" enctype="multipart/form-data" action="<?php echo "$aksi?module=edit";?>">
						<input class="span10" type="hidden" id="inputText" value="<?php echo $row['kodeUser'];?>" name="t7"></input>
						<fieldset>
							<legend class="span7 offset1">Ubah Bengkel</legend>
							<div class="clear"></div>
							<div class="span3 offset1" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
								<div class="control-group">
									<label class="control-label" for="inputPassword">Nama Bengkel</label>
									<div class="controls">
										<input class="span10" type="text" id="inputText" name="nama_bkl" value="<?php echo $r['nama_bkl'] ?>"></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">No Telephone</label>
									<div class="controls">
										<input class="span10" type="text" id="inputText" name="no_telp" value="<?php echo $r['no_telp'] ?>"></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Contact Person</label>
									<div class="controls">
										<input class="span10" type="text" id="inputText" name="contact_person" value="<?php echo $r['contact_person'] ?>"></input>
									</div>
								</div>	
								<div class="control-group">
									<label class="control-label" for="inputPassword">No. Kontrak</label>
									<div class="controls">
										<input class="span10" type="text" id="inputText" name="no_kontrak" value="<?php echo $r['no_kontrak'] ?>"></input>
									</div>
								</div>								
							</div>
							<div class="span3" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
								<div class="control-group">
									<label class="control-label" for="inputPassword">Kode Bengkel</label>
									<div class="controls">
										<input class="span6" type="text" value="<?php echo $r['kode_bkl'] ?>" disabled></input>
										<input class="span6" type="hidden" value="<?php echo $r['kode_bkl'] ?>" name="kode_bkl"></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Alamat</label>
									<div class="controls">
										<textarea name="alamat"><?php echo $r['alamat'] ?></textarea>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Tgl. Berlaku Kontrak</label>
									<div class="controls">
										<input class="span10" type="text" id="tgl" name="tgl_berlaku_kontrak" value="<?php echo $r['tgl_berlaku_kontrak'] ?>"></input>
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