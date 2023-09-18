<?php
function myDate()
{
	date_default_timezone_set("Asia/Jakarta");
	return date("Y-m-d H:i:s");
}

function myTime()
{
	date_default_timezone_set("Asia/Jakarta");
	return time();
}

function getLapse($tglTumpuan,$tglTarget)
{
	$first = new DateTime($tglTarget);
	$second = new DateTime($tglTumpuan);
	$diff = $first->diff($second);

	$u1 = date_format(date_create($tglTarget),"U");
	$u2 = date_format(date_create($tglTumpuan),"U");
	if($u2 <= $u1)
	{
		$cal = $u1 - $u2;
		$over = false;
		$percent = ($u2 / $u1) * 100;
	}
	else
	{
		$over = true;
		$percent = 100;
	}

	return array(
		"date_point"=>$tglTumpuan,
		"date_target"=>$tglTarget,
		"unix_point"=>$u2,
		"unix_target"=>$u1,
		"day"=>$diff->format('%D'),
		"day_nice"=>$diff->format('%D')." hari",
		"month"=>$diff->format('%M'),
		"month_nice"=>$diff->format('%M')." bulan",
		"year"=>$diff->format('%Y'),
		"year_nice"=>$diff->format('%Y')." tahun",
		"hour"=>$diff->format('%H'),
		"minute"=>$diff->format('%I'),
		"second"=>$diff->format('%S'),
		"percent"=>round($percent,10),
		"is_overtarget"=>$over,
	);
}

function dateGetBetweenRange($r1,$r2)
{
	date_default_timezone_set("Asia/Jakarta");
	$rawDate = array();
	$niceDate = array();
	$niceShortDate = array();

	$uStampR1 = date_format(date_create($r1),"U");
	$uStampR2 = date_format(date_create($r2),"U");
	$uStampCalc = $uStampR2 - $uStampR1;
	$uStampCalcReversed = $uStampR1 - $uStampR2;

	$period = new DatePeriod(
	    new DateTime($r1),
		new DateInterval('P1D'),
		new DateTime($r2)
	);
	if($period)
	{
		$n=0;
		foreach($period as $key => $value)
		{
			$n++;
			array_push($rawDate,[$value->format("Y-m-d")]);
			array_push($niceDate,[createFullFormattedDate($value->format("Y-m-d"),false,false)]);
			array_push($niceShortDate,[createFullFormattedDate($value->format("Y-m-d"),false,true)]);
		}
		return [
			"raw_date"=>$rawDate,
			"nice_date"=>$niceDate,
			"short_date"=>$niceShortDate,
			"extra"=> array(
				"num_of_days"=>$n,
				"unix_stamp_startdate"=>$uStampR1,
				"unix_stamp_enddate"=>$uStampR2,
				"unix_stamp_calculated"=>$uStampCalc,
				"unix_stamp_calculated_reversed"=>$uStampCalcReversed,
				"period"=>$period
			)
		];
	}
	else{
		return false;
	}
}

function dateForwardDate($date,$forward,$withTime = true)
{
	$date = new DateTime($date);
	$date->add(new DateInterval('P'.$forward.'D'));
	if($withTime)
	{
		return $date->format("Y-m-d H:i:s");
	}
	else{
		return $date->format("Y-m-d");
	}
}

function getDaysOfMonth($date)
{
	$create = date_create($date);
	$t = date_format($create,"t");

	$dateRemake = substr($date,0,7);

	$data['date_collection'] = array();
	$data['date_readable_collection'] = array();
	$data['date_days'] = array();
	$data['day_count'] = $t;
	for($i = 1; $i <= $t;$i++)
	{
		if($i < 10)
		{
			$newDate = $dateRemake."-0".$i;
		}
		else{
			$newDate = $dateRemake."-".$i;
		}
		$createdDate = date_create($newDate);
		$formatDate = date_format($createdDate,"Y-m-d");
		$readableDate = createFullFormattedDate($newDate,false);
		array_push($data['date_collection'],$formatDate);
		array_push($data['date_readable_collection'],$readableDate);
		array_push($data['date_days'],date_format($createdDate,"d"));
	}
	return $data;
}

function myDateCreateNewDate($date)
{
	$create = date_create($date);
	return $create;
}

function createFullFormattedDate($date, $withTime = false, $short = false)
{
	if($short)
	{
		$day = substr(myDateCreateDay($date, "text"),0,3);
		$dayOfMonth = myDateCreateDay($date, "number");
		$month = substr(myDateCreateMonth($date, "text"),0,3);
	}
	else{
		$day = myDateCreateDay($date, "text");
		$dayOfMonth = myDateCreateDay($date, "number");
		$month = myDateCreateMonth($date, "text");
	}

	$year = myDateCreateYear($date);
	if ($withTime) {
		$time = myDateCreateTime($date);
		return $day . ", " . $dayOfMonth . " " . $month . " " . $year . " - " . $time;
	} else {
		return $day . ", " . $dayOfMonth . " " . $month . " " . $year;
	}
}

