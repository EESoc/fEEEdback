<?php

class gta
{
    function __construct($db)
    {
        $this->db = $db;
    }

    function listgtas($group)
    {
        $result = $this->db->query("SELECT * FROM gta_gtas WHERE ee_group = '$group'");
        if(!$result->num_rows)
        {
            echo 'Uh oh, this group doesn\'t appear to exist'; //Really we shouldn't have any undefined groups...
            return;
        }
        $list = array();
        $details = array();
        while($row = $result->fetch_assoc())
        {
            array_push($list, $row['slug']);
            $row['image'] = $row['slug'].'.png';
            array_push($details, $row);
        }
        $this->details = $details;
        $this->list = $list;
    }
}