<?php

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

	private function authenticate($username)
	{
        //$username = $this->db->escape_string($username);
        $result = $this->db->query("SELECT * FROM gta_users where uname = '$username'");
        if($result->num_rows)
        {
            $row = $result->fetch_assoc();
            if($row['completed'])
            {
                echo 'done survey';
                return false; //Here if they have already completed the survey
            }
            echo 'ready to survey';
            $this->usergroup = $row['labgroup'];        //We do this stuff now since they are allowed to do the survey
            $this->user = $username;
            $names = ldap_get_names($username);
            $this->fname = $names[0];
            return true;
        }
        else
        {
            echo 'not eligible to do survey';
            return false; //Here because they aren't in the DB and hence not eligible to provide feedback.
        }

	}

	function login($username, $password) //this is the login. User can only exist if user exists..
	{


		if (pam_auth($username, $password)) //check the password is right (pam_auth)
		{
			//check is the user has already completed?
			$this->authenticate($username);
			return true;
		}
		
		return false;
	}

    function completed_survey() //Sets the user as having completed the survey (when they are done). Should only be here if they have logged in, were eligible and submitted feedback.
    {
        $result = $this->db->query("UPDATE gta SET completed=1
                                        WHERE uname='$this->user'");
        if(!$result->num_rows)
        {
            echo 'Something went badly wrong here...';
        }
    }
}