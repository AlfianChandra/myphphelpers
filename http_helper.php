<?php
function securepost($value,$parsehtml = FALSE)
{
    $ci = get_instance();
    if($parsehtml == TRUE)
    {
        $vals = htmlspecialchars($ci->db->escape_str($ci->input->post($value)));
        return $vals;
    }
    else
    {
        $vals = $ci->db->escape_str($ci->input->post($value,TRUE));
        return $vals;
    }
}

function securepass($value)
{
    $md = md5($value);
    return $md;
}

function secureget($get,$parsehtml = FALSE)
{
    $ci = get_instance();
    $get = $ci->uri->segment($get);
    if($parsehtml == FALSE)
    {
        return htmlspecialchars($ci->db->escape_str($get));
    }
    else
    {
        return $ci->db->escape_str($get);
    }
}
