<?php

require_once("./config.php");
require_once("./mobile_functions.php");

global $req;global $api;

$api = new api();

$req = get_request();

call_function($req);



class api
{


function Login()
{
	global $req;

	if(!isset($_POST['username']) || !isset($_POST['password']))
	{
		display(400, 'invalid parameters', '', 1);
	}

	$email = trim($_POST['username']);
	$password = $_POST['password'];

	if(trim($email) == "")
	{
		display(400, 'invalid parameters', '', 1);
	}

	if(trim($password) == "")
	{
		display(400, 'invalid parameters', '', 1);
	}

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	 	display(400, 'invalid parameters', '', 1);
	}

	if($email == "try@me.com" && $password == "test")
	{
		display(200, 'OK', array('session'=>md5('k_blog_session')), 1);
	}
	else
	{
		display(530, 'not authenticated', '', 1);
	}
}






function CheckSession()
{
	global $req;

	if(!isset($_POST['session']))
	{
		display(400, 'invalid parameters', '', 1);
	}

	if(!check_characters($_POST['session']))
	{
		display(400, 'invalid parameters', '', 1);
	}

	if($_POST['session'] == md5('k_blog_session'))
	{
		display(200, 'OK', array("some_data"=>"valid request"), 1);
	}


	display(530, 'not authenticated', '', 1);




}



}
