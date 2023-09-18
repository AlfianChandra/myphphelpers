<?php
use \Firebase\JWT\JWT;
function validateBill($id,$token)
{
	$package = "com.dbn.waterlo";
	$url = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/$package/purchases/products/$id/tokens/$token";
	$api = "ya29.a0AX9GBdVEh7SQAV0SCWRbtxIxvAd-Kd8auCNrjJ4ongAjwyBtank6gOkQ30LKep7hoYrHVwMLhWf_Rzi7nwrtMSPUXhxzx6GX_5IhMlzMmPsSzRqdTBfc3xn-0qFJd9UI8TcaU7yYTkVXxK1t5E4OEJ-mvFgaaCgYKAXMSARMSFQHUCsbCUdLLEYJlLxKtHr48zwIGkQ0163";

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		"Authorization: Bearer " . $api
	));
	// Jalankan request CURL
	$response = curl_exec($curl);
	// Tutup CURL
	curl_close($curl);
	return $response;
}

function ackPurchase($id,$token)
{
	$accToken = getAccToken()->access_token;
	$header = [
		"Content-Type: application/json",
		"Authorization: Bearer ".$accToken
	];
	$package = "com.dbn.waterlo";
	$payload = [
		"packageName"=>$package,
		"subscriptionId"=>$id,
		"token"=>$token
	];
	$ch = curl_init("https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{$package}/purchases/subscriptions/{$id}/tokens/{$token}:acknowledge");
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
	curl_setopt($ch,CURLOPT_POST,1);
	curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
	$response = curl_exec($ch);
	curl_close($ch);
	if($response == null)
	{
		return true;
	}
	else{
		return false;
	}
}

function revokeSub($productId,$purchaseToken)
{
	$accToken = getAccToken()->access_token;
	$header = [
		"Content-Type: application/json",
		"Authorization: Bearer ".$accToken
	];
	$package = "com.dbn.waterlo";
	$payload = [
		"packageName"=>$package,
		"subscriptionId"=>$productId,
		"token"=>$purchaseToken
	];
	$ch = curl_init("https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{$package}/purchases/subscriptions/{$productId}/tokens/{$purchaseToken}:revoke");
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
	curl_setopt($ch,CURLOPT_POST,1);
	curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
	$response = curl_exec($ch);
	curl_close($ch);
	if($response == null)
	{
		$ci = get_instance();
		$c['purchasetoken'] = $purchaseToken;
		$c['itemid'] = $productId;
		$c['daterevoked'] = myDate();
		$ci->db->insert("app_sub_revoked",$c);
	}
	return $response;
}

function verifyBill($productId,$purchaseToken,$isV2 = true)
{
	$accToken = getAccToken()->access_token;
	$header = [
		"Content-Type: application/json",
		"Authorization: Bearer ".$accToken
	];
	$package = "com.dbn.waterlo";
	$payload = [
		"packageName"=>$package,
		"productId"=>$productId,
		"purchaseToken"=>$purchaseToken
	];
	if($isV2)
	{
		$ch = curl_init("https://www.googleapis.com/androidpublisher/v3/applications/$package/purchases/subscriptionsv2/tokens/$purchaseToken");
	}
	else{
		$ch = curl_init("https://www.googleapis.com/androidpublisher/v3/applications/$package/purchases/subscriptions/$productId/tokens/$purchaseToken");
	}
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
	curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
	$response = curl_exec($ch);
	curl_close($ch);
	return $response;
}

function consumeProduct($productId,$purchaseToken)
{
	$accToken = getAccToken()->access_token;
	$header = [
		"Content-Type: application/json",
		"Authorization: Bearer ".$accToken
	];
	$package = "com.dbn.waterlo";
	$payload = [
		"packageName"=>$package,
		"productId"=>$productId,
		"purchaseToken"=>$purchaseToken
	];
	$ch = curl_init("https://www.googleapis.com/androidpublisher/v3/applications/$package/purchases/products/$productId/tokens/$purchaseToken:consume");
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
	curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
	$response = curl_exec($ch);
	curl_close($ch);
	return $response;
}

function getAccToken()
{

	$svacc = file_get_contents("./svacc.json");
	$decod = json_decode($svacc);

	$pvKeyId = $decod->private_key_id;
	$pvKey = $decod->private_key;
	$headerArray = [
		"alg"=>"RS256",
		"typ"=>"JWT"
	];

	$claimArray = array(
		"iss"=>"free-rhyme@pc-api-7505444443233929704-358.iam.gserviceaccount.com",
		"scope"=>"https://www.googleapis.com/auth/androidpublisher",
		"aud"=>"https://oauth2.googleapis.com/token",
		"exp"=>time()+60,
		"iat"=>time()
	);
	$key = $pvKey;
	$jwt = JWT::encode($claimArray,$key,"RS256",$pvKeyId,$headerArray);
	$data["grant_type"] = urlencode('urn:ietf:params:oauth:grant-type:jwt-bearer');
	$data['assertion'] = $jwt;
	$url = "https://oauth2.googleapis.com/token?grant_type=".urlencode('urn:ietf:params:oauth:grant-type:jwt-bearer')."&assertion=".$jwt;
	$headers[] = "Content-Type: application/x-www-form-urlencoded";
	$headers[] = "Host: oauth2.googleapis.com";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);
	return json_decode($result); //Object
}

function billGenerateAuthCode($cId)
{
	$clientId = $cId;
	$redirectUri = 'http://localhost/water/api/ws/gen_finalize';
	header("Location: https://accounts.google.com/o/oauth2/v2/auth?client_id=$clientId&response_type=code&redirect_uri=$redirectUri&scope=https://www.googleapis.com/auth/androidpublisher");
}

