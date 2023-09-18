<?php
function getactivelang()
{
	$prefLang = ses_get("lang");
	if($prefLang != null)
	{
		return $prefLang;
	}
	else{
		//Active lang
		$lang = crud_selwhere("s_lang","active = '1'")['single'];
		return $lang->lang_loc;
	}
}

function setlangstr($id,$en)
{
	if(getactivelang() == "id")
	{
		return $id;
	}
	else{
		return $en;
	}
}
