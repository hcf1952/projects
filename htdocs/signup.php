<?php 
session_start();
	include("connection.php");
	include("functions.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$user_name = $_POST['user_name'];
		$password = $_POST['password'];
		$email = $_POST['email'];

		if(!empty($user_name) && !empty($password) && !is_numeric($user_name) && !empty($email) && !preg_match("/[\'^£.:$/%`&*()}{@#~?><>,|=_+¬-]/", $user_name) && !preg_match("/[\'^`£$%&*.()/}{@:#~?><>,|=_+¬-]/", $password) && !preg_match("/[\'^£$%&*()`}/{#~?><>,|=+¬]/", $email))
		{

			//save to database
			$query = "select username from user where username = '$user_name' OR email = '$email'";
			$result = mysqli_query($con, $query);

			if(mysqli_num_rows($result) == 0)
			{
				$user_id = random_num(10);
				$query = "insert into user (userID,username,password,email) values ('$user_id','$user_name','$password','$email')";
				mysqli_query($con, $query);
			}
		
			else{
				echo '<script>alert("You already have an account");</script>';
			}
			
		}
		else{
			echo '<script>alert("Please enter some valid information!");</script>';
		}
	}
?>


<!DOCTYPE html>
<html>
 <head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
	
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">
	
	<link rel ="stylesheet" href="css/login_style.css">
	
	<title>COMP3421 Online Chatroom Sign Up</title>
	
 </head>
 <body> 
	<section id = 'login'>
		<div class ="bg-dark">
		<div class ="p-5">
			<div class = "container">
				<div class = "row">
				<div class = "mx-auto col-md-4 col-md-4 col-md-4">
					<h2>Sign Up</h2>
					<form method="post">
					<label for="fname">Username:</label><br>
					<input id="text" type="text" name="user_name"><br><br>
					<label for="fname">password:</label><br>
					<input id="text" type="password" name="password"><br><br>
					<label for="fname">email:</label><br>
					<input id="text" type="email" name="email"><br><br>

					<input id="button" type="submit" value="Signup"><br><br>

					<a href="index.html">go back to Login</a><br><br>
					</form>
				</div>
				</div>
			</div>
		</div>
		</div>
	</section>			
</body>
</html>
