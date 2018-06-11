<?php
	//Class Paging untuk halaman administrator
	class Paging {
		//Fungsi untuk mencek halaman dan posisi data
		function cariPosisi($batas) {
			if (empty($_GET['halaman'])) {
				$posisi = 0;
				$_GET['halaman'] = 1;
			} else {
				$posisi = ($_GET['halaman']-1) * $batas;
			}
			return $posisi;
		}

		//Fungsi untuk menghitung jumlah halaman
		function jumlahHalaman($jmldata,$batas) {
			$jmlhalaman = ceil($jmldata/$batas);
			return $jmlhalaman;
		}

		//Fungsi untuk link halaman 1,2,3 (untuk admin)
		function navHalaman($halamanaktif,$jmlhalaman) {
			$linkhalaman = "";

			echo "<div class='pagination'>
				  	<ul>";
				  		//Link ke halaman pertama (first) dan sebelumnya (prev)
					  	if ($halamanaktif > 1) {
					  		$prev = $halamanaktif-1;
					  		$linkhalaman .= "<li><a href='$_SERVER[PHP_SELF]?module=$_GET[module]&halaman=1'>First</a></li>
					  		 				 <li><a href='$_SERVER[PHP_SELF]?module=$_GET[module]&halaman=$prev'>Prev</a></li>";
					  	} else {
					  		$linkhalaman .= "<li class='disabled'><a href='#'>First</a></li>
					  		 				 <li class='disabled'><a href='#'>Prev</a></li>";
					  	}

					  	//Link halaman 1,2,3, ...
					  	$angka = ($halamanaktif > 3 ? " ... " : " ");

					  		//Blok pendeklarasian $angka
						  	for ($i = $halamanaktif-2; $i < $halamanaktif; $i++) {
						  		if ($i < 1)
						  			continue;
						  			$angka .= "<li><a href='$_SERVER[PHP_SELF]?module=$_GET[module]&halaman=$i'>$i</a></li>";
						  	}
							  		$angka .= "<li class='disabled'><a href='#'>$halamanaktif</a></li>";

					  		for ($i = $halamanaktif+1; $i < ($halamanaktif+3); $i++) {
					  			if ($i > $jmlhalaman)
					  				break;
					  				$angka .= "<li><a href='$_SERVER[PHP_SELF]?module=$_GET[module]&halaman=$i'>$i</a></li>";
					  		}
			  						$angka .= ($halamanaktif+2 < $jmlhalaman ? "<li><a href='$_SERVER[PHP_SELF]?module=$_GET[module]&halaman=$jmlhalaman'>$jmlhalaman</a></li>" : " ");
				  			//End of block $angka

				  		$linkhalaman .= "$angka"; //$angka menjadi isian nilai bagi $linkhalaman

				  		//Link ke halaman berikutnya (next) dan terakhir (last)
				  		if ($halamanaktif < $jmlhalaman) {
				  			$next .= $halamanaktif+1;
				  			$linkhalaman .= "<li><a href='$_SERVER[PHP_SELF]?module=$_GET[module]&halaman=$next'>Next</a></li>
				  							 <li><a href='$_SERVER[PHP_SELF]?module=$_GET[module]&halaman=$jmlhalaman'>Last<a/></li>";

				  		} else {
				  			$linkhalaman .= "<li class='disabled'><a href='#'>Next</a></li>
				  							 <li class='disabled'><a href='#'>Last</a></li>
				  	</ul>
				  </div>";
				  		}

			return $linkhalaman;
		}

		//Fungsi untuk link halaman 1,2,3 (untuk admin)
		function navHalamanact($halamanaktif,$jmlhalaman) {
			$linkhalaman = "";

			echo "<div class='pagination'>
				  	<ul>";
				  		//Link ke halaman pertama (first) dan sebelumnya (prev)
					  	if ($halamanaktif > 1) {
					  		$prev = $halamanaktif-1;
					  		$linkhalaman .= "<li><a href='$_SERVER[PHP_SELF]?module=$_GET[module]&act=$_GET[act]&id_mobil=$_GET[id_mobil]&halaman=1'>First</a></li>
					  		 				 <li><a href='$_SERVER[PHP_SELF]?module=$_GET[module]&act=$_GET[act]&id_mobil=$_GET[id_mobil]&halaman=$prev'>Prev</a></li>";
					  	} else {
					  		$linkhalaman .= "<li class='disabled'><a href='#'>First</a></li>
					  		 				 <li class='disabled'><a href='#'>Prev</a></li>";
					  	}

					  	//Link halaman 1,2,3, ...
					  	$angka = ($halamanaktif > 3 ? " ... " : " ");

					  		//Blok pendeklarasian $angka
						  	for ($i = $halamanaktif-2; $i < $halamanaktif; $i++) {
						  		if ($i < 1)
						  			continue;
						  			$angka .= "<li><a href='$_SERVER[PHP_SELF]?module=$_GET[module]&act=$_GET[act]&id_mobil=$_GET[id_mobil]&halaman=$i'>$i</a></li>";
						  	}
							  		$angka .= "<li class='disabled'><a href='#'>$halamanaktif</a></li>";

					  		for ($i = $halamanaktif+1; $i < ($halamanaktif+3); $i++) {
					  			if ($i > $jmlhalaman)
					  				break;
					  				$angka .= "<li><a href='$_SERVER[PHP_SELF]?module=$_GET[module]&act=$_GET[act]&id_mobil=$_GET[id_mobil]&halaman=$i'>$i</a></li>";
					  		}
			  						$angka .= ($halamanaktif+2 < $jmlhalaman ? "<li><a href='$_SERVER[PHP_SELF]?module=$_GET[module]&act=$_GET[act]&id_mobil=$_GET[id_mobil]&halaman=$jmlhalaman'>$jmlhalaman</a></li>" : " ");
				  			//End of block $angka

				  		$linkhalaman .= "$angka"; //$angka menjadi isian nilai bagi $linkhalaman

				  		//Link ke halaman berikutnya (next) dan terakhir (last)
				  		if ($halamanaktif < $jmlhalaman) {
				  			$next .= $halamanaktif+1;
				  			$linkhalaman .= "<li><a href='$_SERVER[PHP_SELF]?module=$_GET[module]&act=$_GET[act]&id_mobil=$_GET[id_mobil]&halaman=$next'>Next</a></li>
				  							 <li><a href='$_SERVER[PHP_SELF]?module=$_GET[module]&act=$_GET[act]&id_mobil=$_GET[id_mobil]&halaman=$jmlhalaman'>Last<a/></li>";

				  		} else {
				  			$linkhalaman .= "<li class='disabled'><a href='#'>Next</a></li>
				  							 <li class='disabled'><a href='#'>Last</a></li>
				  	</ul>
				  </div>";
				  		}

			return $linkhalaman;
		}
	}