<?php
	switch ($_GET['act']) {
		default:
?>
		<script type="text/javascript">
			$(document).ready(function(){
				<!-- event textbox keyup
				$("#txtcari").keyup(function(){
					var strcari = $("#txtcari").val();
					var akses = $("#akses").val();
					if (strcari != "") {
						$("#tabel_awal").css("display","none");
						$("#hasil").html("<img src='assets/images/loader.gif'/>")
						$.ajax({
							type: "POST",
							url : "mod_statistik/cari.php",
							data: "q="+strcari+"&akses="+akses,
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

				$("#yearmonth").change(function(){
					var yearmonth = $("#yearmonth").val();
					if (yearmonth != "") {
						$("#tabel_awal").css("display","none");
						$("#hasil").html("<img src='assets/images/loader.gif'/>")
						$.ajax({
							type: "POST",
							url : "mod_statistik/cari_bulan.php",
							data: "r="+yearmonth,
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
			<input type="hidden" value="<?php echo $_SESSION['akses'] ?>" id="akses">
			<ul class="breadcrumb" style="margin-bottom:5px;">
				<li class="active">Data Statistik</li>
			</ul>
			<!--
			<div class="control-group pull-left">
				<div class="info_akses"><h4 class="info_akses"><i class="icon-plus icon-calendar"></i> Bulan : <?php echo tgl_indo(date("M")); ?></h4></div>
			</div>-->

			<form class="form-search pull-left">
				<div class="input-prepend">
					<span class="add-on"><i class="icon-calendar"></i></span>
					<select class="span3" id="yearmonth" name="yearmonth" required>
						<option value="<?php echo date('Y-m')?>" selected><?php echo date("M-Y")?></option>
					<?php
						$intmonth = array("01","02","03","04","05","06","07","08","09","10","11","12");
						$monthname = array("Jan","Feb","Mar","Apr","Mei","Jun","Jul","Aug","Sep","Okt","Nop","Des");
						$year = date('Y');
						for ($i=0; $i<12; $i++) {
						echo "<option value='$year-$intmonth[$i]'>$monthname[$i]-$year</option>";
						}
					?>
					</select>
				</div>
			</form>

			<form class="form-search pull-right">
				<div class="input-prepend">
					<span class="add-on"><i class="icon-search"></i></span>
					<input class="span3" id="txtcari" type="text" placeholder="Search ..."></input>
				</div>
			</form>
			<hr>
			<div class="row-fluid">
				<div class="span12 pull-left">
					<div id="hasil"></div>
					<div id="tabel_awal">
						<table class="table table-striped">
							<thead>
								<tr class="head3">
									<td>No.</td>
									<td>Plat No</td>
									<td>Owner</td>
									<td>Jarak Tempuh</td>
									<td>Konsumsi BBM</td>
									<td>Rasio BBM <sup>(km / litter)</sup></td>
									<td>Biaya BBM</td>
									<td>Biaya Service</td>
									<td>Biaya Sparepart</td>
								</tr>
							</thead>
							<tbody>
							<?php
								$yearmonth = date("Y-m");
								$datetime1 = $yearmonth."-01 00:00:00";
								$datetime2 = $yearmonth."-31 23:59:59";
								$query = mysqli_query($conn, "SELECT * FROM mobil, pegawai WHERE mobil.id_peg=pegawai.id_peg ORDER BY id_mobil DESC LIMIT $posisi, $batas");
								$no = $posisi+1;
								while ($mbl = mysqli_fetch_array($query)) {
							?>
								<tr>
									<?php
										$query1 = mysqli_query($conn, "SELECT SUM(jarak_tempuh) AS  jar_temp, SUM(solar_1) AS solar_1, SUM(solar_2) AS solar_2, SUM(solar_3) AS solar_3, SUM(harga_solar1) AS harga_solar1, SUM(harga_solar2) AS harga_solar2, SUM(harga_solar3) AS harga_solar3 FROM kilometer WHERE id_mobil = '$mbl[id_mobil]' AND jam_brkt BETWEEN '".$datetime1."' AND '".$datetime2."'");
										$km = mysqli_fetch_array($query1);

										$query4 = mysqli_query($conn, "SELECT SUM(bensin) AS total_bensin, SUM(harga) AS total_harga FROM bensin WHERE id_mobil = '$mbl[id_mobil]' AND tgl_isi BETWEEN '".$datetime1."' AND '".$datetime2."'");
										$bns = mysqli_fetch_array($query4);

										if ($mbl['type_code'] == 1) :
											$total_bbm = $km['solar_1']+$km['solar_2']+$km['solar_3'];
										elseif ($mbl['type_code'] == 2) : 
											$total_bbm = $bns['total_bensin'];
										endif;
										
										if ($mbl['type_code'] == 1 && $total_bbm != 0) :
											$rasio_bbm = $km['jar_temp']/$total_bbm;
										elseif ($mbl['type_code'] == 2) :
											$rasio_bbm = 0;
										endif;

										if ($mbl['type_code'] == 1) :
											$total_harga = $km['harga_solar1']+$km['harga_solar2']+$km['harga_solar3'];
										elseif ($mbl['type_code'] == 2) :
											$total_harga = $bns['total_harga'];
										endif;

										$query2 = mysqli_query($conn, "SELECT SUM(cost_est) AS biaya FROM service WHERE id_mobil = '$mbl[id_mobil]' AND app2_date BETWEEN '".$datetime1."' AND '".$datetime2."'");
										$svc = mysqli_fetch_array($query2);

										$query3 = mysqli_query($conn, "SELECT SUM(cost_est) AS biaya FROM ganti_sparepart WHERE id_mobil = '$mbl[id_mobil]' AND app2_date BETWEEN '".$datetime1."' AND '".$datetime2."'");
										$spr = mysqli_fetch_array($query3);
									?>
									<td><?php echo $no.".";?></td>
									<td><?php echo $mbl['plat_no'];?></td>
									<td><?php echo $mbl['nama_peg'];?></td>									
									<td><?php echo format_ribuan($km['jar_temp'])." Km";?></td>
									<td><?php echo format_ribuan2($total_bbm)." Lt";?></td>
									<td><?php echo format_ribuan2($rasio_bbm)." Km/Lt";?></td>
									<td><?php echo format_rupiah($total_harga);?></td>
									<td><?php echo format_rupiah($svc['biaya']);?></td>
									<td><?php echo format_rupiah($spr['biaya']);?></td>
								</tr>
							<?php $no++;
								}
							?>
								<tr>
									<?php
										$query1 = mysqli_query($conn, "SELECT SUM(harga_solar1) AS harga_solar1, SUM(harga_solar2) AS harga_solar2, SUM(harga_solar3) AS harga_solar3, sum(jarak_tempuh) AS jarak_tempuh, sum(solar_1) AS solar_1, sum(solar_2) AS solar_2, sum(solar_3) AS solar_3 FROM kilometer WHERE jam_brkt BETWEEN '".$datetime1."' AND '".$datetime2."'");
										$km = mysqli_fetch_array($query1);

										$query2 = mysqli_query($conn, "SELECT SUM(cost_est) AS biaya FROM service WHERE app2_date BETWEEN '".$datetime1."' AND '".$datetime2."'");
										$svc = mysqli_fetch_array($query2);

										$query3 = mysqli_query($conn, "SELECT SUM(cost_est) AS biaya FROM ganti_sparepart WHERE app2_date BETWEEN '".$datetime1."' AND '".$datetime2."'");
										$spr = mysqli_fetch_array($query3);

										$query4 = mysqli_query($conn, "SELECT SUM(harga) AS total_harga, sum(bensin) AS total_bensin FROM bensin WHERE tgl_isi BETWEEN '".$datetime1."' AND '".$datetime2."'");
										$bns = mysqli_fetch_array($query4);

										$total_jartemp = $km['jarak_tempuh'];
										$total_solar = $km['solar_1']+$km['solar_2']+$km['solar_3']+$bns['total_bensin'];
										$total_harga = $km['harga_solar1']+$km['harga_solar2']+$km['harga_solar3']+$bns['total_harga'];
									?>
									<td colspan="3">Total</td>
									<td><?php echo format_ribuan($total_jartemp)." Km"?></td>
									<td><?php echo format_ribuan2($total_solar)." Lt"?></td>
									<td></td>
									<td><?php echo format_rupiah($total_harga)?></td>
									<td><?php echo format_rupiah($svc['biaya'])?></td>
									<td><?php echo format_rupiah($spr['biaya'])?></td>
								</tr>
								<tr>
									<td colspan="8">
									<?php
										$jmldata = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM mobil"));
										$jmlhalaman = $p->jumlahHalaman($jmldata,$batas);
										$linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
										echo "$linkHalaman";
									?>
										<td>Jumlah Record <?php echo $jmldata;?></td>
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
	}
?>