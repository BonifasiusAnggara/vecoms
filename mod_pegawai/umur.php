<?php
	$tgl = $_POST['q'];
	$ambil_thn = substr($tgl,0,4);
	$thn_sekarang = date('Y');
	$umur = $thn_sekarang-$ambil_thn;
?>
<div class="control-group">
	<label class="control-label" for="inputPassword">Umur</label>
	<div class="controls">
		<input class="span10" type="text" id="inputText" value="<?php echo $umur." Tahun"; ?>" disabled></input>
	</div>
</div>