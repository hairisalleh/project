<?php
require_once "pdo.php";
session_start();

if (isset($_POST['register'])) {
	unset($_SESSION['username']);
	unset($_SESSION['password']);


	$username = htmlentities($_POST['username']);
	$password = htmlentities($_POST['password']);

	if(empty($_POST["username"]) && empty($_POST["password"])){
		// $_SESSION['failure'] = "All fields must filled";
		// header('Location: register.php');
		// return;
		echo '<script>alert("All fields must be filled")</script>';
  }
//required user to put same password
	elseif ($password != $cPassword) {
		$_SESSION['failure']  = "Password didn't matched";
		header('Location: register.php');
		return;
	}
  else {
		//utk secure password dkt database
		$password1 = password_hash($password, PASSWORD_BCRYPT);

		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;

		$stmt = $pdo->prepare('SELECT username, password FROM users');
      $stmt->execute();
    	$_SESSION['success'] = "Registration Done";
    	header('Location:register.php'); // register tukar jadi login.php
    	return;
	}
}

?>

<!DOCTYPE html>
<html lang = "en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Register Form</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>

  <div class = "container" style = "margin-top: 100px;">
    <div class = "row justify-content-center">
      <div class = "col-md-6 col-md-offset-3" align = "center">
        <h1>Registration Form</h1>
        <p>Please fill in this form to create an account</p>
        <?php
            if ( isset($_SESSION["success"]) ) {
            	echo('<p style="color:green">'.htmlentities($_SESSION["success"])."</p>\n");
            	unset($_SESSION["success"]); //unsets the variable
            }
            if (isset($_SESSION['failure']) ) {
                echo('<p style="color:red">'.htmlentities($_SESSION['failure'])."</p>\n");
                unset($_SESSION['failure']); //unsets the variable
            }
			 ?>

        <form method = "post" action = "login.php">
          <label for = "name"><b>Username</b></label>
          <input class = "form-control" minlength = "3" name = "username" placeholder ="Username..."><br>
          <label for = "name"><b>Password</b></label>
          <input class = "form-control" minlength = "5" name = "password" type ="password" placeholder = "Password..."><br>
          <input class = "btn btn-primary" name = "login" type = "submit" value = "Log In"><br>
					<p>Create an account? <a href="register.php">Register Here</a></p>
					<!-- <input class = "btn btn-primary" name = "cancel" type = "cancel" value = "Cancel"><br> -->

        </form>
      </div>
    </div>
  </div>
</body>
</html>
