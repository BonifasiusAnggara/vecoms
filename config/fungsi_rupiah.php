<?php
	function format_rupiah($angka) {
		$rupiah = "Rp. ".number_format($angka,0,',','.');
		return $rupiah;
	}

	function format_ribuan($angka) {
		$ribu = number_format($angka,0,',','.');
		return $ribu;
	}

	function format_ribuan2($angka) {
		$ribu = number_format($angka,2,',','.');
		return $ribu;
	}