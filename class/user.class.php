<?php

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
        //$escaped_user = $this->db->escape_string($username);
        //$result = $this->db->query();
		$this->user = $username;
		$this->usergroup = 2;
	}

	function login($username, $password) //this is the login. User can only exist if user exists..
	{
		if(!function_exists('pam_auth') && LOCAL) // here to simulate running on Dougal
		{
			function pam_auth($username, $password)
			{
				if ($username == 'dm1911' || $username == 'txl11')
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		}

		if (pam_auth($username, $password)) //check the password is right (pam_auth)
		{
			//check is the user has already completed?
			$this->authenticate($username);
			return true;
		}
		
		return false;
	}
}