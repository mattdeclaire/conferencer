<?php

function debug() {
	echo "<pre>";
	foreach (func_get_args() as $arg) {
		echo htmlentities(print_r($arg, true));
	}
	echo "</pre>";
}

function vebug() {
	echo "<pre>";
	foreach (func_get_args() as $arg) {
		var_dump($arg);
	}
	echo "</pre>";
}

function curl($url, $opts = [], $headers = [])
{
	$curl = curl_init();

	$headerPairs = [];
	foreach ($headers as $key => $value) {
		$headerPairs[] = "$key: $value";
	}

	curl_setopt_array($curl, $opts + [
		CURLOPT_URL => $url,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER => $headerPairs,
	]);

	$response = curl_exec($curl);

	curl_close($curl);

	return $response;
}

function get($url, $params = [], $headers = [])
{
	return curl($url.'?'.http_build_query($params), [], $headers);
}

function post($url, $params = [], $headers = [])
{
	return curl($url, [
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => json_encode($params),
	], $headers);
}