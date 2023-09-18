<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function getMailerAuth($username,$name,$subject)
{
	$arr['username'] = $username;
	$arr['name'] = $name;
	$arr['subject'] = $subject;
	return $arr;
}

function sendMail($authInfo,$target,$body)
{

	/* setting SMTP */
	$mail = new PHPMailer(true);
	try{
		$mail->isSMTP();
		$mail->Host = $authInfo['host'];
		$mail->Port = $authInfo['port']; //sesuaikan port
		$mail->SMTPAuth = $authInfo['auth'];
		$mail->Username = $authInfo['username'];
		$mail->Password = $authInfo['password'];
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
		$mail->WordWrap = 300;
		$mail->setFrom($authInfo['username'], $authInfo['name']);
		$mail->addAddress($target); //alamat email yang dituju
		$mail->Subject = $authInfo['subject']; //subject
		$mail->Body = $body;
		$mail->isHTML(true);

		$sends = $mail->send();
		return $sends;
	}catch (Exception $e)
	{
		return $mail->ErrorInfo;
	}
}

function setPaymentMailBody($user,$ticketId)
{
	$getTick = crud_selwhere("app_order_ticket","ticket_id = '$ticketId'")['single'];
	$itemType = $getTick->item_type;
	$itemId = $getTick->item_referal_id;
	$date = createFullFormattedDate($getTick->date_updated,true);
	$idOrder = $getTick->order_id;

	//Item
	if($itemType == "pack")
	{
		$getItems = crud_selwhere("app_sku_pack_price","item_id = '$itemId'")['single'];
		$itemName = $getItems->nama_paket;
		$parentId = $getItems->pack_id;
		$parentName = crud_selwhere("app_sku_pack","pack_id = '$parentId'")['single']->nama_pack;
	}
	else{
		$getItems = crud_selwhere("app_sku_price","item_id = '$itemId'")['single'];
		$itemName = $getItems->nama_paket;
		$parentId = $getItems->bundle_id;
		$parentName = crud_selwhere("app_sku_bundle","bundle_id = '$parentId'")['single']->bundle_name;
	}
	$durasi = $getItems->durasi;
	$price = $getItems->harga_final;
	$tax = $price / 100 * 11;
	$taxStr = "Rp.".number_format($tax,0,",",".");
	$priceStr = "Rp.".number_format($price,0,",",".");
	$total = "Rp.".number_format($price + $tax,0,",",".");
	//End

	$imsrc = base_url()."assets/images/logo_launcher.png";
	$html = "
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>
<html>
	<head>
		<meta http-equiv='content-type' content='text/html; charset=ISO-8859-15'>
	</head>
	<body>
	<div style='color:#333;box-shadow:5px 5px 20px #ddd;background-color:#eee;padding:30px;font-family: Work Sans,sans-serif;width:400px;border-radius:15px'>
	<h1 style='text-align:left;color:#000;'>Pembelian Berhasil</h1>
	<p style='text-align: left;color:#000;'>Terima kasih atas pembelian produk Waterlo PRO. Detail dibawah menerangkan rincian transaksi Anda.</p>
	<p style='text-align:left;color:#000'>
		ID Order: <b>#$idOrder</b><br>
		Produk: <b>$parentName</b><br>
		Item: <b>$itemName</b><br>
		Masa Aktif: <b>$durasi hari</b><br>
		Tanggal: <b>$date</b><br>
	</p>
	<p style='text-align:left;background-color:#fff;padding:15px;border-radius:10px;color:#000;'>
		Harga: <b>$priceStr</b><br>
		PPN 11%: <b>$taxStr</b><br>
		<span style='font-size:18px;'>Total: <b>$total</b></span>
		<br>
		<span style='font-size:10px;color:#aaa;margin-top:10px;display:block;'>Harap simpan E-mail ini sebagai tanda bukti transaksi yang sah. Invoice juga dapat dilihat di halaman Pengaturan > Invoice di aplikasi Waterlo.</span>
	</p>
	<center><img src='$imsrc' style='width:80px;margin-top:10px;'></center>
	<h2 style='text-align:center;padding:0;margin:3px;'>Waterlo</h2>
	<center>
	<p style='padding:0;margin:0;font-size:11px;'>Jalan Kolonel M. Kukuh No. 14<br>Kota Baru, Kota Jambi, Jambi. Indonesia</p>
	<div style='display: block;margin-top:5px;'>
	<a style='background:#00aaff;margin:1px;text-decoration: none;padding:5px;color:#fff;border-radius:10px;' href='https://waterlo.id'>Waterlo</a>
	<a style='background:#00aaff;margin:1px;text-decoration: none;padding:5px;color:#fff;border-radius:10px;' href='https://waterlo.id/kebijakan-privasi'>Kebijakan Privasi</a>
	</div>
	</center>
	</div>
	</body>
</html>
";
	return $html;
}

