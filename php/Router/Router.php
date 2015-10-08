<?php

namespace Router;

use \API\AccessToken;

class Router
{
	protected $path;
	protected $query;

	public function __construct($url = false)
	{
		if (!$url) {
			$url = $_SERVER['REQUEST_URI'];
		}

		$info = parse_url($url);

		$path = $info['path'];
		$path = preg_replace("/\/$/", "", $path);
		$path = $path ?: "/";
		$this->path = $path;

		parse_str($info['query'], $query);
		$this->query = $query;
	}

	public function handle()
	{
		switch ($this->path) {
			case '/oauth2': return $this->oauth2();
			default: return $this->notFound();
		}
	}

	protected function notFound()
	{
		header("HTTP/1.0 404 Not Found");
		echo "Not Found";
	}

	protected function oauth2()
	{
		$user_id = $timestamp = $site_id = $hmac = $callback_url = $authorization_code = false;
		extract($this->query, EXTR_IF_EXISTS);

		if ($hmac) {
			$string = http_build_query(compact('user_id', 'timestamp', 'site_id'));
			$hash = hash_hmac('sha256', $string, WEEBLY_SECRET);

			if ($hash != $hmac) {
				header("HTTP/1.0 417 Expectation Failed");
				echo "Invalid HMAC";
				return;
			}

			$scopes = [
				'read:site',
				'write:site',
			];

			$url = "$callback_url?".http_build_query([
				'client_id' => WEEBLY_CLIENT_ID,
				'user_id' => $user_id,
				'site_id' => $site_id,
				'scope' => implode(',', $scopes),
			]);

			$this->redirect($url);
		} else if ($authorization_code) {
			$response = post($callback_url, [
				'client_id' => WEEBLY_CLIENT_ID,
				'client_secret' => WEEBLY_SECRET,
				'authorization_code' => $authorization_code,
			]);

			$result = json_decode($response);

			$access_token = $result->access_token;
			$callback_url = $result->callback_url;

			$token = AccessToken::findOrCreate($user_id, $site_id);
			$token->access_token = $access_token;
			$token->save();

			$this->redirect($callback_url);
		} else {
			die('nope');
		}
	}

	protected function redirect($url) {
		if (defined('OAUTH_TEST') && OAUTH_TEST) {
			echo "<a href='$url'>$url</a>";
		} else {
			header("Location: $url");
		}
	}
}