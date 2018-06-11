<?php
	include ("../config/koneksi.php");

	$id_serv = $_POST['q'];
	$id_mobil = $_POST['r'];
	$query = mysqli_query($conn, "SELECT * FROM kat_service WHERE id_serv='$id_serv'");
	$kat = mysqli_fetch_array($query);
	$nama_serv = $kat['nama_serv'];
	$query2 = mysqli_query($conn, "SELECT max(km) AS km_awal FROM detail_service WHERE id_mobil='$id_mobil' AND nama_serv='$nama_serv'");
	$row = mysqli_fetch_array($query2);
?>
<div class="control-group">
	<label class="control-label" for="inputPassword">KM AWAL</label>
	<div class="controls">
		<input class="span6" type="text" id="inputText" value="<?php echo $row['km_awal']; ?>" disabled></input>
		<input class="span6" type="hidden" name="km_awal" id="inputText" value="<?php echo $row['km_awal']; ?>"></input>
	</div>
	<label class="control-label" for="inputPassword">Masa Service</label>
	<div class="controls">
		<input class="span6" type="text" id="inputText" value="<?php echo $kat['masa_serv']; ?>" disabled></input>
		<input class="span6" type="hidden" name="masa_serv" id="inputText" value="<?php echo $kat['masa_serv']; ?>"></input>
	</div>
</div>