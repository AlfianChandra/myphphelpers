<?php
function makeQueryFromArray($array,$remove = null,$operator = "AND")
{
    //These three needs to be ignored
    unset($array['token']);
    unset($array['usercode']);
    unset($array['authtoken']);

    //These is optional to be ignored
    if($remove != null)
    {
        $ct = count($remove);
        for($i = 0; $i < $ct;$i++)
        {
            $ignoreName = $remove[$i];
            unset($array[$ignoreName]);
        }
    }

    $len = count($array);
    $loopCount = 0;
    $q = "";
    foreach($array as $key => $val)
    {
        $loopCount++;
        if($loopCount != $len)
        {
            $q .= "$key = '$val' $operator ";
        }
        else{
             $q .= "$key = '$val'";
        }
    }
    return $q;
}