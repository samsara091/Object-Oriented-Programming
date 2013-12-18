<?php
	session_start();
	require("connection.php");
?>
<html>
<head>
	<title>Country</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="index.css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
			$('#login_form').submit(function(){
				$.post(
					$(this).attr('action'), 
					$(this).serialize(),
					function(data){
						$('#container').html('');
						$('#user_info').html(data.users_html);
						$('#friends_info').html(data.friends_html);
						$('#welcome_info').html(data.welcome_html);
					}, 
					"json"
				);
				$('#logout').toggle("slow", function() {});
				return false;
			});
			$('#register_form').submit(function(){
				$.post(
					$(this).attr('action'), 
					$(this).serialize(),
					function(data){
						$('#container').html('');
						$('#user_info').html(data.users_html);
						$('#friends_info').html(data.friends_html);
						$('#welcome_info').html(data.welcome_html);
					}, 
					"json"
				);
				$('#logout').toggle("slow", function() {});
				return false;
			});
			$('#add_friend').submit(function(){
				$.post(
					$(this).attr('action'), 
					$(this).serialize(),
					function(data){
						$('#container').html('');
						$('#user_info').html(data.users_html);
						$('#friends_info').html(data.friends_html);
						$('#welcome_info').html(data.welcome_html);
					}, 
					"json"
				);
				return false;
			});
			$('#logout').toggle();
	});
	function addFriend(friend_id) {
		$('#add_friend').append("<input name='friend_id' type='hidden' value='" + friend_id + "'/>");
		$('#add_friend').submit();
	}

	</script>
</head>
<body>
	<div id="logout">
		<form id="logout_form" action="process.php" method="post">
			<input name="action" type="hidden" value="LOGOUT">
			<input type="submit" value="Logout">
		</form>
	</div>
	<div id="welcome_info">
	</div>
	<div id="friends_info">
	</div>
	<div id="user_info">
	</div>
	<div id = "container">
		<div id = "login">	
			<h2>Login</h2>
			<form id="login_form" action="process.php" method="post">
				Email: <input id="email_address_login" type="text" name="email_login" /><br/>
				Password: <input id="email_password_login" type="text" name="password_login" /><br/>
				<input name="action" type="hidden" value="LOGIN"/>
				<input id="login_button" type = 'submit' value ='Login'>
			</form>
		</div>
		<div id="register">
			<h2>Register</h2>
			<form id="register_form" action="process.php" method="post">
				First Name: <input id="first_name" type="text" name="first_name" /><br/>
				Last Name: <input id="last_name" type="text" name="last_name" /><br/>
				Email: <input id="email_address" type="text" name="email" /><br/>
				Password: <input id="email_password" type="text" name="password" /><br/>
				<input name="action" type="hidden" value="REGISTER"/>
				<input id="register_button" type = 'submit' value ='Register'>
			</form>
	 	</div>	
	</div>
	<form id="add_friend" action="process.php" method="post">
			<input name="action" type="hidden" value="ADD_FRIEND"/>
	</form> 
<?php 
	if(isset($_SESSION['add_note_err']))
		echo $_SESSION['add_note_err'];
	unset($_SESSION['add_note_err']);
?>
</body>
</html>
