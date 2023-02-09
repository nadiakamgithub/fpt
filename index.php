<!DOCTYPE html>
<html>
<head>
	<title>FPTS</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="icon" type="image/png" href="images/logo.png">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<div class="bodySection">
		<div class="indexLogoSection">
			<center>
				<img src="images/logo.png" class="indexLogo">
				<p class="proName">Farmers Payments Tracking System</p>
			</center>
		</div>
		<div class="logInSection">
			<div class="heading">Login Here</div>
			<?php
				if (isset($_GET['error'])) {
					$error = $_GET['error'];

					if ($error == 'invalid') {
						echo"<p class='errorMsg'>Invalid username or password!</p>";
					} elseif ($error == 'login') {
						echo"<p class='errorMsg'>A login is needed to continue!</p>";
					} elseif ($error == 'invalidUserType') {
						echo"<p class='errorMsg'>No user type selected!</p>";
					}
				}
			?>
			<form method="POST" action="server.php">
				<input class="textInput" type="text" name="username" required="" placeholder="Username">
				<input class="textInput" type="password" name="password" required="" placeholder="Password">
				<select class="textInput" name="usertype" required="">
					<option value="0" disabled selected>Select user type</option>
					<option value="1">Admin</option>
					<option value="2">Customer</option>
					<option value="3">Farmer</option>
				</select>
				<div class="wrapContent">
					<button class="submitBtn" name="userlogin">Login</button>
					<a href="signup.php" style="position: relative;top: 5px;">Click here to signup</a>
				</div>
			</form>
		</div>
	</div>
</body>
</html>