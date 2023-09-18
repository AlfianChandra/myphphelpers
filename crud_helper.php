<?php

function crud_join_where($tbLeft,$tbRight,$tbLeftCol,$tbRightCol,$cond,$col = NULL)
{
    $ci = get_instance();
    if($col == NULL)
    {
        $query = "SELECT * FROM $tbLeft LEFT JOIN $tbRight ON $tbLeft.$tbLeftCol = $tbRight.$tbRightCol WHERE $cond";
        $execute = $ci->db->query($query);

        //Returns
        $data['single'] = $execute->row();
        $data['multi'] = $execute->result();
        $data['count'] = $execute->num_rows();
        return $data;
    }
    else
    {
        $query = "SELECT $col FROM $tbLeft LEFT JOIN $tbRight ON $tbLeft.$tbLeftCol = $tbRight.$tbRightCol WHERE $cond";
        $execute = $ci->db->query($query);

        //Returns
        $data['single'] = $execute->row();
        $data['multi'] = $execute->result();
        $data['count'] = $execute->num_rows();
        return $data;
    }
}

function truncate_table($table)
{
	$ci = get_instance();
	$query = "TRUNCATE TABLE $table";
	$execute = $ci->db->query($query);
	return $execute;
}

function crud_selwhere($table,$clause,$col = NULL)
{
    $ci = get_instance();
    if($col == NULL)
    {
        $query = "SELECT * FROM $table WHERE $clause";
        $execute = $ci->db->query($query);

        //Returns
        $data['single'] = $execute->row();
        $data['multi'] = $execute->result();
        $data['count'] = $execute->num_rows();

        return $data;
    }
    else
    {
        $query = "SELECT $col FROM $table WHERE $clause";
        $execute = $ci->db->query($query);

        //Returns
        $data['single'] = $execute->row();
        $data['multi'] = $execute->result();
        $data['count'] = $execute->num_rows();

        return $data;
    }
}

function crud_limitselect($table,$clause,$orderby,$sort,$limit)
{
    $ci = get_instance();
    $query = "SELECT * FROM $table WHERE $clause ORDER BY $orderby $sort LIMIT $limit";
    $execute = $ci->db->query($query);

    //Returns
    $data['single'] = $execute->row();
    $data['multi'] = $execute->result();
    $data['count'] = $execute->num_rows();

    return $data;
}

function crud_select($table,$col = NULL)
{
    $ci = get_instance();
    if($col == NULL)
    {
        $query = "SELECT * FROM $table";
        $execute = $ci->db->query($query);

        //Returns
        $data['single'] = $execute->row();
        $data['multi'] = $execute->result();
        $data['count'] = $execute->num_rows();

        return $data;
    }
    else
    {
        $query = "SELECT $col FROM $table";
        $execute = $ci->db->query($query);

        //Returns
        $data['single'] = $execute->row();
        $data['multi'] = $execute->result();
        $data['count'] = $execute->num_rows();

        return $data;
    }
}

function crud_insert($table,$values)
{
    $ci = get_instance();
    $query = "INSERT INTO $table VALUES ($values)";
    $execute = $ci->db->query($query);
    return $execute;
}

function crud_delete($table,$clause = NULL)
{
    $ci=get_instance();
    if($clause == NULL)
    {
        $query = "DELETE FROM $table";
    }
    else
    {
        $query = "DELETE FROM $table WHERE $clause";
    }

    $execute = $ci->db->query($query);
    return $execute;
}

function crud_update($table,$value,$clause = NULL)
{
    $ci = get_instance();
    if($clause == NULL)
    {
        $query = "UPDATE $table SET $value";
    }
    else
    {
        $query = "UPDATE $table SET $value WHERE $clause";
    }

    $execute = $ci->db->query($query);
    return $execute;
}

function crud_insertadv($table,$data)
{
   $array = ["nama"=>"blabla"];
   $array = ["nim"=>"blabla"];
   $ci = get_instance();
   $strKey = null;
   $strVal = null;
   $arrKey = array_keys($data);
   foreach($arrKey as $f)
   {
	  $strKey .= $f.",";
   }

   foreach($data as $val)
   {
	  $strVal .= "'".$val."',";
   }
   $strKey = rtrim($strKey,", ");
   $strVal = rtrim($strVal,", ");

   $query = "INSERT INTO $table ($strKey) VALUES ($strVal)";
   $execute = $ci->db->query($query);
   return $execute;
}

function crud_search($table,$col,$key)
{
    $ci=get_instance();
    $query = "SELECT * FROM $table WHERE $col LIKE '%$key%'";
    $execute = $ci->db->query($query);

    //Returns
    $data['single'] = $execute->row();
    $data['multi'] = $execute->result();
    $data['count'] = $execute->num_rows();
}
