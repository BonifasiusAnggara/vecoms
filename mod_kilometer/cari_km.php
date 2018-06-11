<?php
	include ("../config/koneksi.php");

	$id_mobil = $_POST['q'];
	$query = mysqli_query($conn, "SELECT max(km_solar1) AS km_awal, id_km FROM kilometer WHERE id_mobil='$id_mobil'");
	$row = mysqli_fetch_array($query);
	$query2 = mysqli_query($conn, "SELECT * FROM kilometer WHERE km_solar1 = '$row[km_awal]'");
	$r = mysqli_fetch_array($query2);
	
	if ($r['km_solar3'] != 0) {
		$km_awal = $r['km_solar3'];
		$solarr = $r['solar_3'];
		$seri_km = "km_solar3";
	} else if (($r['km_solar2'] != 0) && ($r['km_solar3'] == 0)) {
		$km_awal = $r['km_solar2'];
		$solarr = $r['solar_2'];
		$seri_km = "km_solar2";
	} else if (($r['km_solar1'] != 0) && ($r['km_solar2'] == 0) && ($r['km_solar3'] == 0)) {
		$km_awal = $r['km_solar1'];
		$solarr = $r['solar_1'];
		$seri_km = "km_solar1";
	}
	
?>
<div class="control-group">
	<label class="control-label" for="inputPassword">KM Sebelumnya</label>
	<div class="controls">
		<input class="span6" type="text" id="inputText" value="<?php echo $km_awal; ?>" disabled></input>
		<input class="span6" type="hidden" id="inputText" name="id_rasio" value="<?php echo $r['id_km']; ?>"></input>
		<input class="span6" type="hidden" id="inputText" name="km_awal" value="<?php echo $km_awal; ?>"></input>
		<input class="span6" type="hidden" id="inputText" name="solarr" value="<?php echo $solarr; ?>" ></input>
		<input class="span6" type="hidden" id="inputText" name="seri_km" value="<?php echo $seri_km; ?>" ></input>
	</div>
</div>