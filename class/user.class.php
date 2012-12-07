<?php

class user
{
	function __construct($user = null)
	{
		if ($user != null) //this is not checked for being correct - data taken from session
		{
			$this->authenticate($user);
		}
	}

	function authenticate($username)
	{
		$this->user = $username;
		$this->usergroup = 2;
	}

	function login($username, $password) //this is the login. User can only exist if user exists..
	{
		if ($username == 'dm1911') //check the password is right
		{
			$this->authenticate($username);
			return true;
		}
		
		return false;
	}
}