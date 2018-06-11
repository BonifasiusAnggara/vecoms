<?php
	$aksi = "mod_sparepart/aksi_sparepart.php";
	switch ($_GET['act']) {
		default:

		$p = new Paging;
		$batas = 10;
		$posisi = $p->cariPosisi;
?>
		<section>
			<ul class="breadcrumb" style="margin-bottom:5px;">
				<li class="active">Data Sparepart</li>
			</ul>
			<div class="span5 pull-left" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
				<div class="row-fluid">
					<div class="span12">
						<form method="post" enctype="multipart/form-data" action="<?php echo "$aksi?module=tambah";?>">
							<legend class="span12">Tambah Data Sparepart</legend>
							<div class="clear"></div>
							<div class="span8">
								<div class="control-group">
									<label class="control-label" for="inputPassword">Bengkel</label>
									<select name="id_bkl" required>
										<div class="controls">
											<option>~ Bengkel ~</option>
											<?php
												$query = mysqli_query($conn, "SELECT * FROM bengkel");
												;
												while ($bkl = mysqli_fetch_array($query)) {
											?>
												<option value="<?php echo $bkl['id_bkl'] ?>"><?php echo $bkl['nama_bkl'] ?></option>
											<?php } ?>
										</div>
									</select>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Nama Sparepart</label>
									<div class="controls">
										<input class="span11" type="text" name="nama_sprt" required></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Harga</label>
									<div class="controls">
										<input class="span11" type="text" name="harga_sprt" required></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Masa Ganti</label>
									<div class="controls">
										<input class="span10" type="text" name="masa_ganti" required></input>&nbsp; Hari
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
						</form>
					</div>
				</div>
			</div>
			<div class="span7 pull-right">
				<div class="row-fluid">
					<div class="span12">
						<div id="tabel_awal">
							<fieldset>
								<legend class="span12">Data Sparepart</legend>
								<table class="table table-striped">
									<thead>
										<tr class="head3">
											<td>No.</td>
											<td>Nama Sparepart</td>
											<td>Harga</td>
											<td>Masa Ganti (Hari)</td>
											<td></td>
										</tr>
									</thead>
									<tbody>
									<?php
										$query = mysqli_query($conn, "SELECT * FROM bengkel");
										$no = 1;
										while ($r = mysqli_fetch_array($query)) {
									?>
										<tr>
											<td><?php echo $no.".";?></td>
											<td>
											<?php echo $r['nama_bkl']."<td></td><td></td><td></td><br>"; ?>
												<tr>
												<?php
													$id_bkl = $r['id_bkl'];
													$sprt = mysqli_query($conn, "SELECT * FROM sparepart, bengkel WHERE sparepart.id_bkl=bengkel.id_bkl AND sparepart.id_bkl='$id_bkl'");
													while ($sp = mysqli_fetch_array($sprt)) { ?>
													<td></td>
													<td>--> <?php echo $sp['nama_sprt']?></td>
													<td><?php echo format_rupiah($sp['harga_sprt']); ?></td>
													<td><?php echo $sp['masa_ganti'] ?> Hari</td>
													<?php if ($akses == 3) { ?>
													<td>
														<div class="btn-group">
															<a class="btn btn-danger" href="#"><i class="icon-wrench icon-white"></i> Actions</a>
															<a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
															<ul class="dropdown-menu">
																<li><a href="media.php?module=data_sparepart&&act=edit&&id_sprt=<?php echo sha1($sp['id_sprt']);?>"><i class="icon-pencil"></i> Edit</a></li>
																<li><a href="<?php echo "$aksi?module=hapus&&id_sprt=$sp[id_sprt]";?>" onclick="return confirm('Apakah anda yakin, ingin menghapus data sparepart <?php echo $sp['nama_sprt'];?> dari bengkel <?php echo $r['nama_bkl'] ?>?')"><i class="icon-trash"></i> Delete</a></li>
															</ul>
														</div>
													</td>
													<?php } ?>
												</tr>
											<?php } ?>
											</td>
										</tr>
									<?php $no++;
										}
									?>
									</tbody>
								</table>
							</fieldset>
						</div>
					</div>
				</div>
			</div>
		</section>
<?php
	break;
		case "edit":
		$id_sprt = $_GET['id_sprt'];
		$query = mysqli_query($conn, "SELECT * FROM sparepart, bengkel WHERE sha1(id_sprt)='$id_sprt' AND sparepart.id_bkl=bengkel.id_bkl");
		$r = mysqli_fetch_array($query);
?>
		<section>
			<ul class="breadcrumb" style="margin-bottom:5px;">
				<li><a href="media.php?module=data_sparepart">Data Sparepart</a> <span class="divider"><b>&gt;</b></span></li>
				<li class="active">Ubah Sparepart</li>
			</ul>
			<div class="control-group pull-left"></div>
			<div class="span5 pull-left" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
				<div class="row-fluid">
					<div class="span12">
						<form method="post" enctype="multipart/form-data" action="<?php echo "$aksi?module=edit";?>">
							<legend class="span12">Ubah Data Sparepart</legend>
							<div class="clear"></div>
							<div class="span8">
								<div class="control-group">
									<label class="control-label" for="inputPassword">Bengkel</label>
									<select name="id_bkl" required>
										<div class="controls">
											<option value="<?php echo $r['id_bkl'] ?>"><?php echo $r['nama_bkl'] ?></option>
											<?php
												$query = mysqli_query($conn, "SELECT * FROM bengkel");
												;
												while ($bkl = mysqli_fetch_array($query)) {
											?>
												<option value="<?php echo $bkl['id_bkl'] ?>"><?php echo $bkl['nama_bkl'] ?></option>
											<?php } ?>
										</div>
									</select>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword"> Nama Sparepart</label>
									<div class="controls">
										<input class="span11" type="text" name="nama_sprt" value="<?php echo $r['nama_sprt'];?>" required></input>
										<input class="span11" type="hidden" name="id_sprt" value="<?php echo $r['id_sprt'];?>"></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword"> Harga</label>
									<div class="controls">
										<input class="span11" type="text" name="harga_sprt" value="<?php echo $r['harga_sprt'];?>" required></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Masa Ganti</label>
									<div class="controls">
										<input class="span10" type="text" name="masa_ganti" value="<?php echo $r['masa_ganti'] ?>" required></input>&nbsp; Hari
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
						</form>
					</div>
				</div>
			</div>
			<div class="span7 pull-right">
				<div class="row-fluid">
					<div class="span12">
						<div id="tabel_awal">
							<fieldset>
								<legend class="span12">Data Sparepart</legend>
								<table class="table table-striped">
									<thead>
										<tr class="head3">
											<td>No.</td>
											<td>Nama Sparepart</td>
											<td>Harga</td>
											<td>Masa Ganti (Hari)</td>
											<td></td>
										</tr>
									</thead>
									<tbody>
									<?php
										$query = mysqli_query($conn, "SELECT * FROM bengkel");
										$no = 1;
										while ($r = mysqli_fetch_array($query)) {
									?>
										<tr>
											<td><?php echo $no.".";?></td>
											<td>
											<?php echo $r['nama_bkl']."<td></td><td></td><td></td><br>"; ?>
												<tr>
												<?php
													$id_bkl = $r['id_bkl'];
													$sprt = mysqli_query($conn, "SELECT * FROM sparepart WHERE sparepart.id_bkl='$id_bkl'");
													while ($sp = mysqli_fetch_array($sprt)) { ?>
													<td></td>
													<td>--> <?php echo $sp['nama_sprt']?></td>
													<td><?php echo format_rupiah($sp['harga_sprt']); ?></td>
													<td><?php echo $sp['masa_ganti'] ?></td>
													<?php if ($akses == 3) { ?>
													<td>
														<div class="btn-group">
															<a class="btn btn-danger" href="#"><i class="icon-wrench icon-white"></i> Actions</a>
															<a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
															<ul class="dropdown-menu">
																<li><a href="media.php?module=data_sparepart&&act=edit&&id_sprt=<?php echo sha1($sp['id_sprt']);?>"><i class="icon-pencil"></i> Edit</a></li>
																<li><a href="<?php echo "$aksi?module=hapus&&id_sprt=$sp[id_sprt]";?>" onclick="return confirm('Apakah anda yakin, ingin menghapus data sparepart <?php echo $sp['nama_sprt'];?> dari bengkel <?php echo $r['nama_bkl'] ?>?')"><i class="icon-trash"></i> Delete</a></li>
															</ul>
														</div>
													</td>
													<?php } ?>
												</tr>
											<?php } ?>
											</td>
										</tr>
									<?php $no++;
										}
									?>
									</tbody>
								</table>
							</fieldset>
						</div>
					</div>
				</div>
			</div>
		</section>
<?php break;
	}
?>