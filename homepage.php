<?php session_start();
	if (!isset($_SESSION['harvest_user'])) {
		echo"<script>window.location='index.php?error=login';</script>";
	}else{
		include('connector.php');
		$query = mysqli_query($connect,"SELECT * FROM suppliers WHERE supplierid='".$_SESSION['harvest_user']."'");
		$row = mysqli_fetch_array($query);
		$userInfo = $row['suppliernames'];
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>FPTS</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
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
					<a href="homepage.php"><li class="active">Home</li></a>
					<a href="myorders.php"><li>Orders</li></a>
					<a href="stock.php"><li>Stock status</li></a>
					<a href="change.php"><li>Change password</li></a>
					<a href="logout.php"><li>Logout</li></a>
				</ul>
			</div>
			<div class="naviSection">
				<ul>
					<a href="homepage.php"><li class="active">Home</li></a>
					<a href="myorders.php"><li>Orders</li></a>
					<a href="stock.php"><li>Stock status</li></a>
					<a href="change.php"><li>Change password</li></a>
					<a href="logout.php"><li>Logout</li></a>
				</ul>
			</div>
			<div class="proTitle">
				<img src="images/logo-tr.png" class="proLogo">
				<p class="proName">Farmers Payments Tracking System</p>
			</div>
		</div>
		<div class="contentSection">
			<div class="wecomeNote"><center>
				<img src="images/logo-tr.png">
				<p class="caption">Welcome to<br>Farmers Payments Tracking System.</p>
				<p class="userInfo">You logged in as <?php echo $userInfo; ?></p>
			</center></div>
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