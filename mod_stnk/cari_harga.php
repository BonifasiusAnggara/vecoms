<?php
	include ("../config/koneksi.php");
	include ("../config/fungsi_rupiah.php");
	$id_serv = $_POST['q'];
	$query = mysqli_query($conn, "SELECT * FROM kat_service WHERE id_serv='$id_serv'");
	$kat = mysqli_fetch_array($query);
?>
<div class="control-group">
	<label class="control-label" for="inputPassword">Harga</label>
	<div class="controls">
		<input class="span6" type="text" id="inputText" value="<?php echo $kat['nama_serv']; ?>" disabled></input>
		<input class="span6" type="text" id="inputText" value="<?php echo format_rupiah($kat['harga_serv']); ?>" disabled></input>
		<input class="span6" type="hidden" name="nama_serv" id="inputText" value="<?php echo $kat['nama_serv']; ?>"></input>
		<input class="span6" type="hidden" name="harga_serv" id="inputText" value="<?php echo $kat['harga_serv']; ?>"></input>		
	</div>
</div>