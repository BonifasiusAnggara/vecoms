<?php
	include ("../config/koneksi.php");

	$id_sprt = $_POST['q'];
	$id_mobil = $_POST['r'];
	$query = mysqli_query($conn, "SELECT * FROM sparepart WHERE id_sprt='$id_sprt'");
	$spr = mysqli_fetch_array($query);
	$nama_sprt = $spr['nama_sprt'];

	$query = mysqli_query($conn, "SELECT max(tgl_ganti) AS tgl_ganti FROM detail_gs WHERE id_mobil='$id_mobil' AND nama_sprt='$nama_sprt'");
	$row = mysqli_fetch_array($query);
?>
<div class="control-group">
	<label class="control-label" for="inputPassword">Tgl Terakhir Ganti Sparepart</label>
	<div class="controls">
		<input class="span7" type="text" id="inputText" value="<?php echo $row['tgl_ganti']; ?>" disabled></input>
		<input class="span7" type="hidden" name="tgl_awal" id="inputText" value="<?php echo $row['tgl_ganti']; ?>"></input>
	</div>
	<label class="control-label" for="inputPassword">Masa Ganti</label>
	<div class="controls">
		<input class="span7" type="text" id="inputText" value="<?php echo $spr['masa_ganti']; ?>" disabled></input>
		<input class="span7" type="hidden" name="masa_ganti" id="inputText" value="<?php echo $spr['masa_ganti']; ?>"></input>
	</div>
</div>