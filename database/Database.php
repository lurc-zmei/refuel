<?php

namespace Database;


class Database
{

	private $connect;

	//public function __construct($name, $server = 'localhost', $user = 'root', $password = '') {
	public function __construct($db) {
		$this->connect = mysqli_connect($db['HOST'], $db['USERNAME'], $db['PASSWORD'], $db['DATABASE']);

	}


	public function query($query) {
		return mysqli_query($this->connect, $query);
	}

	
	// TODO: сократить implode, foreach
	public function chain($array, $flag) {
		switch ($flag) {
			// для Insert
			case 'column':
				foreach ($array as $key => $value) {
					$quoted_keys[] = "`$key`";
				}
				$chain = implode(", ", array_values($quoted_keys));
				break;

			case 'create_values':
				foreach ($array as $key => $value) {
					$quoted_values[] = "'$value'";
				}
				$chain = implode(", ", array_values($quoted_values));
				break;

			case 'read_values':
				foreach ($array as $key => $value) {
					$quoted_values[] = "`$value`";
				}
				$chain = implode(", ", array_values($quoted_values));
				break;
		
			case 'where':
				foreach($array as $key => $value) {
					$where_chain[] = "`$key`='$value'";
				}
				$chain = "WHERE " . implode(' AND ', $where_chain);
				break;

			case 'set':
				foreach ($array as $key => $value) {
					$fieldList_str[] = "`$key`='$value'";
				}
				$chain = implode(', ', $fieldList_str);
				break;
		}


		return $chain;
	}


	public function create($tableName, $fieldList) {
		$queryResult = $this->query("INSERT INTO `$tableName`({$this->chain($fieldList, 'column')}) VALUES ({$this->chain($fieldList, 'create_values')});");
		
		return mysqli_insert_id($this->connect);
	}


	public function read($tableName, $column = '*', $where = [], $sort_column = []) {

		
		
		if (is_array($column)) {
			// `name`, `wallet`

			$column[] = 'id';
			//$id = ['id'];
			//$column = array_flip(array_merge($id, $column));

			$column = $this->chain($column, 'read_values');
			//$column = $this->chain($column, 'column');
		}

		//WHERE `name`='lada' AND `wallet`=100
		$where_chain = $where ? [] : '';
		if (is_array($where_chain)) {
			$where_chain = $this->chain($where, 'where');
		}


		//ORDER BY `id` DESC
		$sort_chain = $sort_column ? [] : '';
		if (!empty($sort_column)) {
			$sort_chain = " ORDER BY `" . array_key_first($sort_column) . "`" . $sort_column[array_key_first($sort_column)];
		}


		$queryResult = $this->query("SELECT $column FROM `$tableName` $where_chain $sort_chain");
		
		while($row = mysqli_fetch_assoc($queryResult)){
			$result[$row['id']] = $row;
		}

		return $result;
	}


	public function update($id, $tableName, $fieldList) {
		$queryResult = $this->query("UPDATE `$tableName` SET {$this->chain($fieldList, 'set')} WHERE `id`=$id");
		
		return $queryResult;
	}


	public function delete($id, $tableName) {
		$queryResult = $this->query("DELETE FROM `$tableName` WHERE `id`=$id");
		return $queryResult;
	}



}