<?php
function date_convertmonth($intMonth,$roman = false)
{
   if($roman == false)
   {
	  $monthString = null;
	  if($intMonth == 1)
	  {
		 $monthString = "Januari";
	  }
	  else if($intMonth == 2)
	  {
		 $monthString = "Februari";
	  }
	  else if($intMonth == 3)
	  {
		 $monthString = "Maret";
	  }
	  else if($intMonth == 4)
	  {
		 $monthString = "April";
	  }
	  else if($intMonth == 5)
	  {
		 $monthString = "Mei";
	  }
	  else if($intMonth == 6)
	  {
		 $monthString = "Juni";
	  }
	  else if($intMonth == 7)
	  {
		 $monthString = "Juli";
	  }
	  else if($intMonth == 8)
	  {
		 $monthString = "Agustus";
	  }
	  else if($intMonth == 9)
	  {
		 $monthString = "September";
	  }
	  else if($intMonth == 10)
	  {
		 $monthString = "Oktober";
	  }
	  else if($intMonth == 11)
	  {
		 $monthString = "November";
	  }
	  else if($intMonth == 12)
	  {
		 $monthString = "Desember";
	  }
	  else
	  {
		 $monthString = "Invalid input!";
	  }
   }
   else{
	  $monthString = null;
	  if($intMonth == 1)
	  {
		 $monthString = "I";
	  }
	  else if($intMonth == 2)
	  {
		 $monthString = "II";
	  }
	  else if($intMonth == 3)
	  {
		 $monthString = "III";
	  }
	  else if($intMonth == 4)
	  {
		 $monthString = "IV";
	  }
	  else if($intMonth == 5)
	  {
		 $monthString = "V";
	  }
	  else if($intMonth == 6)
	  {
		 $monthString = "VI";
	  }
	  else if($intMonth == 7)
	  {
		 $monthString = "VII";
	  }
	  else if($intMonth == 8)
	  {
		 $monthString = "VIII";
	  }
	  else if($intMonth == 9)
	  {
		 $monthString = "IX";
	  }
	  else if($intMonth == 10)
	  {
		 $monthString = "X";
	  }
	  else if($intMonth == 11)
	  {
		 $monthString = "XI";
	  }
	  else if($intMonth == 12)
	  {
		 $monthString = "XII";
	  }
	  else
	  {
		 $monthString = "Invalid input!";
	  }
   }
   return $monthString;
}
function date_convertmonth2($intMonth)
{
   $monthString = null;
   if($intMonth == "01")
   {
	  $monthString = "Januari";
   }
   else if($intMonth == "02")
   {
	  $monthString = "Februari";
   }
   else if($intMonth == "03")
   {
	  $monthString = "Maret";
   }
   else if($intMonth == "04")
   {
	  $monthString = "April";
   }
   else if($intMonth == "05")
   {
	  $monthString = "Mei";
   }
   else if($intMonth == "06")
   {
	  $monthString = "Juni";
   }
   else if($intMonth == "07")
   {
	  $monthString = "Juli";
   }
   else if($intMonth == "08")
   {
	  $monthString = "Agustus";
   }
   else if($intMonth == "09")
   {
	  $monthString = "September";
   }
   else if($intMonth == 10)
   {
	  $monthString = "Oktober";
   }
   else if($intMonth == 11)
   {
	  $monthString = "November";
   }
   else if($intMonth == 12)
   {
	  $monthString = "Desember";
   }
   else
   {
	  $monthString = "Invalid input!";
   }
   
   return $monthString;
}

