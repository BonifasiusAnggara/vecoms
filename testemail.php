<?php								
	$query1 = mysqli_query($conn, "SELECT *, TIMESTAMPDIFF(DAY, CURRENT_DATE, ms_ber_stnk) AS stnk, TIMESTAMPDIFF(DAY, CURRENT_DATE, ms_ber_keur) AS keur FROM mobil, pegawai WHERE mobil.id_peg=pegawai.id_peg");

	while ($row = mysqli_fetch_array($query1)) {
		if ($row['stnk'] < 30 && $row['stnk'] > 0) {
			require_once("stnk.php");
									
		}
		if ($row['keur'] < 30 && $row['keur'] > 0) {
			
			require_once("keur.php");
		}
	}
?>