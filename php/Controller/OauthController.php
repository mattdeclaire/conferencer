<?php

namespace Controller;

use \Router\Router;
use \API\AccessToken;

class OauthController
{
	public function requestScope($user_id, $site_id, $timestamp, $hmac, $callback_url)
	{
		$string = http_build_query(compact('user_id', 'timestamp', 'site_id'));
		$hash = hash_hmac('sha256', $string, WEEBLY_SECRET);

		if ($hash != $hmac) {
			Router::error("Invalid HMAC", 417);
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

		Router::redirect($url);
	}

	public function requestAccess($user_id, $site_id, $authorization_code, $callback_url)
	{
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

		Router::redirect($callback_url);
	}
}