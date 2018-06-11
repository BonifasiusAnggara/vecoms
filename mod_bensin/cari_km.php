<?php
	include ("../config/koneksi.php");

	$id_mobil = $_POST['q'];
	$query = mysqli_query($conn, "SELECT max(km_bensin) AS km_awal, id_bensin FROM bensin WHERE id_mobil='$id_mobil'");
	$row = mysqli_fetch_array($query);
	$query2 = mysqli_query($conn, "SELECT id_bensin FROM bensin WHERE km_bensin = '$row[km_awal]'");
	$r = mysqli_fetch_array($query2);
?>
<div class="control-group">
	<label class="control-label" for="inputPassword">KM Sebelumnya</label>
	<div class="controls">
		<input class="span6" type="text" id="inputText" value="<?php echo $row['km_awal']; ?>" disabled></input>
		<input class="span6" type="hidden" name="km_awal" id="inputText" value="<?php echo $row['km_awal']; ?>"></input>
		<input class="span6" type="hidden" id="inputText" name="id_rasio" value="<?php echo $r['id_bensin']; ?>"></input>
	</div>
</div>