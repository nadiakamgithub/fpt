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
					<a href="homepages.php"><li>Home</li></a>
					<a href="myharvest.php"><li class="active">Harvest</li></a>
					<a href="mypayments.php"><li>Payments</li></a>
					<a href="transfers.php"><li>Transfers</li></a>
					<a href="changes.php"><li>Change password</li></a>
					<a href="logout.php"><li>Logout</li></a>
				</ul>
			</div>
			<div class="naviSection">
				<ul>
					<a href="homepages.php"><li>Home</li></a>
					<a href="myharvest.php"><li class="active">Harvest</li></a>
					<a href="mypayments.php"><li>Payments</li></a>
					<a href="transfers.php"><li>Transfers</li></a>
					<a href="changes.php"><li>Change password</li></a>
					<a href="logout.php"><li>Logout</li></a>
				</ul>
			</div>
			<div class="proTitle">
				<img src="images/logo-tr.png" class="proLogo">
				<p class="proName">Farmers Payments Tracking System</p>
			</div>
		</div>
		<div class="contentSection">
			<p class="pageHeader">My harvest related data</p>
			<div class="wrapContent">
				<div class="allData" style="width: 100%;">
					<div class="heading">All recorded data</div>
					<table>
						<tr>
							<th></th>
							<th>Farmer's National ID Card NO</th>
							<th>Farmer's Names</th>
							<th>Product</th>
							<th>Quantity</th>
							<th>Unity price</th>
							<th>Total price</th>
							<th>Date</th>
						</tr>
						<?php
							$keyCode = $_SESSION['harvest_user'];
							$query = mysqli_query($connect,"SELECT * FROM harvests WHERE idcard = '$keyCode' ORDER BY harvestid DESC");
							$rowcount = 0;
							while ($row = mysqli_fetch_array($query)){
								$query1 = mysqli_query($connect,"SELECT * FROM farmers WHERE idcard='".$row['idcard']."'");
								$row1 = mysqli_fetch_array($query1);

								$queryProduct = mysqli_query($connect,"SELECT * FROM product WHERE productid='".$row['productid']."'");
								$rowProduct = mysqli_fetch_array($queryProduct);

								$rowcount ++;
								echo "<tr>
									<td>".$rowcount."</td>
									<td>".$row['idcard']."</td>
									<td>".$row1['farmernames']."</td>
									<td>".$rowProduct['productname']."</td>
									<td class='al-right'>".$row['qty']." ".$rowProduct['measurement']."</td>
									<td class='al-right'>".$row['up']." Frw</td>
									<td class='al-right'>".$row['tp']." Frw</td>
									<td class='al-right'>".$row['harvestDate']."</td>
								</tr>";
							}
						?>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript">
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".mobiNavButton").click(function(){
			$(".mobiNavMenu").toggleClass('mobiNavMenuActive');
		});
	});
</script>
</html>