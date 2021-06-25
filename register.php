<?php
require_once "pdo.php";
session_start();

if (isset($_POST['register'])) {
	unset($_SESSION['name']);
	unset($_SESSION['username']);
  unset($_SESSION['position']);
	unset($_SESSION['password']);
  unset($_SESSION['cPassword']);

	$name = htmlentities($_POST['name']);
	$username = htmlentities($_POST['username']);
  $position = htmlentities($_POST['position']);
	$password = htmlentities($_POST['password']);
  $cPassword = htmlentities($_POST['cPassword']);

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
		$password1 = hash('md5', $password);

		$_SESSION['name'] = $name;
		$_SESSION['username'] = $username;
    $_SESSION['position'] = $position;
		$_SESSION['password'] = $password;
    $_SESSION['cPassword'] = $cPassword;

		$stmt = $pdo->prepare('INSERT INTO users
      (name, username, position, password) VALUES ( :name, :username, :position, :password)');
      $stmt->execute(array(
        ':name' => $name,
        ':username' => $username,
        ':position' => $position,
        ':password' => $password1)
    );
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

        <form method = "post" action = "register.php">
          <label for = "name"><b>Name</b></label>
          <input class = "form-control" minlength = "3" name = "name" placeholder ="Name..."><br>
          <label for = "name"><b>Username</b></label>
          <input class = "form-control" minlength = "3" name = "username" placeholder ="Username..."><br>
          <label for = "name"><b>Position</b></label>
          <input class = "form-control" name = "position" placeholder ="Position..."><br>
          <label for = "name"><b>Password</b></label>
          <input class = "form-control" minlength = "5" name = "password" type ="password" placeholder = "Password..."><br>
          <label for = "name"><b>Confirm Password</b></label>
          <input class = "form-control" minlength = "5" name = "cPassword" type ="password" placeholder = "Confirm Password..."><br>
          <input class = "btn btn-primary" name = "register" type = "submit" value = "Register..."><br>
					<p>Already have account? <a href="login.php">Log In</a></p>
					<!-- <input class = "btn btn-primary" name = "cancel" type = "cancel" value = "Cancel"><br> -->

        </form>
      </div>
    </div>
  </div>
</body>
</html>
