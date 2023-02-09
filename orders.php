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
					<a href="payments.php"><li>Payments</li></a>
					<a href="suppliers.php"><li>Customers</li></a>
					<a href="orders.php"><li class="active">Orders</li></a>
					<a href="logout.php"><li>Logout</li></a>
				</ul>
			</div>
			<div class="naviSection">
				<ul>
					<a href="home.php"><li>Home</li></a>
					<a href="farmers.php"><li>Farmers</li></a>
					<a href="products.php"><li>Products</li></a>
					<a href="entries.php"><li>Entries</li></a>
					<a href="payments.php"><li>Payments</li></a>
					<a href="suppliers.php"><li>Customers</li></a>
					<a href="orders.php"><li class="active">Orders</li></a>
					<a href="logout.php"><li>Logout</li></a>
				</ul>
			</div>
			<div class="proTitle">
				<img src="images/logo-tr.png" class="proLogo">
				<p class="proName">Farmers Payments Tracking System</p>
			</div>
		</div>
		<div class="contentSection">
			<p class="pageHeader">Orders related data</p>
			<div class="wrapContent">
				<div class="allData" style="width: 100%;">
					<div class="otherLinks">
						<span onclick="window.location='orders.php';" class="activePageLink">Pending</span> | 
						<span onclick="window.location='orders-c.php';">Confirmed</span> | 
						<span onclick="window.location='orders-r.php';">Rejected</span> |
						<span onclick="window.location='orders-ca.php';">Cancelled</span>
					</div>
					<div class="heading"><?php
						if(isset($_GET['data']) AND $_GET['data'] == 'qtyError'){
							echo "Quantity in stock is not enough to Approve the order.";
						}else{
							echo"All received orders data(Pending...)";
						}
					 ?></div>
					<table>
						<tr>
							<th></th>
							<th>Order Code</th>
							<th>Customer's Names</th>
							<th>Product</th>
							<th>Quantity</th>
							<th>Delively location</th>
							<th>Date</th>
							<th>Payment</th>
							<th>Status</th>
							<th>Options</th>
						</tr>
						<?php
							$supplier = $_SESSION['harvest_user'];
							$query = mysqli_query($connect,"SELECT * FROM orders WHERE status = 'Pending...' ORDER BY ordercode DESC");
							$rowcount = 0;
							while ($row = mysqli_fetch_array($query)){
								$query1 = mysqli_query($connect,"SELECT * FROM suppliers WHERE supplierid='".$row['supplier']."'");
								$row1 = mysqli_fetch_array($query1);

								$queryProduct = mysqli_query($connect,"SELECT * FROM product WHERE productid='".$row['productid']."'");
								$rowProduct = mysqli_fetch_array($queryProduct);

								$rowcount ++;
								echo "<tr>
									<td>".$rowcount."</td>
									<td>".$row['ordercode']."</td>
									<td>".$row1['suppliernames']."</td>
									<td>".$rowProduct['productname']."</td>
									<td>".$row['qty']."</td>
									<td>".$row['location']."</td>
									<td>".$row['orderdate']."</td>
									<td style='text-align: center;'><a style='color: #09f;' target='_blank' href='".$row['bankSlip']."'>View</a></td>
									<td>".$row['status']."</td>
									<td style='width: 125px;'><div class='wrapContent'>
										<a href='server.php?approveOrder=".$row['id']."&product=".$row['productid']."&qty=".$row['qty']."'><button class='aprvbtn'>Approve</button></a>
										<a href='server.php?denyOrder=".$row['id']."'><button class='denybtn'>Reject</button></a>
									</div></td>
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