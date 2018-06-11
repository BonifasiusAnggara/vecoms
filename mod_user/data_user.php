<?php
	$aksi = "mod_user/aksi_datauser.php";
	switch($_GET['act']) {
		default:
?>
		<script type="text/javascript">
			$(document).ready(function(){
				<!-- event textbox keyup
				$("#txtcari").keyup(function(){
					var strcari = $("#txtcari").val();
					if (strcari != "") {
						$("#tabel_awal").css("display","none");
						$("#hasil").html("<img src='assets/images/loader.gif'/>")
						$.ajax({
							type: "POST",
							url : "mod_user/cari.php",
							data: "q="+strcari,
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
			<ul class="breadcrumb" style="margin-bottom:5px;">
				<li class="active">Data User</li>
			</ul>
			<div class="control-group pull-left">
				<button class="btn btn-info" type="button" onclick="window.location='media.php?module=data_user&&act=tambah'"><i class="icon-plus icon-white"></i> Tambah User</button>
			</div>
			<form class="form-search pull-right">
				<div class="input-prepend">
					<span class="add-on"><i class="icon-search"></i></span>
					<input class="span3" id="txtcari" type="text" placeholder="Search"></input>
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
									<td>Kode User</td>
									<td>Nama Lengkap</td>
									<td>Jenis Kelamin</td>
									<td>Alamat</td>
									<td>No Handphone</td>
									<td>Tanggal Lahir</td>
									<td>Level Akses</td>
									<td></td>
								</tr>
							</thead>
							<tbody>
							<?php
								$query = mysqli_query($conn, "SELECT * FROM user_man ORDER BY first_name ASC LIMIT $posisi, $batas");
								$no = $posisi+1;
								while ($r = mysqli_fetch_array($query)) {
							?>
								<tr>
									<td><?php echo $no;?></td>
									<td><?php echo $r['kodeUser'];?></td>
									<td><?php echo $r['first_name']." ".$r['last_name'];?></td>
									<td><?php echo $r['jk'];?></td>
									<td><?php echo $r['alamat'];?></td>
									<td><?php echo $r['no_hp'];?></td>
									<td><?php echo tgl_indo($r['tgl_lahir']);?></td>
									<td>
									<?php
										if ($r['akses'] == '3') {
											echo "Superadmin";
										} else {
											echo "Admin";
										}
									?>
									</td>
									<td>
										<div class="btn-group">
											<a class="btn btn-info" href="#"><i class="icon-wrench icon-white"></i> Actions</a>
											<a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
											<ul class="dropdown-menu">
												<li><a href="media.php?module=data_user&&act=edit&&kodeuser=<?php echo sha1($r['kodeUser']);?>"><i class="icon-pencil"></i> Edit</a></li>
												<li><a href="<?php echo "$aksi?module=hapus&&iduser=$r[id_user]";?>" onclick="return confirm ('Apakah anda yakin, ingin menghapus data <?php echo $r['first_name'];?> ?')"><i class="icon-trash"></i> Delete</a></li>
											</ul>
										</div>
									</td>
								</tr>
							<?php $no++;
								}
							?>
								<tr>
									<td colspan="8">
									<?php
										$jmldata = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user_man"));
										$jmlhalaman = $p->jumlahHalaman($jmldata,$batas);
										$linkHalaman = $p->navHalaman($_GET['halaman'],$jmlhalaman);
										echo "$linkHalaman";
									?><td>Jumlah Record <?php echo $jmldata?></td>
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
				$pos = rand(0,strlen($karakter)-1);
				$string .= $karakter{$pos};
			}
			return $string;
		}

		$acak2 = acakangkahuruf(3);
		$nounik = "US-".$acak1.$acak2;
?>
		<section>
			<ul class="breadcrumb" style="margin-bottom:5px;">
				<li><a href="media.php?module=data_user">Data User</a> <span class="divider"><b>&gt;</b></span></li>
				<li class="active">Tambah User</li>
			</ul>

			<div class="row-fluid">
				<div class="span12 pull-left">
					<form method="post" enctype="multipart/form-data" action="<?php echo "$aksi?module=tambah";?>">
						<fieldset>
							<legend class="span7 offset1">Tambah User</legend>
							<div class="clear"></div>
							<div class="span3 offset1">
								<div class="control-group">
									<label class="control-label" for="inputPassword">Nama Depan</label>
									<div class="controls">
										<input class="span10" type="text" id="inputText" name="t2" required></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Jenis Kelamin</label>
									<label class="radio">
										<input type="radio" name="t4" id="optionRadios1" value="L" required> Laki-laki
									</label>
									<label class="radio">
										<input type="radio" name="t4" id="optionRadios1" value="P" required> Perempuan
									</label>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Tanggal Lahir</label>
									<div class="controls">
										<input class="span12" type="date" id="tgl1" name="t7" required></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">No Handphone</label>
									<div class="controls">
										<input type="number" id="inputText" name="t6" required></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Alamat</label>
									<div class="controls">
										<textarea name="t5" required></textarea>
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
							<div class="span3">
								<div class="control-group">
									<label class="control-label" for="inputPassword">Nama Belakang</label>
									<div class="controls">
										<input class="span12" type="text" id="inputText" name="t3" required></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Kode User</label>
									<div class="controls">
										<input class="span6" type="text" id="inputText" value="<?php echo $nounik;?>" disabled></input>
										<input class="span6" type="hidden" id="inputText" value="<?php echo $nounik;?>" name="t1"></input>
									</div>
								</div>
								<hr>
								<div class="span12" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
									<ul class="pop pull-right">
										<li><a href="#" class="btn" data-toggle="popover" data-placement="right" data-content="Username &amp; Password Tidak Boleh Kosong." title="Question"><i class="icon-question-sign"></i></a></li>
									</ul>
									<div class="control-group">
										<label class="control-label" for="inputPassword">Username</label>
										<div class="controls">
											<input class="span12" type="text" id="inputText" name="t8" required></input>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="inputPassword">Password</label>
										<div class="controls">
											<input class="span12" type="password" id="inputText" name="t9" required></input>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="inputPassword">Email</label>
										<div class="controls">
											<input class="span12" type="text" id="inputText" name="t10" required></input>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="inputPassword">Level</label>
										<div class="controls">
											<select name="level">
												<option selected disabled>Plih Level: </option>
												<option value="3">Superadmin</option>
												<option value="2">Admin</option>
												<option value="5">Validator</option>
												<option value="4">Security</option>
											</select>
										</div>
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
			});
		</script>
<?php 	break;
		case "edit":
		$kodeuser = $_GET['kodeuser'];
		$query = mysqli_query($conn, "SELECT * FROM user_man WHERE sha1(kodeUser)='$kodeuser'");
		$r = mysqli_fetch_array($query);
?>
		<section>
			<ul class="breadcrumb" style="margin-bottom:5px;">
				<li><a href="media.php?module=data_user">Data User</a> <span class="divider"><b>&gt;</b></span></li>
				<li class="active">Update User</li>
			</ul>

			<div class="row-fluid">
				<div class="span12 pull-left">
					<form method="post" enctype="multipart/form-data" action="<?php echo "$aksi?module=edit";?>">
						<fieldset>
							<legend class="span7 offset1">Update User</legend>
							<div class="clear"></div>
							<div class="span3 offset1">
								<div class="control-group">
									<label class="control-label" for="inputPassword">Nama Depan</label>
									<div class="controls">
										<input class="span10" type="text" id="inputText" name="t2" value="<?php echo $r['first_name'];?>" required></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Jenis Kelamin</label>
								<?php
									$jk = $r['jk'];
									if ($jk == 'L') {
								?>
									<label class="radio">
										<input type="radio" name="t4" id="optionRadios1" value="L" checked> Laki-laki
									</label>
									<label class="radio">
										<input type="radio" name="t4" id="optionRadios1" value="P"> Perempuan
									</label>
								<?php
									} else {
								?>
									<label class="radio">
										<input type="radio" name="t4" id="optionRadios1" value="L"> Laki-laki
									</label>
									<label class="radio">
										<input type="radio" name="t4" id="optionRadios1" value="P" checked> Perempuan
									</label>
								<?php
									}
								?>									
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Tanggal Lahir</label>
									<div class="controls">
										<input class="span12" type="date" id="inputText" name="t7" value="<?php echo $r['tgl_lahir'];?>" required></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">No Handphone</label>
									<div class="controls">
										<input type="number" id="inputText" name="t6" value="<?php echo $r['no_hp'];?>" required></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Alamat</label>
									<div class="controls">
										<textarea name="t5" required><?php echo $r['alamat'];?></textarea>
									</div>
								</div>
							<?php
								$foto = $r['photo'];
								if (isset($foto)) {
									echo "<img src='photo_user/$foto' style='width:150px; height:170px;'>";
								}
							?>
								<div class="control-group">
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
							<div class="span3">
								<div class="control-group">
									<label class="control-label" for="inputPassword">Nama Belakang</label>
									<div class="controls">
										<input class="span12" type="text" id="inputText" name="t3" value="<?php echo $r['last_name'];?>" required></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Kode User</label>
									<div class="controls">
										<input class="span6" type="text" id="inputText" value="<?php echo $r['kodeUser'];?>" disabled></input>
										<input class="span12" type="hidden" id="inputText" name="t1" value="<?php echo $r['kodeUser'];?>"></input>
									</div>
								</div>
								<hr>
								<div class="span12" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
									<ul class="pop pull-right">
										<li><a href="#" class="btn" data-toggle="popover" data-placement="right" data-content="Username &amp; Password Tidak Boleh Kosong." title="Question"><i class="icon-question-sign"></i></a></li>
									</ul>
									<div class="control-group">
										<label class="control-label" for="inputPassword">Username</label>
										<div class="controls">
											<input class="span12" type="text" id="inputText" name="t8" value="<?php echo $r['username'];?>" required></input>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="inputPassword">Password</label>
										<div class="controls">
											<input class="span12" type="text" id="inputText" name="t9" required></input>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="inputPassword">Email</label>
										<div class="controls">
											<input class="span12" type="text" id="inputText" name="t10" value="<?php echo $r['email'];?>" required></input>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="inputPassword">Level</label>
										<div class="controls">
											<select name="level">
												<option selected value="<?php echo $r['akses'] ?>">Plih Level: </option>
												<option value="3">Superadmin</option>
												<option value="2">Admin</option>
												<option value="5">Validator</option>
												<option value="4">Security</option>
											</select>
										</div>
									</div>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</section>
<?php break;
	}
?>