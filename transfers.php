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
					<a href="myharvest.php"><li>Harvest</li></a>
					<a href="mypayments.php"><li>Payments</li></a>
					<a href="transfers.php"><li class="active">Transfers</li></a>
					<a href="changes.php"><li>Change password</li></a>
					<a href="logout.php"><li>Logout</li></a>
				</ul>
			</div>
			<div class="naviSection">
				<ul>
					<a href="homepages.php"><li>Home</li></a>
					<a href="myharvest.php"><li>Harvest</li></a>
					<a href="mypayments.php"><li>Payments</li></a>
					<a href="transfers.php"><li class="active">Transfers</li></a>
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
			<p class="pageHeader">Transfers related data</p>
			<div class="wrapContent">
				<div class="inputForm">
					<div class="heading">Add new transfer data</div>
					<?php
						if (isset($_GET['data'])) {
							$data = $_GET['data'];

							if ($data == 'success') {
								echo"<p class='errorMsg'>New transfer is added successfully.</p>";
							}
						}
					?>
					<form method="POST" action="server.php">
						<input type="text" name="phone" maxlength="10" minlength="10" onkeypress='return isNumber(event);' class="textInput" placeholder="Enter farmer's phone" required>
						<input type="text" name="amount" onkeypress='return isNumber(event);' class="textInput" placeholder="Amount" required>
						<button class="submitBtn" name="addnewTransfer">Add new</button>
					</form>
				</div>
				<div class="allData">

					<?php
						$myId = $_SESSION['harvest_user'];
						$queryBalance = mysqli_query($connect, "SELECT * FROM farmers WHERE idcard = '$myId'");
						$dataBalance = mysqli_fetch_array($queryBalance);
						echo"<p style='float:right; font-weight: bold;'>Active balance: ".$dataBalance['account']." Frw</p>";
					?>

					<div class="heading">All recorded transfers data</div>
					<table>
						<tr>
							<th></th>
							<th>Transaction Code</th>
							<th>Farmer's National ID Card NO</th>
							<th>Farmer's Names</th>
							<th>Account</th>
							<th>Amount</th>
							<th>Balance</th>
							<th>Date/Time</th>
						</tr>
						<?php
						$keyCode = $_SESSION['harvest_user'];
							$query = mysqli_query($connect,"SELECT * FROM transfers WHERE from_farmer = '$keyCode' ORDER BY id DESC");
							$rowcount = 0;
							while ($row = mysqli_fetch_array($query)){
								$query1 = mysqli_query($connect,"SELECT * FROM farmers WHERE idcard='".$row['to_farmer']."'");
								$row1 = mysqli_fetch_array($query1);
								$rowcount ++;
								echo "<tr>
									<td>".$rowcount."</td>
									<td>".$row['code']."</td>
									<td>".$row['to_farmer']."</td>
									<td>".$row1['farmernames']."</td>
									<td class='al-right'>".$row['from_account']." Frw</td>
									<td class='al-right'>".$row['amount']." Frw</td>
									<td class='al-right'>".$row['from_balance']." Frw</td>
									<td class='al-right'>".$row['trdate']."</td>
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