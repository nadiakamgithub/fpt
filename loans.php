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
					<a href="suppliers.php"><li>Suppliers</li></a>
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
					<a href="suppliers.php"><li>Suppliers</li></a>
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
			<a href="payments.php" style="float: right;"><button class="submitBtn">Back to Payments</button></a>
			<p class="pageHeader">Farmers Loans information</p>
			<div class="wrapContent">
				<div class="allData" style="width: 100%;">
					<!-- <div class="searchSection">
						<form method="GET">
							<input type="text" name="keyCode" placeholder="Search" required>
							<button class="aprvbtn">Search</button>
						</form>
					</div> -->
					<div class="heading">All recorded farmers loans data</div>
					<table>
						<tr>
							<th></th>
							<th>Farmer's name</th>
							<th>National ID Card NO</th>
							<th>Phone number</th>
							<th>Amount</th>
							<th>Reason</th>
							<th>Status</th>
							<th>Date</th>
							<th></th>
						</tr>
						<?php
							if(isset($_GET['keyCode'])){
								$keyCode = $_GET['keyCode'];
								$query = mysqli_query($connect,"SELECT * FROM farmers WHERE deleted = 0 AND farmernames LIKE '%$keyCode%' OR idcard LIKE '%$keyCode%' OR phone LIKE '%$keyCode%' OR district LIKE '%$keyCode%' OR sector LIKE '%$keyCode%' ORDER BY farmernames ASC");
							}else{
								$query = mysqli_query($connect,"SELECT * FROM loan WHERE farmer ORDER BY id DESC");
							}
							$rowcount = 0;
							while ($row = mysqli_fetch_array($query)){
								$queryf = mysqli_query($connect,"SELECT * FROM farmers WHERE idcard = '".$row['farmer']."'");
								$rowf = mysqli_fetch_array($queryf);
								$rowcount ++;

								if($row['status'] == 0){
									$status = 'Pennding ...';
								}elseif($row['status'] == 1){
									$status = 'Approved';
								}elseif($row['status'] == 2){
									$status = 'Rejected';
								}

								echo "<tr>
									<td>".$rowcount."</td>
									<td>".$rowf['farmernames']."</td>
									<td>".$rowf['idcard']."</td>
									<td>".$rowf['phone']."</td>
									<td>".$row['amount']."</td>
									<td>".$row['reason']."</td>
									<td>".$status."</td>
									<td>".date('d/m/Y', $row['ldate'])."</td>";
									if($row['status'] == 0){
										echo"<td class='al-center' style='width: 150px;><div class='wrapContent'>
											<a href='server.php?approveLoan=".$row['id']."&farmer=".$row['farmer']."&amount=".$row['amount']."'><button class='aprvbtn'>Approve</button></a>
											<a href='server.php?rejectLoan=".$row['id']."&farmer=".$row['farmer']."'><button class='denybtn'>Reject</button></a>
										</div></td>";
									}else{
										echo"<td>".$status."</td>";
									}
								echo"</tr>";
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
function onlyAlphabets(e, t) {
    try {
        if (window.event) {
            var charCode = window.event.keyCode;
        }
        else if (e) {
            var charCode = e.which;
        }
        else { return true; }
        if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || charCode == 32)
            return true;
        else
            return false;
    }
    catch (err) {
        alert(err.Description);
    }
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