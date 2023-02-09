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
					<a href="entries.php"><li class="active">Entries</li></a>
					<a href="payments.php"><li>Payments</li></a>
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
					<a href="entries.php"><li class="active">Entries</li></a>
					<a href="payments.php"><li>Payments</li></a>
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
			<p class="pageHeader">Entries related data</p>
			<div class="wrapContent">
				<div class="inputForm">
					<div class="heading">Add new entry data</div>
					<?php
						if (isset($_GET['data'])) {
							$data = $_GET['data'];

							if ($data == 'success') {
								echo"<p class='errorMsg'>New entry is added successfully.</p>";
							}
						}
					?>
					<form method="POST" action="server.php">
						<select required="" name="idcard" class="textInput">
							<option value="" selected="" disabled="">Chose farmer name</option>
							<?php
								$query = mysqli_query($connect,"SELECT * FROM farmers WHERE deleted = 0 ORDER BY farmernames ASC");
								while ($row = mysqli_fetch_array($query)){
									echo "<option value='".$row['idcard']."'>".$row['farmernames']."</option>";
								}
							?>
						</select>
						<select required="" name="productId" class="textInput">
							<option value="" selected="" disabled="">Chose product name</option>
							<?php
								$query = mysqli_query($connect,"SELECT * FROM product ORDER BY productname ASC");
								while ($row = mysqli_fetch_array($query)){
									echo "<option value='".$row['productid']."'>".$row['productname']." - ".$row['price']." Frw/".$row['measurement']."</option>";
								}
							?>
						</select>
						<input type="text" name="qty" onkeypress='return isNumber(event);' class="textInput" placeholder="Quantity" required>
						<button class="submitBtn" name="addnewEntry">Add new</button>
					</form>
				</div>
				<div class="allData" style="overflow-x: auto;">
					<div class="searchSection">
						<form method="GET">
							<input type="date" name="from" required style="width: 120px;">
							<input type="date" name="to" required style="width: 120px;">
							<button class="aprvbtn">Search</button>
						</form>
					</div>
					<div class="heading">All recorded entries data</div>
					<table>
						<?php
							echo"<tr>
								<th></th>
								<th>Farmer's National ID Card NO</th>
								<th>Farmer's Names</th>
								<th>Product</th>";

								if(isset($_GET['from'])){
									$from = $_GET['from'];
									$to = $_GET['to'];
									$querydates = mysqli_query($connect,"SELECT * FROM harvests WHERE DATE(harvestDate) BETWEEN '$from' AND '$to' GROUP BY harvestDate ORDER BY harvestid ASC");
								}else{
									$querydates = mysqli_query($connect,"SELECT * FROM harvests GROUP BY harvestDate ORDER BY harvestid ASC");
								}
								while ($rowdates = mysqli_fetch_array($querydates)) {
									echo "<th colspan='2'>".date('d/m/Y', strtotime($rowdates['harvestDate']))."</th>";
								}

							echo"<th colspan='2'>Total</th></tr>";

							$rowcount = 0;
							$queryProduct = mysqli_query($connect,"SELECT * FROM product ORDER BY productname ASC");
							while($rowProduct = mysqli_fetch_array($queryProduct)){
								$query = mysqli_query($connect,"SELECT * FROM farmers WHERE deleted = 0 ORDER BY farmernames ASC");

								while ($row = mysqli_fetch_array($query)) {
									$rowcount ++;
									echo "<tr>
										<td>".$rowcount."</td>
										<td>".$row['idcard']."</td>
										<td>".$row['farmernames']."</td>
										<td>".$rowProduct['productname']."</td>";

										$tqty = 0;
										$tpay = 0;

										if(isset($_GET['from'])){
											$querydates = mysqli_query($connect,"SELECT * FROM harvests WHERE DATE(harvestDate) BETWEEN '$from' AND '$to' GROUP BY harvestDate ORDER BY harvestid ASC");
										}else{
											$querydates = mysqli_query($connect,"SELECT * FROM harvests GROUP BY harvestDate ORDER BY harvestid ASC");
										}

										while ($rowdates = mysqli_fetch_array($querydates)) {

											$querydata = mysqli_query($connect,"SELECT SUM(qty) as qty, SUM(tp) as tp, idcard, productid, harvestDate FROM harvests WHERE idcard = '".$row['idcard']."' AND productid = '".$rowProduct['productid']."' AND harvestDate = '".$rowdates['harvestDate']."'");
											$rowdata = mysqli_fetch_array($querydata);

											$tqty = $tqty + $rowdata['qty'];
											$tpay = $tpay + $rowdata['tp'];

											echo "<td style='text-align: right;'>".$rowdata['qty']." ".$rowProduct['measurement']."</td>";
											echo "<td style='text-align: right;'>".$rowdata['tp']." Frw</td>";
										}

										echo "<td style='text-align: right;'>".$tqty." ".$rowProduct['measurement']."</td>";
										echo "<td style='text-align: right;'>".$tpay." Frw</td>";

									echo"</tr>";
								}
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