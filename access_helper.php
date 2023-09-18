<?php
function check_auth($token)
{
	$check = crud_selwhere("d_authtoken", "token = '$token'");
	if (!$check['count']) {
		http_response_code(403);
		writeLog("Access denied - Auth Token", "check", "API");
		return array("status" => "failed", "msg" => "auth_token_inv");
		die;
	}
	return array("status" => "ok", "msg" => "success");
}

function check_api_permission($token, $var = null)
{
	header("Content-Type:application/json");
	$ci = get_instance();
	$refid = crud_selwhere("d_apikey", "client_token = '$token'");
	if ($refid['count']) {
		$plat = $refid['single']->platform;
		$ref = $refid['single']->refid;
		$isLimited = intval($refid['single']->applylimit);
		$limit = $refid['single']->reqlimit;
		$reqUsed = $refid['single']->req_used;
		if ($isLimited) {
			if ($reqUsed < $limit) //Safe
			{
				$reqUsed += 1;
				crud_update("d_apikey", "req_used = '$reqUsed'", "refid = '$ref'"); //Incr usage
				return array('status' => "ok", "msg" => "success");
			} else { //Reached
				writeLog("Access denied - Limit reached", "check", "android");
				http_response_code(403);
				return array('status' => "failed", "msg" => "limit_reached");
			}
		} else {
			$reqUsed += 1;
			crud_update("d_apikey", "req_used = '$reqUsed'", "refid = '$ref'"); //Incr usage
			return array('status' => "ok", "msg" => "success");
		}
	} else {
		http_response_code(403);
		writeLog("Access denied - Invalid Token", "check", "API");
		return array('status' => "failed", "msg" => "inv_token", "token" => $token);
	}
}

function check_access($role, $var, $className = null)
{
	if($className != null)
	{
		$check = crud_selwhere("d_role_access", "role_id = '$role' AND function = '$var' AND area = '$className'");
	}
	else{
		$check = crud_selwhere("d_role_access", "role_id = '$role' AND function = '$var'");
	}
	if ($check['count']) {
		$checkLock = crud_selwhere("d_functions", "sys_varname = '$var'")['single'];
		if ($checkLock->lockfun == 1) {
			return 0;
		} else {
			return 1;
		}
	} else {
		return 0;
	}
}

function check_function_access($role, $var,$className = null, $response = "redirect")
{
	if($className != null)
	{
		$check = crud_selwhere("d_role_access", "role_id = '$role' AND function = '$var' AND area = '$className'");
		if ($check['count']) {
			$checkLock = crud_selwhere("d_functions", "sys_varname = '$var' AND area = '$className'")['single'];
			if ($checkLock->lockfun == 1) {
				if ($response == "redirect") {
					http_response_code(503);
					redirect(base_url("access_denied"));
				} else if ($response == "json") {
					http_response_code(503);
					echo json_encode(['status' => 0, "msg" => "Gagal: Akses ke fungsi dikunci!"]);
					die;
				} else if ($response == "alert") {
					http_response_code(503);
					echo "<div class='alert alert-danger'>Akses ditolak. Fungsi sedang tidak dapat diakses!</div>";
					die;
				}
			} else if ($checkLock->lockfun == 2) {
				if ($response == "redirect") {
					http_response_code(503);
					redirect(base_url("under_maintenance"));
				} else if ($response == "json") {
					http_response_code(503);
					echo json_encode(['status' => 0, "msg" => "Gagal: Fungsi sedang dalam perbaikan"]);
					die;
				} else if ($response == "alert") {
					http_response_code(503);
					echo "<div class='alert alert-danger'>Fungsi sedang dalam perbaikan</div>";
					die;
				}
			}
		} else {
			if ($response == "redirect") {
				http_response_code(403);
				redirect(base_url("access_denied"));
			} else if ($response == "json") {
				http_response_code(403);
				echo json_encode(['status' => 0, "msg" => "Akses ditolak!"]);
				die;
			} else if ($response == "alert") {
				http_response_code(403);
				echo "<div class='alert alert-danger'>Akses Ditolak!</div>";
				die;
			}
		}
	}
	else{
		$check = crud_selwhere("d_role_access", "role_id = '$role' AND function = '$var'");
		if ($check['count']) {
			$checkLock = crud_selwhere("d_functions", "sys_varname = '$var'")['single'];
			if ($checkLock->lockfun == 1) {
				if ($response == "redirect") {
					http_response_code(503);
					redirect(base_url("access_denied"));
				} else if ($response == "json") {
					http_response_code(503);
					echo json_encode(['status' => 0, "msg" => "Gagal: Akses ke fungsi dikunci!"]);
					die;
				} else if ($response == "alert") {
					http_response_code(503);
					echo "<div class='alert alert-danger'>Akses ditolak. Fungsi sedang tidak dapat diakses!</div>";
					die;
				}
			} else if ($checkLock->lockfun == 2) {
				if ($response == "redirect") {
					http_response_code(503);
					redirect(base_url("under_maintenance"));
				} else if ($response == "json") {
					http_response_code(503);
					echo json_encode(['status' => 0, "msg" => "Gagal: Fungsi sedang dalam perbaikan"]);
					die;
				} else if ($response == "alert") {
					http_response_code(503);
					echo "<div class='alert alert-danger'>Fungsi sedang dalam perbaikan</div>";
					die;
				}
			}
		} else {
			if ($response == "redirect") {
				http_response_code(403);
				redirect(base_url("access_denied"));
			} else if ($response == "json") {
				http_response_code(403);
				echo json_encode(['status' => 0, "msg" => "Akses ditolak!"]);
				die;
			} else if ($response == "alert") {
				http_response_code(403);
				echo "<div class='alert alert-danger'>Akses Ditolak!</div>";
				die;
			}
		}
	}
}
