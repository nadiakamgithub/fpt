<?php session_start();
	if (!isset($_SESSION['harvest_user'])) {
		echo"<script>window.location='index.php?error=login';</script>";
	}else{
		include('connector.php');
	}
?>
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
		<div class="headerSection">
			<div class="mobiNavButton">
				<div></div>
				<div></div>
				<div></div>
			</div>
			<div class="mobiNavMenu">
				<ul>
					<a href="homepage.php"><li>Home</li></a>
					<a href="myorders.php"><li>Orders</li></a>
					<a href="stock.php"><li>Stock status</li></a>
					<a href="change.php"><li class="active">Change password</li></a>
					<a href="logout.php"><li>Logout</li></a>
				</ul>
			</div>
			<div class="naviSection">
				<ul>
					<a href="homepage.php"><li>Home</li></a>
					<a href="myorders.php"><li>Orders</li></a>
					<a href="stock.php"><li>Stock status</li></a>
					<a href="change.php"><li class="active">Change password</li></a>
					<a href="logout.php"><li>Logout</li></a>
				</ul>
			</div>
			<div class="proTitle">
				<img src="images/logo-tr.png" class="proLogo">
				<p class="proName">Farmers Payments Tracking System</p>
			</div>
		</div>
		<div class="contentSection">
			<p class="pageHeader">Change password</p>
			<div class="wrapContentAlt">
				<div class="inputForm">
					<div class="heading">Changing password here</div>
					<?php
						if (isset($_GET['data'])) {
							$data = $_GET['data'];

							if ($data == 'success') {
								echo"<p class='errorMsg'>New password is set successfully.</p>";
							} if ($data == 'invalid') {
								echo"<p class='errorMsg'>Invalid old password!</p>";
							}
						}
					?>
					<form method="POST" action="server.php">
						<input type="text" name="oldpass" class="textInput" placeholder="Old password" required>
						<input type="text" name="newpass" class="textInput" placeholder="New password" required>
						<button class="submitBtn" name="changepass">Save changes</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".mobiNavButton").click(function(){
			$(".mobiNavMenu").toggleClass('mobiNavMenuActive');
		});
	});
</script>
</html>