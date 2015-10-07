<?php

namespace API;

use \Data\DB;

class AccessToken
{
	protected $id;
	public $user_id;
	public $site_id;
	public $access_token;

	public function __construct($user_id = false, $site_id = false, $access_token = false)
	{
		$this->user_id = $user_id;
		$this->site_id = $site_id;
		$this->access_token = $access_token;
	}

	public static function find($user_id, $site_id)
	{
		$db = new DB();

		$result = $db->get(
			"SELECT id, access_token
			FROM access_token
			WHERE user_id = ?
			AND site_id = ?
			ORDER BY updated_at DESC",
			$user_id,
			$site_id
		);

		if (!$result) {
			return false;
		}

		$access_token = new self($user_id, $site_id, $result->access_token);
		$access_token->id = $result->id;

		return $access_token;
	}

	public static function findOrCreate($user_id, $site_id)
	{
		return self::find($user_id, $site_id) ?: new self($user_id, $site_id);
	}

	public function save()
	{
		return $this->id ? $this->update() : $this->create();
	}

	public function create()
	{
		$db = new DB();

		$insert_id = $db->insert('access_token', [
			'user_id' => $this->user_id,
			'site_id' => $this->site_id,
			'access_token' => $this->access_token,
		]);

		if ($insert_id) {
			$this->id = $insert_id;
		}

		return (bool) $insert_id;
	}

	public function update()
	{
		$db = new DB();

		return $db->update('access_token', ['id' => $this->id], [
			'user_id' => $this->user_id,
			'site_id' => $this->site_id,
			'access_token' => $this->access_token,
		]);
	}

	public function delete()
	{
		$db = new DB();

		$success = $db->query(
			"DELETE FROM access_token
			WHERE id = ?",
			$this->id
		);

		$this->id = null;

		return $success;
	}
}