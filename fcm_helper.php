<?php
function sendFcmMessage($target,$title,$msg,$subject,$priority,$payload = null,$user = null,$onclick = null)
{
	$server_key = "AAAALDfr0ro:APA91bH6_aWbGbbJCpAzUbcRJnZnmB_kbz9bsWRNxvuamrcbOGf7xbcORHMn8taiwvE171Jvy8ZBq__k8T_b_UTdRZ22ce4MDjKbavmQqTDHh6Mo_K9Fuo-ThuLk-L2TaLbD8gEBPaIB";

	if($onclick != null)
	{
		$not = array("title"=>$title,"body"=>$msg,"click_action"=>$onclick,"sound"=>"default","badge"=>"1");
	}
	else{
		$not = array("title"=>$title,"body"=>$msg,"sound"=>"default","badge"=>"1");
	}

	if($payload == null)
	{
		$arr = array("registration_ids"=>array("{$target}"),"content_available"=> true,"notification"=>$not,"priority"=>"high");
	}
	else{
		$arr = array("registration_ids"=>array("{$target}"),"content_available"=> true,"notification"=>$not,"priority"=>"high","data"=>$payload);
	}
	$data = json_encode($arr);

	$f['title'] = $title;
	$f['body'] = $msg;
	$f['subject'] = $subject;
	$f['readstatus'] = 0;
	$f['usercode'] = $user;
	$f['date'] = myDate();
	$f['priority'] = $priority;
	$ci = get_instance();
	$ci->db->insert("app_notif",$f);

	$url = 'https://fcm.googleapis.com/fcm/send';
	$headers = array(
		'Content-Type:application/json',
		'Authorization:key='.$server_key
	);
	$headers[] = "Content-Type: application/json";
	$headers[] = "Authorization: key='. $server_key";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$result = curl_exec($ch);
	curl_close($ch);

	return $result;
}
