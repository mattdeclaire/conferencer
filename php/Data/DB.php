<?php

namespace Data;

use \PDO;

class DB
{
	protected $last_insert_id;

	protected function exec($sql/*, params, ...*/)
	{
		$params = func_get_args();
		$sql = array_shift($params);

		static $db;

		if (!$db) {
			$db = new PDO(
				'mysql:host='.DB_HOST.';dbname='.DB_NAME,
				DB_USER, DB_PASS
			);
		}

		$stmt = $db->prepare($sql);
		$stmt->execute($params);
		$this->last_insert_id = $db->lastInsertId();
		return $stmt;
	}

	public function get_insert_id()
	{
		return $this->last_insert_id;
	}

	public function query($sql/*, params, ...*/)
	{
		$stmt = call_user_func_array(
			[$this, 'exec'],
			func_get_args()
		);

		return $stmt->errorCode() == '00000';
	}

	public function get($sql/*, params, ...*/)
	{
		$stmt = call_user_func_array(
			[$this, 'exec'],
			func_get_args()
		);

		return $stmt->fetch(PDO::FETCH_OBJ);
	}

	public function getOne($sql/*, params, ...*/)
	{
		$stmt = call_user_func_array(
			[$this, 'exec'],
			func_get_args()
		);

		return $stmt->fetchColumn();
	}

	public function insert($table, $properties)
	{
		$keys = implode(', ', array_keys($properties));
		$qmarks = implode(', ', array_fill(0, count($properties), '?'));
		$query = array_values($properties);
		array_unshift($query, "INSERT INTO $table ($keys) VALUES ($qmarks)");

		$success = call_user_func_array([$this, 'query'], $query);

		return $success ? $this->last_insert_id : false;
	}

	public function update($table, $where, $properties)
	{
		if (!$where || !$properties) {
			return false;
		}

		$sets = $this->equalGroup($properties);
		$wheres = $this->equalGroup($where);
		$query = array_merge(
			["UPDATE $table SET $sets WHERE $wheres"],
			array_values($properties),
			array_values($where)
		);

		return call_user_func_array([$this, 'query'], $query);
	}

	private function equalGroup($properties)
	{
		$pairs = [];
		foreach (array_keys($properties) as $property) {
			$pairs[] = "$property = ?";
		}
		return implode(', ', $pairs);
	}
}