<?php
function makeslug($str,$includeNumber = TRUE)
{
   if($includeNumber)
   {
	  $marks = array("~","`","!","@","#","$","%","^","&","*","(",")","_","-","+","=","{","}","|",":",";","'","<",">",",",".","?","/");
   }
   else{
	  $marks = array("~","`","!","@","#","$","%","^","&","*","(",")","_","-","+","=","{","}","|",":",";","'","<",">",",",".","?","/","1","2","3","4","5","6","7","8","9","0");
   }
   $sanitized = str_replace($marks,"",$str);
   return strtolower(str_replace(" ","-",$sanitized));
}

