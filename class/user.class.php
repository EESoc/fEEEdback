<?php

/* Code and Design created and managed by Dario Magliocchetti & Thomas Lim
 * Do not replicate, use or host any part of this code without prior permission.
 *
 * Project for GTA feedback within the department. To be used by EE1 and EE2.
 *
 * File: user.class.php
 * Use:
 *      Holds the class for the user - contains functions to login, authorise the user
 *
*/

if(!function_exists('pam_auth') && LOCAL) // here to simulate running on Dougal
{
    function pam_auth($username, $password)
    {
        if ($username == 'dm1911' || $username == 'txl11' || $username == 'troll')
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

if(!function_exists('ldap_get_names') && LOCAL) // here to simulate running on Dougal
{
    function ldap_get_names($name)
    {
        $return = array(
                                0 => "Love",
                                1 => "Meister",
                            );
        return $return;
    }
}


class user
{

	function __construct($db ,$user = null)
	{
		$this->db = $db;
		if ($user != null) //this is not checked for being correct - data taken from session
		{
			$this->authenticate($user);
		}
	}

    function hasCompleted($gta_id) 
    {
        $result = $this->db->query("SELECT * FROM gta_chem_feedback where uname = '$username'");

    }

	private function authenticate($username)
	{
        //$username = $this->db->escape_string($username);
        $result = $this->db->query("SELECT * FROM gta_chem_users where uname = '$username'");
        if($result->num_rows)
        {
            $row = $result->fetch_assoc();
            
            $this->usergroup = $row['labgroup'];        //We do this stuff now since they are allowed to do the survey
            $this->user = $username;
            $names = ldap_get_names($username);
            $this->fname = $names[0];
            return true;
        }
        
        $this->login_error = 'Not elegible - Contact Bridge';
        return false; //Here because they aren't in the DB and hence not eligible to provide feedback.
	}

	function login($username, $password) //this is the login. User can only exist if user exists..
	{
		if (pam_auth($username, $password)) //check the password is right (pam_auth)
		{
			//check is the user has already completed?
			return ($this->authenticate($username));
		}
		$this->login_error = 'Wrong username/password combination.';
		return false;
	}
}

