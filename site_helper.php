<?php
function getsetting($name)
{
   return crud_selwhere("s_setting","set_name = '$name'")['single']->set_value;
}
function getsettingflag($name)
{
   return crud_selwhere("d_policy","set_name = '$name'")['single']->set_flag;
}

function getsetting_desc($name)
{
	return crud_selwhere("s_setting","set_name = '$name'")['single']->set_desc;
}

function getsetting_name($name)
{
	return crud_selwhere("s_setting","set_name = '$name'")['single']->set_title;
}

function getalert_title()
{
	return ses_get("al_title");
}

function getalert_msg()
{
	return ses_get("al_msg");
}

function getalert_prior()
{
	return ses_get("al_prior");
}

function setalert($title,$msg,$prior = 0)
{
	ses_set("al_title",$title);
	ses_set("al_msg",$msg);
	ses_set("al_prior",$prior);
}

function clearalert()
{
	ses_set("al_title",null);
	ses_set("al_msg",null);
	ses_set("al_prior",null);
}
