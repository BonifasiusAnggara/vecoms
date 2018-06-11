<?php
	include ("../config/koneksi.php");
	include ("../config/fungsi_rupiah.php");
	$id = $_POST['q'];
	$query = mysqli_query($conn, "SELECT * FROM sparepart WHERE id_sprt='$id'");
	$spr = mysqli_fetch_array($query);	
?>
<div class="control-group">
	<label class="control-label" for="inputPassword">Harga</label>
	<div class="controls">
		<input class="span6" type="hidden" name="nama_sprt" id="inputText" value="<?php echo $spr['nama_sprt']; ?>"></input>
		<input class="span6" type="text" id="inputText" value="<?php echo format_rupiah($spr['harga_sprt']); ?>" disabled></input>
		<input class="span6" type="hidden" name="harga_sprt" id="inputText" value="<?php echo $spr['harga_sprt']; ?>"></input>		
	</div>
</div>

<?php if (($spr['nama_sprt'] == 'Ban') || ($spr['nama_sprt'] == 'Ban Truck')) { ?>
	<div class="control-group">
	<label class="control-label" for="inputPassword">Kode Ban</label>
	<div class="controls">
		<input class="span2" type="checkbox" id="inputText" name="kode_ban[]" value="A">A <sup>(Kiri Depan)</sup></input>
		<input class="span3" type="checkbox" id="inputText" name="kode_ban[]" value="B">B <sup>(Kanan Depan)</sup></input>
		<input class="span2" type="checkbox" id="inputText" name="kode_ban[]" value="C">C <sup>(Kiri Belakang)</sup></input>
		<input class="span2" type="checkbox" id="inputText" name="kode_ban[]" value="D">D <sup>(Kanan Belakang)</sup></input>
		<input class="span2" type="checkbox" id="inputText" name="kode_ban[]" value="E">E <sup>(Ban Cadangan)</sup></input>
	</div>
</div>
<?php } ?>