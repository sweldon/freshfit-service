<?php



function check_characters($str)
{
	if (!preg_match('/[^A-Za-z0-9_]/', $str)) // '/[^a-z\d]/i' should also work.
	{
	  return true;
	}

	return false;
}

function call_function($req)
{
	global $api;

	if(method_exists($api, $req[0]) && is_callable(array($api, $req[0])))
	{
		$api->$req[0]();
	}
	else
	{
		display(400, 'invalid request', '', 1);
	}
}

function get_request()
{
	$req_array = explode("/",$_SERVER['REQUEST_URI']);
	$req = array();

	$trigger = false;
	foreach($req_array as $r)
	{
		if($trigger  == true)
		{
			$req[] = $r;
		}

		if($r == "api")
		{
			$trigger = true;
		}
	}


	if(empty($req))
	{
		display(400, 'invalid request', '', 1);
	}

	return $req;
}


function display($code, $msg_code, $data, $exit = 0)
{
	global $req;

	$out_array = array();
	$out_array['response_code'] = $code;
	$out_array['response'] = $msg_code;

	if(isset($req[0]))
		$out_array['request'] = $req[0];

	if(!is_string ($data))
		$out_array['data'] = $data;

	$out = json_encode($out_array);

	$compression = 0;
	$os = "";


	if(isset($_POST['os']))
	{
		$os = $_POST['os'];
	}


	if(isset($_POST['c']))
	{
		$compression = $_POST['c'];
	}


	if ($compression == 0)
	{
		echo $out;
	}
	else
	{
		if( $os == 'android')
		{
			echo gzcompress($out,9);

		}

		if( $os == 'ios')
		{

			ini_set('zlib.output_compression','Off');

			$gzipoutput = gzencode(($out),9);

			header('Content-Type: application/x-download');
			header('Content-Encoding: gzip');
			header('Content-Length: '.strlen($gzipoutput));
			header('Content-Disposition: attachment; filename="data.dat"');

			echo ($gzipoutput);

		}
	}


	if($exit == 1)
	{
		exit();
	}
}
