<?php
	/**
	 * member object
	 */
	Class Member extends Database {
		// databse connect and database name
		protected $name;
		protected $email;
		protected $admin_id;
		protected $user_id;
		protected $created;

		function name($val) {
			$val = mysqli_escape_string($this->get_connection(), $val);
			$this->name = $val;
		}

		function email($val) {
			$val = mysqli_escape_string($this->get_connection(), $val);
			$this->email = $val;
		}

		function user_id($val) {
			$val = mysqli_escape_string($this->get_connection(), $val);
			$this->user_id = $val;
		}

		function admin_id($val) {
			$val = mysqli_escape_string($this->get_connection(), $val);
			$this->admin_id = $val;
		}

		function created($val) {
			$val = mysqli_escape_string($this->get_connection(), $val);
			$this->created = $val;
		}


		// delete member
		function delete() {
			// query
			$query = "UPDATE `user` SET `created`= '".$this->created."' WHERE `user_id` = ".$this->user_id;
			return mysqli_query($this->get_connection(), $query);
		}

		function read() {
			// query 
			$query = "SELECT * FROM `user`";
			$query_statement = mysqli_query($this->get_connection(), $query);
			return $query_statement;
		}


		function check_exist() {
			// query 
			$query = "SELECT `created` FROM `user` WHERE `created` = '0000-00-00' AND `user_id` = ".$this->user_id;
			$query_statement = mysqli_query($this->get_connection(), $query);
			$check = mysqli_num_rows($query_statement);
			return $check;
		}

		function check_access() {
			// query 
			$query = "SELECT `kinds` FROM `admin` WHERE `admin_id` = '".$this->admin_id."'";
			$query_statement = mysqli_query($this->get_connection(), $query);
			$row = mysqli_fetch_array($query_statement);
			return $row['kinds'];
		}
	}
?>