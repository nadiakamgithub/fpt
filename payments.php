<?php session_start();
	if (!isset($_SESSION['harvest_user'])) {
		echo"<script>window.location='index.php?error=login';</script>";
	}else{
		include('connector.php');
		$query = mysqli_query($connect,"SELECT * FROM users WHERE userid='".$_SESSION['harvest_user']."'");
		$row = mysqli_fetch_array($query);
		$userInfo = $row['username'];
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
					<a href="home.php"><li>Home</li></a>
					<a href="farmers.php"><li>Farmers</li></a>
					<a href="products.php"><li>Products</li></a>
					<a href="entries.php"><li>Entries</li></a>
					<a href="payments.php"><li class="active">Payments</li></a>
					<a href="suppliers.php"><li>Customers</li></a>
					<a href="orders.php"><li>Orders</li></a>
					<a href="logout.php"><li>Logout</li></a>
				</ul>
			</div>
			<div class="naviSection">
				<ul>
					<a href="home.php"><li>Home</li></a>
					<a href="farmers.php"><li>Farmers</li></a>
					<a href="products.php"><li>Products</li></a>
					<a href="entries.php"><li>Entries</li></a>
					<a href="payments.php"><li class="active">Payments</li></a>
					<a href="suppliers.php"><li>Customers</li></a>
					<a href="orders.php"><li>Orders</li></a>
					<a href="logout.php"><li>Logout</li></a>
				</ul>
			</div>
			<div class="proTitle">
				<img src="images/logo-tr.png" class="proLogo">
				<p class="proName">Farmers Payments Tracking System</p>
			</div>
		</div>
		<div class="contentSection">
			<a href="loans.php" style="float: right;"><button class="submitBtn">Loans</button></a>
			<p class="pageHeader">Payments related data</p>
			<div class="wrapContent">
				<div class="inputForm">
					<div class="heading">Add new payment data</div>
					<?php
						if (isset($_GET['data'])) {
							$data = $_GET['data'];

							if ($data == 'success') {
								echo"<p class='errorMsg'>New payment is added successfully.</p>";
							}
						}
					?>
					<form method="POST" action="server.php">
						<?php
							if(!isset($_GET['getPayment'])){
								echo"<select required name='idcard' class='textInput'>
									<option value='' selected='' disabled>Chose farmer name</option>";
									$query = mysqli_query($connect,"SELECT * FROM farmers WHERE deleted = 0 ORDER BY farmernames ASC");
									while ($row = mysqli_fetch_array($query)){
										echo "<option value='".$row['idcard']."'>".$row['farmernames']."</option>";
									}
								echo"</select>";
								echo"<button class='submitBtn' name='getPayment'>Get Payment</button>";
							}
						
							if(isset($_GET['getPayment'])){
								echo"<p>ID Card Number:</p>
									<input type='text' name='idcard' readonly value='".$_GET['idcard']."' class='textInput' required>
									<p>Full Names:</p>
									<input type='text' name='names' readonly value='".$_GET['names']."' class='textInput' required>
									<p>Amount:</p>
									<input type='text' name='amount' readonly value='";
									if($_GET['amount'] < 0){
										echo "Farmer named ".$_GET['names']." have a loan of ".$_GET['amount'];
									}else{
										echo $_GET['amount'];
									}
									echo" Frw' class='textInput' required>";
								if($_GET['amount'] > 0){	
									echo"<button class='aprvbtn' style='padding: 2px 5px; font-size: 16px; margin-right: 5px;' name='addnewPayment'>Confirm New Payment</button>";
								}

								echo"<a href='payments.php' class='denybtn'>Cancel Payment</a>";
							}
						?>
					</form>
				</div>
				<div class="allData">
					<div class="heading">All recorded payments data</div>
					<table>
						<tr>
							<th></th>
							<th>Transaction Code</th>
							<th>Farmer's NID card</th>
							<th>Farmer's Names</th>
							<th>Money on your Account</th>
							<th>Amount paid</th>
							<th>Main Balance</th>
							<th>Date/Time</th>
						</tr>
						<?php
							$query = mysqli_query($connect,"SELECT * FROM payments ORDER BY id DESC");
							$rowcount = 0;
							while ($row = mysqli_fetch_array($query)){
								$query1 = mysqli_query($connect,"SELECT * FROM farmers WHERE idcard='".$row['farmer']."'");
								$row1 = mysqli_fetch_array($query1);
								$rowcount ++;
								echo "<tr>
									<td>".$rowcount."</td>
									<td>".$row['code']."</td>
									<td>".$row['farmer']."</td>
									<td>".$row1['farmernames']."</td>
									<td class='al-right'>".$row['account']." Frw</td>
									<td class='al-right'>".$row['amount']." Frw</td>
									<td class='al-right'>".$row['balance']." Frw</td>
									<td class='al-right'>".$row['pdate']."</td>
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