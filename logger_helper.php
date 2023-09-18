<?php
/** Severity Level: @info | @notice | @warning | @danger | @fatal | @error*/
/*
 * Info: Totally safe. Trace only.
 * Notice: User error event or hard deletion. Considered safe to the system.
 * Warning: May be caused by: Nullness of storage data/records, unauthorized actions
 */

function traceClient($url,$msg = null)
{
   $logPolicy = crud_selwhere("d_policy","p_name = 'trace_client'")['single'];
   if($logPolicy->p_value == 1)
   {
	  $date = myDate();
	  $user = ses_get("user");
	  $level = ses_get("level");
	  $ip = $_SERVER['REMOTE_ADDR'];
	  return crud_insert("d_tracer","'','$ip','$url','$date','$user','$level','$msg'");
   }
   else{
      return null;
   }
}

function writeLog($content,$level,$area)
{
   $date = myDate();
   $sus = ses_get("user");
   $logPolicy = crud_selwhere("d_policy","p_name = 'activate_devlog'")['single'];
   if($logPolicy->p_value == 1)
   {
	  if($logPolicy->flag == "all")
	  {
		 return crud_insert("d_dev_log","'','$content','$level','$area','$date','$sus'");
	  }
	  else{
	     if($logPolicy->flag == $level)
		 {
			return crud_insert("d_dev_log","'','$content','$level','$area','$date','$sus'");
		 }
	     else
		 {
		    return null;
		 }
	  }
   }
   else{
      return null;
   }
}

function dumpLogs($limit = 0)
{
   if($limit == 0)
   {
	  $data = crud_selwhere("d_dev_log","1 ORDER BY date DESC");
   }
   else{
	  $data = crud_selwhere("d_dev_log","1 ORDER BY date DESC LIMIT $limit");
   }

   if($data['count'])
   {
	  foreach($data['multi'] as $log)
	  {
		 echo "Date Traced: ".$log->date." | "."Impact Area: ".$log->area." | "."Severity: ".$log->level." | "."Message: ".$log->content."<br>";
	  }
	  echo "<br><br>".$data['count']." traced";
   }
   else{
      echo myDate()." | Dev Log is empty, no data traced so far.";
   }
}
