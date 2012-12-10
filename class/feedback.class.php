<?php

class feedback
{
    function __construct($db)
    {
        $this->db = $db;
    }

    function insert_results()
    {
        foreach($data as $key => $value)
        {
            $values = $values . "('$value[]', '$value[]', '$value[]', '$value[]'),";
        }
        $values = substr_replace($values,"", -1); // So we get rid of the last comma and have valid SQL syntax.
        //$values = "('3', 'txl11', '5', 'This guy is great')";
        //$result = $this->db->query("INSERT INTO gta_feedback (gtaid, uname, vote, comment) VALUES". $values);
        var_dump($result);
    }
}