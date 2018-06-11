<?php
	include ("../config/koneksi.php");

	$q = $_POST['q'];
	$query = mysqli_query($conn, "SELECT * FROM pegawai, direktorat WHERE pegawai.id_dir=direktorat.id_dir AND nama_peg LIKE '%".$q."%'");
	$num = mysqli_num_rows($query);
	$r = mysqli_fetch_array($query);
	$aksi = "mod_pegawai/aksi_pegawai.php";

	if ($num >= 1) {
?>
	<div class="control-group">
		<label class="control-label" for="inputPassword">NIP</label>
		<div class="controls">
			<input class="span11" type="hidden" id="inputText" name="id_peg" value="<?php echo $r['id_peg'];?>"></input>
			<input class="span11" type="text" id="inputText" value="<?php echo $r['NIP'];?>" disabled></input>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputPassword">Nama Pegawai</label>
		<div class="controls">
			<input class="span12" type="text" id="inputText" value="<?php echo $r['nama_peg'];?>" disabled></input>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputPassword">Direktorat</label>
		<div class="controls">
			<input class="span12" type="hidden" id="inputText" value="<?php echo $r['id_dir'];?>" name="id_dir"></input>
			<input class="span12" type="text" id="inputText" value="<?php echo $r['deskripsi'];?>" disabled></input>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputPassword">Tanggal Lahir</label>
		<div class="controls">
			<input class="span12" type="text" id="inputText" value="<?php echo $r['tgl_lhr'];?>" disabled></input>
		</div>
	</div>
<?php
	} else {
		echo "Data tidak ditemukan !!";
	}
?>