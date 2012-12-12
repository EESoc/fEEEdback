<?php

/* Code and Design created and managed by Dario Magliocchetti & Thomas Lim
 * Do not replicate, use or host any part of this code without prior permission.
 *
 * Project for GTA feedback within the department. To be used by EE1 and EE2.
 *
 * File: feedback.class.php
 * Use:
 *      Holds the class for the survey page - generates list of GTA data, and communicates to the db
 *
*/

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
        $details = array();
        while($row = $result->fetch_assoc())
        {
            $details[] = $row;
        }

        return $details;
    }

    function insert_results($data)
    {
        $values = NULL;
        foreach($data as $value)
        {
            $values = $values . "('$value[gtaid]', '$value[uname]', '$value[vote]', '$value[comment]', NOW()),";
        }
        $values = substr_replace($values,"", -1); // So we get rid of the last comma and have valid SQL syntax.
        $result = $this->db->query("INSERT INTO gta_feedback (gtaid, uname, vote, comment, submit_time) VALUES". $values);
        if(!$result)
        {
            $this->error = 'Something went wrong submitting the feedback. Database error'; //make a $this->error if you return false;
            return false;
        }
        return true;
    }
}