function myDateCreateTime($date)
{
	$h = date_format(myDateCreateNewDate($date), "H");
	$m = date_format(myDateCreateNewDate($date), "i");
	return $h . "." . $m;
}

function myDateCreateDay($date, $type = "number")
{
	if ($type == "number") {
		return date_format(myDateCreateNewDate($date), "d");
	} else if ($type == "text") {
		return dayToTextId(date_format(myDateCreateNewDate($date), "l"));
	} else if ($type == "numberOfDayWeek") {
		return date_format(myDateCreateNewDate($date), "N");
	} else {
		return null;
	}
}

function myDateCreateMonth($date, $type = "number")
{
	if ($type == "number") {
		return date_format(myDateCreateNewDate($date), "m");
	} else if ($type == "text") {
		return monthToTextId(date_format(myDateCreateNewDate($date), "n"));
	} else {
		return null;
	}
}

function myDateCreateYear($date, $type = "fourDigit")
{
	if ($type == "fourDigit") {
		return date_format(myDateCreateNewDate($date), "Y");
	} else if ($type == "twoDigit") {
		return date_format(myDateCreateNewDate($date), "y");
	}
}

function date_formatted()
{
	date_default_timezone_set("Asia/Jakarta");
	return date("j F Y - H:i");
}

function forwardDate($toForward, $daysForward)
{
	date_default_timezone_set("Asia/Jakarta");
	try {
		$datetime = new DateTime($toForward);
		$datetime->modify($daysForward);
		return $datetime->format("Y-m-d H:i:s");
	} catch (Exception $e) {
		$e->getTrace();
	}
}

function timeIncrement($hour, $minute, $incr)
{
	date_default_timezone_set("Asia/Jakarta");
	$time = new DateTime($hour . ":" . $minute);
	$time->add(new DateInterval("PT" . $incr . "M"));
	return $time->format('H.i');
}

function formatTime($hour, $minute)
{
	date_default_timezone_set("Asia/Jakarta");
	$time = new DateTime($hour . ":" . $minute);
	return $time->format('H.i');
}

function dateToFormat($format, $raw)
{
	date_default_timezone_set("Asia/Jakarta");
	return date($format, strtotime($raw));
}

function dayToTextId($dayEng)
{
	$ci = get_instance();
	$db = $ci->db;
	if ($dayEng === "Sunday") {
		return "Minggu";
	} else if ($dayEng == "Monday") {
		return "Senin";
	} else if ($dayEng == "Tuesday") {
		return "Selasa";
	} else if ($dayEng == "Wednesday") {
		return "Rabu";
	} else if ($dayEng == "Thursday") {
		return "Kamis";
	} else if ($dayEng == "Friday") {
		return "Jumat";
	} else if ($dayEng == "Saturday") {
		return "Sabtu";
	}
}

function monthToTextId($monthNum,$leadingZero = false)
{
	if(!$leadingZero)
	{
		if ($monthNum == "1") {
			return "Januari";
		} else if ($monthNum == "2") {
			return "Februari";
		} else if ($monthNum == "3") {
			return "Maret";
		} else if ($monthNum == "4") {
			return "April";
		} else if ($monthNum == "5") {
			return "Mei";
		} else if ($monthNum == "6") {
			return "Juni";
		} else if ($monthNum == "7") {
			return "Juli";
		} else if ($monthNum == "8") {
			return "Agustus";
		} else if ($monthNum == "9") {
			return "September";
		} else if ($monthNum == "10") {
			return "Oktober";
		} else if ($monthNum == "11") {
			return "November";
		} else if ($monthNum == "12") {
			return "Desember";
		}
	}
	else{
		if ($monthNum == "01") {
			return "Januari";
		} else if ($monthNum == "02") {
			return "Februari";
		} else if ($monthNum == "03") {
			return "Maret";
		} else if ($monthNum == "04") {
			return "April";
		} else if ($monthNum == "05") {
			return "Mei";
		} else if ($monthNum == "06") {
			return "Juni";
		} else if ($monthNum == "07") {
			return "Juli";
		} else if ($monthNum == "08") {
			return "Agustus";
		} else if ($monthNum == "09") {
			return "September";
		} else if ($monthNum == "10") {
			return "Oktober";
		} else if ($monthNum == "11") {
			return "November";
		} else if ($monthNum == "12") {
			return "Desember";
		}
	}
	
}
