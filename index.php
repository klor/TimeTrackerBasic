<?php

// CONFIG

$config = parse_ini_file('config.ini');
extract($config);

// House-keeping

date_default_timezone_set($timezone);

if( ! is_dir($folder) ) {
	mkdir($folder);
}

// Open log file

$file = sprintf('%s/%s.%s', rtrim($folder,'/'), date("Y\wW", time()), $file_ext );
$fp = fopen($file, "a+");

$out[] = date("Ymd-Hi", time() );

if( php_sapi_name()=='cli' ) {
	// CLI request
	array_shift($argv);
	$q = implode($argv,' ');

	if(count($argv)>1 && function_exists($argv[0])) {
		// Append any call to a user-defined function (if function exists)
		$args = array_slice($argv,1);
		$out[] = call_user_func_array($argv[0], $args);
	} else if($q) {
		// Append the original string (if string was entered)
		$out[] = trim($q);
	}

} else if(isset($_SERVER['QUERY_STRING'])) {
	// Web request
	$t = str_replace("+","%2B", $_SERVER['QUERY_STRING'] );
	$t = utf8_decode( urldecode($t) );
	$t = str_replace("\"", "\\\"", $t);
	$out[] = $t;
}

fputcsv($fp,$out);
fclose($fp);

/*
	Hooks are added here
*/

function hello($name="World") {
	return "Greetings $name!, from Timesheet Basic.";
}
