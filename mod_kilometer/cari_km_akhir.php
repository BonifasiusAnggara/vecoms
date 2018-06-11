<?php
	include ("../config/koneksi.php");

	$id_mobil = $_POST['q'];
	$query = mysqli_query($conn, "SELECT max(km_plg) AS km_akhir FROM kilometer WHERE id_mobil='$id_mobil'");
	$row = mysqli_fetch_array($query);
	
?>
<div class="control-group">
	<label class="control-label" for="inputPassword">KM Sebelumnya</label>
	<div class="controls">
		<input class="span6" type="text" id="inputText" value="<?php echo $row['km_akhir']; ?>" disabled></input>
		<input class="span6" type="hidden" id="inputText" name="km_akhir" value="<?php echo $row['km_akhir']; ?>"></input>	
	</div>
</div>