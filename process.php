<?php
session_start();
require_once("connection.php");
require_once("HTML_Helper.php");
require_once("User.php");
class Process{
	function __construct() {
	}
}
$user = new User();	
$html_helper = new HTML_Helper();
if ($_POST['action'] == "LOGIN") 
{
	$email_address = $_POST['email_login']; //"allabil@g.c";//$_POST['email_login']
	$password = $_POST['password_login'];   // "";
	if ($user->get_user($email_address,$password))
	{
		$_SESSION['id'] = $user->user_id;
		$welcome_html = $html_helper->print_welcome($user->first_name, $user->email);
		$friends_html = $html_helper->print_friends_table($user->users);
		$users_html   = $html_helper->print_users_table($user->users);
		$data['welcome_html'] = $welcome_html;
		$data['friends_html'] = $friends_html;
		$data['users_html']   = $users_html;
		echo json_encode($data);
	}
	else
	{
		unset($_SESSION['id']);
		echo json_encode("Add your information, please");
	}
}
else if ($_POST['action'] == "REGISTER") 
{
	$email_address = $_POST['email']; 
	$first_name = $_POST['first_name']; 
	$last_name = $_POST['last_name'];  
	if($user->new_add_user($_POST, array("first_name", "last_name", "email", "password")))
	{
		// $user = new User();
		$user->get_user($email_address,$_POST['password']);
		$_SESSION['user']['id'] = $user->user_id;
		$_SESSION['user']['first_name'] =$user->first_name;
		$_SESSION['user']['last_name'] =$user->last_name;
		$_SESSION['user']['email'] =$user->email;
		$welcome_html = $html_helper->print_welcome($user->first_name, $user->email);
		$users_html = $html_helper->print_users_table($user->users);
		$data['welcome_html'] = $welcome_html;
		$data['users_html']   = $users_html;
		echo json_encode($data);
	}
	else
	{
		unset($_SESSION['id']);
		echo json_encode("Add your information, please");
	}
}
else if ($_POST['action'] == "ADD_FRIEND")
{
	if (isset($_SESSION['id'])) 
	{
		$user->get_user_by_id($_SESSION['id']); // since they are logged in, get user Id from session
		$user->add_friend($_POST['friend_id']);
		$welcome_html = $html_helper->print_welcome($user->first_name, $user->email);
		$friends_html = $html_helper->print_friends_table($user->users);
		$users_html   = $html_helper->print_users_table($user->users);
		$data['welcome_html'] = $welcome_html;
		$data['friends_html'] = $friends_html;
		$data['users_html']   = $users_html;
		echo json_encode($data);
	}
	else
	{
		echo json_encode("Add your information, please");
	}
}
else {
	session_destroy();
	header('Location:index.php');
}
?>
