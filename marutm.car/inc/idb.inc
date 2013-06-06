<?php

/*
 * @project : marutm
 * @Title  : myslqi interface class
 * @Author : seosh81 <seosh81@gmail.com>
 * @date : 2013.03.12
 */

interface interface_mysqli {
	public function selectOne($q, $bind_types='', $p = array(), $replace='');
	public function selectCount($q, $bind_types='', $p = array(), $replace='');
	public function select($q, $bind_types='', $p = array(), $replace='');
	public function insert($q, $bind_types, $p = array(), $autocommit = false);
}

class idb implements interface_mysqli {
	public $log;
	public $mysqli;
	public $dbconf;
	public $error_msg;

	public function __construct() {
		
		// $this->log = new logger(_LOG_FILE);
		$this->dbconf = parse_ini_file(_DB_CONF_FILE);
		
		$this->mysqli = new mysqli($this->dbconf['host'], $this->dbconf['user'], 
			$this->dbconf['password'], $this->dbconf['db']);
		$this->mysqli->autocommit(TRUE);
		// $this->mysqli->query("set names euckr");
		if ($this->mysqli->connect_errno) {
 		   echo "Failed to connect to MySQL: " . $this->mysqli->connect_error;
		}

		$this->mysqli->set_charset("utf8");
	}

	private function query($q, $bind_types ='', $p = array(), $flag="list") {
		$result = array();
		$field_datas = array();
		$field_names = array();
		$tmp_result = array();

		$stmt = $this->mysqli->prepare($q);

		if (count($p) > 0) {
			$values = array();
			$values[] = $bind_types;

			if($p) {
				foreach($p as $key=>$value) {
					$values[] = &$p[$key];
				}
			}
			@$result = call_user_func_array(array($stmt, 'bind_param'), $values);
			if(!$result) {
				$this->error_msg = mysqli_error($this->mysqli);
				// $this->log->error("bind param error : ".$types."(".strlen($types).") ".print_r($p,true));

				return false;
			}			
		}

		if(!$stmt->execute()) {
			$this->error_msg = mysqli_error($this->mysqli);

			// $this->log->error("mysql exec error : ".$this->error_msg);
			
			return false;
		}

		if(!$stmt->store_result()){
			$this->error_msg = mysqli_error($this->mysqli);
			// $this->log->error("mysql exec error : ".$this->error_msg);
			
			return false;	
		}

		$metadata = $stmt->result_metadata();
		if (!$metadata) 
		{
			$this->error_msg = mysqli_error($this->mysqli);
			// $this->log->error("mysql exec error : ".$this->error_msg);
			$stmt->close();
			
			return false;	
			//return true;
		}

		$field_list = $metadata->fetch_fields();
		if($field_list) {
			foreach ($field_list as $field_info) {
				$field_datas[] = &$tmp_result[$field_info->name];
				$field_names[] = $field_info->name;
			}
		}

		//call_user_func_array(array($stmt, 'bind_result'), $field_datas);
		@$result = call_user_func_array(array($stmt, 'bind_result'), $field_datas);
		if(!$result) {
			$this->error_msg = mysqli_error($this->mysqli); 
			
			// $this->log->error("bind result error : ".$q."=>".print_r($field_datas,true));
			return false;
		}

		$cnt = 0;
		$result = array();
		while ($stmt->fetch()) {
			$field_cnt = 0;
			if($field_datas) {
				foreach($field_datas as $data) {
					if($flag == "count")		
						return $data;
					else if($flag == "list") {
						@$result[$cnt][$field_names[$field_cnt]] = $data;
					}
					else					
						@$result[$field_names[$field_cnt]] = $data;
	
					$field_cnt++;
				}
			}
			$cnt++;
			if($flag == "row") break;
		}
		$stmt->close();

		return ($cnt) ? $result : false;
	}

	public function selectOne($q, $bind_types='', $p = array(), $replace='') {
		return $this->query($q, $bind_types, $p, 'one');
	}

	public function selectCount($q, $bind_types='', $p = array(), $replace='') {
		return $this->query($q, $bind_types, $p, 'count');
	}

	public function select($q, $bind_types='', $p = array(), $replace='') {
		if ($replace != '') {
			$q = str_replace("#replace#", $replace, $q);
		}
		return $this->query($q, $bind_types, $p, 'list');
	}

	public function insert($q, $bind_types, $p = array(), $autocommit = true) {
		$this->affected_rows = -1;

		$result = array();
		$field_datas = array();
		$field_names = array();
		$tmp_result = array();

		// if(!$autocommit) $this->mysqli->autocommit(FALSE);

		$stmt = $this->mysqli->prepare($q);
		if(!$stmt) {
			$this->error_msg = mysqli_error($this->mysqli);
			// $this->log->error("prepared statements error : ".$q);
			return false;
		}

		if(count($p) > 0) {
			$values = array();
			$values[] = &$bind_types;
			if($p) {
				foreach($p as $key=>$value) {
					$values[] = &$p[$key];
				}
			}

			//call_user_func_array(array($stmt, 'bind_param'), $values);
			@$result = call_user_func_array(array($stmt, 'bind_param'), $values);
			if(!$result) {
				$this->error_msg = mysqli_error($this->mysqli);
				// $this->log->error("bind param error : ".$q."=>".$bind_types."(".strlen($bind_types).") ".print_r($p,true));
				return false;
			}				
		}

		if($stmt->execute())
		{
			// if($get_last_id)
			// {
			// 	$last_insert_id = mysqli_insert_id($this->mysqli);
			// 	// if($autocommit) {
			// 	// 	$this->mysqli->commit();
			// 	// }
			// 	$stmt->close();

			// 	return $last_insert_id; 				
			// }
			// else 
			// {
				$this->affected_rows = $this->mysqli->affected_rows;
				$this->mysqli->commit();
				// if($autocommit) {
				// 	$this->mysqli->commit();
				// }
				// error_log("id inserted!", 3, "/Users/seosh81/project/marutm/blog/crawling/insert.log");
				$stmt->close();
				return true;
			// }
		}
		else
		{
			$this->error_msg = mysqli_error($this->mysqli);
			// $this->log->error("mysqli exec error : ".$this->error_msg);
			// $this->mysqli->rollback();
			// error_log("error!!! ". $this->error_msg, 3, "/Users/seosh81/project/marutm/blog/crawling/insert.log");
			$stmt->close();
			
			return false;
		}
	}
}

?>