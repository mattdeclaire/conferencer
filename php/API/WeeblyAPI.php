<?php

namespace API;

class WeeblyAPI
{
	protected $user_id;
	protected $site_id;
	protected $access_token;

	public function __construct($user_id, $site_id)
	{
		$access_token = AccessToken::find($user_id, $site_id);
		if ($access_token) {
			$this->user_id = $user_id;
			$this->site_id = $site_id;
			$this->access_token = $access_token->access_token;
		}
	}

	private function call($method, $endpoint, $params = [])
	{
		$domain = defined('TEST_API_DOMAIN') ? TEST_API_DOMAIN : 'https://api.weebly.com';
		$json = $method("$domain/v1/$endpoint", $params, [
			'X-Weebly-Access-Token' => $this->access_token,
			'Accept' => 'application/vnd.weebly.v1+json',
		]);

		return json_decode($json);
	}

	public function get($endpoint, $params = [])
	{
		return $this->call('get', $endpoint, $params);
	}

	public function post($endpoint, $params = [])
	{
		return $this->call('post', $endpoint, $params);
	}
}