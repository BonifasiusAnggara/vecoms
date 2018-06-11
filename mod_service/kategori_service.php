<?php
	$aksi = "mod_service/aksi_service.php";
	switch ($_GET['act']) {
		default:

		$p = new Paging;
		$batas = 10;
		$posisi = $p->cariPosisi;
?>
		<section>
			<ul class="breadcrumb" style="margin-bottom:5px;">
				<li class="active">Kategori Service</li>
			</ul>
			<div class="span5 pull-left" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
				<div class="row-fluid">
					<div class="span12">
						<form method="post" enctype="multipart/form-data" action="<?php echo "$aksi?module=tambah";?>">
							<legend class="span12">Tambah Kategori Service</legend>
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
									<label class="control-label" for="inputPassword">Nama Service</label>
									<div class="controls">
										<input class="span11" type="text" name="nama_serv" required></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Harga</label>
									<div class="controls">
										<input class="span11" type="text" name="harga_serv" required></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Masa Service</label>
									<div class="controls">
										<input class="span10" type="text" name="masa_serv" required></input>&nbsp; Km
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
								<legend class="span12">Kategori Service</legend>
								<table class="table table-striped">
									<thead>
										<tr class="head3">
											<td>No.</td>
											<td>Nama Bengkel</td>
											<td>Harga</td>
											<td>Masa Service (Km)</td>
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
													$srv = mysqli_query($conn, "SELECT * FROM kat_service, bengkel WHERE kat_service.id_bkl=bengkel.id_bkl AND kat_service.id_bkl='$id_bkl'");
													while ($sv = mysqli_fetch_array($srv)) { ?>
													<td></td>
													<td>--> <?php echo $sv['nama_serv']?></td>
													<td><?php echo format_rupiah($sv['harga_serv']); ?></td>
													<td><?php echo $sv['masa_serv'] ?></td>
													<?php if ($akses == 3) { ?>
													<td>
														<div class="btn-group">
															<a class="btn btn-danger" href="#"><i class="icon-wrench icon-white"></i> Actions</a>
															<a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
															<ul class="dropdown-menu">
																<li><a href="media.php?module=service&&act=edit&&id_serv=<?php echo sha1($sv['id_serv']);?>"><i class="icon-pencil"></i> Edit</a></li>
																<li><a href="<?php echo "$aksi?module=hapus&&id_serv=$sv[id_serv]";?>" onclick="return confirm('Apakah anda yakin, ingin menghapus tarif service <?php echo $sv['nama_serv'];?> dari bengkel <?php echo $r['nama_bkl'] ?>?')"><i class="icon-trash"></i> Delete</a></li>
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
		$id_serv = $_GET['id_serv'];
		$query = mysqli_query($conn, "SELECT * FROM kat_service, bengkel WHERE sha1(id_serv)='$id_serv' AND kat_service.id_bkl=bengkel.id_bkl");
		$r = mysqli_fetch_array($query);
?>
		<section>
			<ul class="breadcrumb" style="margin-bottom:5px;">
				<li><a href="media.php?module=service">Kategori Service</a> <span class="divider"><b>&gt;</b></span></li>
				<li class="active">Ubah Service</li>
			</ul>
			<div class="control-group pull-left"></div>
			<div class="span5 pull-left" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
				<div class="row-fluid">
					<div class="span12">
						<form method="post" enctype="multipart/form-data" action="<?php echo "$aksi?module=edit";?>">
							<legend class="span12">Ubah Kategori Service</legend>
							<div class="clear"></div>
							<div class="span8">
								<div class="control-group">
									<label class="control-label" for="inputPassword">Bengkel</label>
									<select name="id_bkl">
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
									<label class="control-label" for="inputPassword"> Nama Service</label>
									<div class="controls">
										<input class="span11" type="text" name="nama_serv" value="<?php echo $r['nama_serv'];?>"></input>
										<input class="span11" type="hidden" name="id_serv" value="<?php echo $r['id_serv'];?>"></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword"> Harga</label>
									<div class="controls">
										<input class="span11" type="text" name="harga_serv" value="<?php echo $r['harga_serv'];?>"></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Masa Service</label>
									<div class="controls">
										<input class="span10" type="text" name="masa_serv" value="<?php echo $r['masa_serv'];?>" required></input>&nbsp; Km
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
								<legend class="span12">Kategori Service</legend>
								<table class="table table-striped">
									<thead>
										<tr class="head3">
											<td>No.</td>
											<td>Nama Bengkel</td>
											<td>Harga</td>
											<td>Masa Service (Km)</td>
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
													$srv = mysqli_query($conn, "SELECT * FROM kat_service WHERE kat_service.id_bkl='$id_bkl'");
													while ($sv = mysqli_fetch_array($srv)) { ?>
													<td></td>
													<td>--> <?php echo $sv['nama_serv']?></td>
													<td><?php echo format_rupiah($sv['harga_serv']); ?></td>
													<td><?php echo $sv['masa_serv'] ?></td>
													<?php if ($akses == 3) { ?>
													<td>
														<div class="btn-group">
															<a class="btn btn-danger" href="#"><i class="icon-wrench icon-white"></i> Actions</a>
															<a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
															<ul class="dropdown-menu">
																<li><a href="media.php?module=service&&act=edit&&id_serv=<?php echo sha1($sv['id_serv']);?>"><i class="icon-pencil"></i> Edit</a></li>
																<li><a href="<?php echo "$aksi?module=hapus&&id_serv=$sv[id_serv]";?>" onclick="return confirm('Apakah anda yakin, ingin menghapus tarif service <?php echo $sv['nama_serv'];?> dari bengkel <?php echo $r['nama_bkl'] ?>?')"><i class="icon-trash"></i> Delete</a></li>
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