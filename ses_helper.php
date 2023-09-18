<?php
function ses_set($key,$value)
{
    $ci = get_instance();
    $ci->session->set_userdata($key,$value); //All Set
}

function ses_get($key,$redirIfEmpty = NULL)
{
    $ci = get_instance();
    if($redirIfEmpty != NULL)
    {
        $ses = $ci->session->userdata($key);
        if(empty($ses))
        {
            redirect($redirIfEmpty);
        }else{
            return $ci->session->userdata($key);
        }
    }
    else{
        return $ci->session->userdata($key);
    }
}

function ses_unset($key,$redirTo = NULL)
{
    $ci = get_instance();
    if($redirTo != NULL)
    {
        $ci->session->unset_userdata($key);
        redirect($redirTo); //Controller > method
    }
    else{
        $ci->session->unset_userdata($key);
    }
}