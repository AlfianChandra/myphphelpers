<?php 
	//developed by MyEnvy
	function ngitungHari($awal, $akhir)
	{

		$uAwal = date_format(date_create($awal),"U");
		$uAkhir = date_format(date_create($akhir),"U");

		$hasil = $uAkhir-$uAwal;

		$hasilHariDiv = intdiv($hasil,86400);
		$hasilHariMod = fmod($hasil,86400);
		$hour = intdiv($hasilHariMod,3600);
		$hourMod = fmod($hasilHariMod,3600);
		$menit = intdiv($hourMod,60);
		$detik = fmod($hourMod,60);

		$nHasil = array(
			[$hasilHariDiv, $hour, $menit, $detik],
		);

		return $nHasil;
	}
	function ubahBulan($bulan)
	{
		if ($bulan == '01') {
			return 'Januari';
		} elseif ($bulan == '02') {
			return 'Februari';
		} elseif ($bulan == '03') {
			return 'Maret';
		} elseif ($bulan == '04') {
			return 'April';
		} elseif ($bulan == '05') {
			return 'Mei';
		} elseif ($bulan == '06') {
			return 'Juni';
		} elseif ($bulan == '07') {
			return 'Juli';
		} elseif ($bulan == '08') {
			return 'Agustus';
		} elseif ($bulan == '09') {
			return 'September';
		} elseif ($bulan == '10') {
			return 'Oktober';
		} elseif ($bulan == '11') {
			return 'November';
		} else {
			return 'Desember';
		}
	}

	function ubahHari($hari)
	{
		if($hari == 'Sunday'){
			return 'Minggu';
		} elseif($hari == 'Monday') {
			return 'Senin';
		} elseif($hari == 'Thursday') {
			return 'Selasa';
		} elseif($hari == 'Wednesday') {
			return 'Rabu';
		} elseif($hari == 'Tuesday') {
			return 'Kamis';
		} elseif($hari == 'Friday') {
			return 'Jumat';
		} elseif($hari == 'Saturday') {
			return 'Sabtu';
		}
	}

	function nampilHari($awal, $akhir)
	{
		$hasilMentah = array();
		$hasilBagus = array();
		$hasilMinim = array();
		$period = new DatePeriod(
		    new DateTime($awal),
		    new DateInterval('P1D'),
		    new DateTime($akhir)
		);
		foreach ($period as $key => $value) {
			array_push($hasilMentah,[$value->format('Y-m-d')]);

			$date = date_create($value->format('Y-m-d'));
			$bulan = date_format($date,'m');
			$hari = date_format($date,'d');
			$hariBaru = ubahHari(date_format($date,'l'));
			$bulanBaru = ubahBulan($bulan);

			array_push($hasilBagus,[$hariBaru.", ".$hari.' '.$bulanBaru.' '.$value->format('Y')]);

			array_push($hasilMinim,[substr($hariBaru,0,3).", ".$hari.' '.substr($bulanBaru,0,3).' '.$value->format('Y')]);
		}

		return ['raw' => $hasilMentah, 'human_readable' => $hasilBagus, 'sort_form' => $hasilMinim];
	}


 ?>