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

function post($url, $params = [], $headers = [])
{
	$curl = curl_init();

	$headerPairs = [];
	foreach ($headers as $key => $value) {
		$headerPairs[] = "$key: $value";
	}

	curl_setopt_array($curl, [
		CURLOPT_URL => $url,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => http_build_query($params),
		CURLOPT_HTTPHEADER => $headerPairs,
	]);

	$response = curl_exec($curl);

	curl_close($curl);

	return $response;
}