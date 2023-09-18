<?php
function pricetypeToString($priceTypeId)
{
   if($priceTypeId == 1)
   {
      echo "Harian";
   }
   else if($priceTypeId == 2)
   {
      echo "Mingguan";
   }
   else if($priceTypeId == 3)
   {
      echo "Bulanan";
   }
   else if($priceTypeId == 4)
   {
      echo "Per 3 Bulan";
   }
   else if($priceTypeId == 5)
   {
	  echo "Per 6 Bulan";
   }
   else if($priceTypeId == 6)
   {
	  echo "Tahunan";
   }
   else
   {
      echo "NaN";
   }
}
