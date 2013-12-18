<?php
require_once("connection.php");
require_once("HTML_Helper.php");
class User{
	var $FRIEND_TYPE = "Friend";
	var $USER_TYPE = "Add as a friend";
	var $user_id;
	var $first_name;
	var $last_name;
	var $users;
	var $email;
	function __construct() {
	}
	function get_user_by_id($id) {
		$valid_user=false;
		$query = "SELECT id,first_name,last_name,email FROM users where id=" . $id;
		$results = fetch_all($query);
		foreach ($results as $result) {
			$this->user_id = $result['id'];
			$this->first_name = $result['first_name'];
			$this->last_name = $result['last_name'];
			$this->email = $result['email'];
			$valid_user=true;
		}
		if ($valid_user) {
			$this->get_friends();
			$this->get_users();
		}
		return $valid_user;
	}
	function get_user($email, $password) {
		$query = "SELECT id,first_name,last_name FROM users where email='" . $email ."' and password='" . $password . "'" ;
		$results = fetch_all($query);
		$valid_user=false;
		foreach ($results as $result) {
			$this->user_id = $result['id'];
			$this->first_name = $result['first_name'];
			$this->last_name = $result['last_name'];
			$this->email = $email;
			$valid_user=true;
		}
		if ($valid_user) {
			$this->get_friends();
			$this->get_users();
		}
		return $valid_user;
	}
	function get_users() {
		$query = "SELECT * FROM users";
		$results = fetch_all($query);
		foreach ($results as $result) {
			if ((!isset($this->users[$result['id']])) && ($this->user_id != $result['id'])) {
				$this->users[$result['id']] = array("name"=> $result['first_name'] . " " . $result['last_name'], "email"=>$result['email'], "type"=>$this->USER_TYPE);
			}
		}
	}
	function get_friends() {
		$query = "SELECT * FROM users inner join friends on users.id=friends.friend_id where user_id = " . $this->user_id;
		$results = fetch_all($query);
		foreach ($results as $result) {
			$this->users[$result['id']] = array("name"=> $result['first_name'] . " " . $result['last_name'], "email"=>$result['email'], "type"=>$this->FRIEND_TYPE);
		}
	}
	function new_add_user($post, $array_of_fields)
	{
		if( $this->fields_are_set($post, $array_of_fields) && $this->fields_are_nonempty($post, $array_of_fields) )
		{
			$fields = implode(", ", $array_of_fields);
			$post_values = array();
			foreach ($array_of_fields as $field)
			{
				$post_values[] = "'".$post[$field]."'";
			}
			$values = implode(", ", $post_values);
			$query = "INSERT INTO users (".$fields.") VALUES (".$values.")";
			mysql_query($query);
			return TRUE;
		}
	}
	function fields_are_set($post, $array_of_fields)
	{
		// var_dump($post);
		foreach ($array_of_fields as $field)
		{
			if(!isset($post[$field]))
			{
				// echo "is not set";
				return false;
			}
		}
		return true;
	}
	function fields_are_nonempty($post, $array_of_fields)
	{
		foreach ($array_of_fields as $field)
		{
			if(empty($post[$field]))
			{
				// echo "is empty";
				return false;
			}
		}
		return true;
	}	
	function add_friend($friend_id)
	{
		$query = "INSERT INTO friends (user_id, friend_id) VALUES ('".$this->user_id."','".$friend_id."')";
		$results = mysql_query($query);
	}
}






















