<?php session_start();
	if (!isset($_SESSION['harvest_user'])) {
		echo"<script>window.location='index.php?error=login';</script>";
	}else{
		include('connector.php');
		$query = mysqli_query($connect,"SELECT * FROM users WHERE userid='".$_SESSION['harvest_user']."'");
		$row = mysqli_fetch_array($query);
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
					<a href="homepage.php"><li>Home</li></a>
					<a href="myorders.php"><li>Orders</li></a>
					<a href="stock.php"><li class="active">Stock status</li></a>
					<a href="change.php"><li>Change password</li></a>
					<a href="logout.php"><li>Logout</li></a>
				</ul>
			</div>
			<div class="naviSection">
				<ul>
					<a href="homepage.php"><li>Home</li></a>
					<a href="myorders.php"><li>Orders</li></a>
					<a href="stock.php"><li class="active">Stock status</li></a>
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
			<p class="pageHeader">Stock status information</p>
			<div class="wrapContent">
				<div class="allData" style="width: 100%;">
					<div class="heading">All recorded products data</div>
					<table>
						<tr>
							<th></th>
							<th>Product name</th>
							<th>Price / Frw</th>
							<th>Stock /Kgs</th>
						</tr>
						<?php
							$query = mysqli_query($connect,"SELECT * FROM product WHERE deleted = 0 ORDER BY productname ASC");
							$rowcount = 0;
							while ($row = mysqli_fetch_array($query)){
								$rowcount ++;
								echo "<tr>
									<td>".$rowcount."</td>
									<td>".$row['productname']."</td>
									<td>".$row['sprice']."</td>
									<td>".$row['stock']."</td>
								</tr>";
							}
						?>
					</table>
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