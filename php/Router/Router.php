<?php

namespace Router;

use \API\AccessToken;
use \Controller\OauthController;

class Router
{
	public function handle($url = false)
	{
		if (!$url) {
			$url = $_SERVER['REQUEST_URI'];
		}

		$info = parse_url($url);

		$path = $info['path'];
		$path = preg_replace("/\/$/", "", $path);
		$path = $path ?: "/";

		parse_str($info['query'], $query);

		switch ($path) {
			case '/oauth2': $this->oauth($query); break;
			default: return self::error();
		}
	}

	protected function oauth($query)
	{
		$user_id = $timestamp = $site_id = $hmac = $callback_url = $authorization_code = false;
		extract($query, EXTR_IF_EXISTS);

		$controller = new OauthController();
		if ($hmac) {
			$controller->requestScope($user_id, $site_id, $timestamp, $hmac, $callback_url);
		} else if ($authorization_code) {
			$controller->requestAccess($user_id, $site_id, $authorization_code, $callback_url);
		} else {
			self::error("invalid oauth request", 400);
		}
	}

	public static function redirect($url) {
		if (defined('OAUTH_TEST') && OAUTH_TEST) {
			echo "<a href='$url'>$url</a>";
		} else {
			header("Location: $url");
		}
		exit;
	}

	public static function error($msg = "Not Found", $code = 404)
	{
		switch ($code) {
			case 400: header("HTTP/1.1 400 Bad Request"); break;
			case 417: header("HTTP/1.1 417 Expectation Failed"); break;
			default: header("HTTP/1.1 404 Not Found"); break;
		}

		die($msg);
	}
}