<?php
	if ($_GET['module'] == 'home') {
		echo "VeCoMS | Home";
	} elseif ($_GET['module'] == 'data_user') {
		echo "VeCoMS | Data User";
	}  elseif ($_GET['module'] == 'data_pegawai') {
		echo "VeCoMS | Data Pegawai";
	} elseif ($_GET['module'] == 'data_mobil') {
		echo "VeCoMS | Data Mobil";
	} elseif ($_GET['module'] == 'data_bengkel') {
		echo "VeCoMS | Data Bengkel";
	} elseif ($_GET['module'] == 'data_sparepart') {
		echo "VeCoMS | Data Sparepart";
	} elseif ($_GET['module'] == 'service'){
		echo "VeCoMS | Kategori Servis";
	} elseif ($_GET['module'] == 'kilometer'){
		echo "VeCoMS | Data Kilometer";
	} elseif ($_GET['module'] == 'bensin'){
		echo "VeCoMS | Pembelian Bensin";
	} elseif ($_GET['module'] == 'service_mobil'){
		echo "VeCoMS | Servis Mobil";
	} elseif ($_GET['module'] == 'ganti_sparepart'){
		echo "VeCoMS | Ganti Sparepart";
	} elseif ($_GET['module'] == 'statistik'){
		echo "VeCoMS | Statistik";
	} else {
        echo "VeCoMS | Rekam Servis";
    }