function setWsMailNotify($title,$msg)
{
	$imsrc = base_url()."assets/images/logo_launcher.png";
	$html = "
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>
<html>
	<head>
		<meta http-equiv='content-type' content='text/html; charset=ISO-8859-15'>
	</head>
	<body>
	<div style='color:#333;box-shadow:5px 5px 20px #ddd;background-color:#eee;padding:30px;font-family: Work Sans,sans-serif;width:400px;border-radius:15px'>
	<h1 style='text-align:left;color:#000;'>$title</h1>
	<p style='text-align: left;color:#000;'>$msg</p>
	<center><img src='$imsrc' style='width:80px;margin-top:10px;'></center>
	<h2 style='text-align:center;padding:0;margin:3px;'>Waterlo</h2>
	<center>
	<p style='padding:0;margin:0;font-size:11px;'>Jalan Kolonel M. Kukuh No. 14<br>Kota Baru, Kota Jambi, Jambi. Indonesia</p>
	<div style='display: block;margin-top:5px;'>
	<a style='background:#00aaff;margin:1px;text-decoration: none;padding:5px;color:#fff;border-radius:10px;' href='https://waterlo.id'>Waterlo</a>
	<a style='background:#00aaff;margin:1px;text-decoration: none;padding:5px;color:#fff;border-radius:10px;' href='https://waterlo.id/kebijakan-privasi'>Kebijakan Privasi</a>
	</div>
	</center>
	</div>
	</body>
</html>
";
	return $html;
}

function setBasicMail($title,$msg)
{

	$imsrc = base_url()."assets/images/logo_launcher.png";
	$html = "
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>
<html>
	<head>
		<meta http-equiv='content-type' content='text/html; charset=ISO-8859-15'>
	</head>
	<body>
	<div style='color:#333;box-shadow:5px 5px 20px #ddd;background-color:#eee;padding:30px;font-family: Work Sans,sans-serif;width:400px;border-radius:15px'>
	<h1 style='text-align:left;color:#000;'>$title</h1>
	<p style='text-align: left;color:#000;'>$msg</p>
	<center><img src='$imsrc' style='width:80px;margin-top:10px;'></center>
	<h2 style='text-align:center;padding:0;margin:3px;'>Waterlo</h2>
	<center>
	<p style='padding:0;margin:0;font-size:11px;'>Jalan Kolonel M. Kukuh No. 14<br>Kota Baru, Kota Jambi, Jambi. Indonesia</p>
	<div style='display: block;margin-top:5px;'>
	<a style='background:#00aaff;margin:1px;text-decoration: none;padding:5px;color:#fff;border-radius:10px;' href='https://waterlo.id'>Waterlo</a>
	<a style='background:#00aaff;margin:1px;text-decoration: none;padding:5px;color:#fff;border-radius:10px;' href='https://waterlo.id/kebijakan-privasi'>Kebijakan Privasi</a>
	</div>
	</center>
	</div>
	</body>
</html>
";
	return $html;
}

function setPassVerifyCodeMail($code)
{

	$imsrc = base_url()."assets/images/logo_launcher.png";
	$html = "
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>
<html>
	<head>
		<meta http-equiv='content-type' content='text/html; charset=ISO-8859-15'>
	</head>
	<body>
	<div style='color:#333;box-shadow:5px 5px 20px #ddd;background-color:#eee;padding:30px;font-family: Work Sans,sans-serif;width:400px;border-radius:15px'>
	<h1 style='text-align:left;color:#000;'>Pemulihan Akun</h1>
	<p style='text-align: left;color:#000;'>Berikut adalah kode verifikasi pemulihan akun Anda. Masukkan kode berikut ke Aplikasi Waterlo.</p>
	<p style='text-align:left;background-color:#fff;padding:15px;border-radius:10px;color:#000;text-align: center'>
		<span style='font-size:26px;'><b>$code</b></span>
		<br>
		<span style='font-size:10px;color:#aaa;margin-top:10px;display:block;'>*Kode hanya berlaku 10 menit sejak E-mail ini terkirim.</span>
	</p>
	<center><img src='$imsrc' style='width:80px;margin-top:10px;'></center>
	<h2 style='text-align:center;padding:0;margin:3px;'>Waterlo</h2>
	<center>
	<p style='padding:0;margin:0;font-size:11px;'>Jalan Kolonel M. Kukuh No. 14<br>Kota Baru, Kota Jambi, Jambi. Indonesia</p>
	<div style='display: block;margin-top:5px;'>
	<a style='background:#00aaff;margin:1px;text-decoration: none;padding:5px;color:#fff;border-radius:10px;' href='https://waterlo.id'>Waterlo</a>
	<a style='background:#00aaff;margin:1px;text-decoration: none;padding:5px;color:#fff;border-radius:10px;' href='https://waterlo.id/kebijakan-privasi'>Kebijakan Privasi</a>
	</div>
	</center>
	</div>
	</body>
</html>
";
	return $html;
}
