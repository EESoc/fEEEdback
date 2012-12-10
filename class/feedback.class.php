<?php

class feedback
{
    function __construct($db)
    {
        $this->db = $db;
    }

    function getgta($group)
    {
        $result = $this->db->query("SELECT * FROM gta_gtas WHERE `group` = '$group'");
        
        if(!$result->num_rows)
        {
            $this->error = 'Uh oh, this group doesn\'t appear to exist'; //Really we shouldn't have any undefined groups...
            return false;
        }

        while($row = $result->fetch_assoc())
        {
            //array_push($list, $row['slug']);
            $row['image'] = $row['name'].'.png';
            $details[] = $row;
        }

        return $details;
    }

    function insert_results()
    {
        return true;

        //make a $this->error if you return false;

        foreach($data as $key => $value)
        {
            //$values = $values . "('$value[]', '$value[]', '$value[]', '$value[]'),";
        }
        $values = substr_replace($values,"", -1); // So we get rid of the last comma and have valid SQL syntax.
        //$values = "('3', 'txl11', '5', 'This guy is great')";
        //$result = $this->db->query("INSERT INTO gta_feedback (gtaid, uname, vote, comment) VALUES". $values);
        var_dump($result);
    }
}