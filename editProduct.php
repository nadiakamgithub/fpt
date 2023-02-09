<?php session_start();
	if (!isset($_SESSION['harvest_user'])) {
		echo"<script>window.location='index.php?error=login';</script>";
	}else{
		include('connector.php');
		$query = mysqli_query($connect,"SELECT * FROM product WHERE productid='".$_GET['product']."'");
		$row = mysqli_fetch_array($query);
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
					<a href="products.php"><li class="active">Products</li></a>
					<a href="entries.php"><li>Entries</li></a>
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
					<a href="products.php"><li class="active">Products</li></a>
					<a href="entries.php"><li>Entries</li></a>
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
			<p class="pageHeader">Products information</p>
			<div class="wrapContent">
				<div class="inputForm">
					<div class="heading">Add a new product</div>
					<?php
						echo"<form method='POST' action='server.php'>
							<input type='hidden' name='productid' value='".$row['productid']."'>
							<input type='text' name='name' class='textInput' placeholder='Product name'required value='".$row['productname']."'>
							<input type='text' name='price' onkeypress='return isNumber(event);' class='textInput' placeholder='Cost Price / Frw' required value='".$row['price']."'>
							<input type='text' name='sprice' onkeypress='return isNumber(event);' class='textInput' placeholder='Selling Price / Frw' required value='".$row['sprice']."'>
							<input type='text' name='measurement' class='textInput' placeholder='Measurement' required value='".$row['measurement']."'>
							<button class='submitBtn' name='editProduct'>Save changes</button>
						</form>";
					?>
				</div>
				<div class="allData">
					<div class="searchSection">
						<form method="GET" action="products.php">
							<input type="text" name="keyCode" placeholder="Search" required>
							<button class="aprvbtn">Search</button>
						</form>
					</div>
					<div class="heading">All recorded products data</div>
					<table>
						<tr>
							<th></th>
							<th>Product name</th>
							<th>Cost Price / Frw</th>
							<th>Selling Price / Frw</th>
							<th>Stock</th>
							<th></th>
						</tr>
						<?php
							$query = mysqli_query($connect,"SELECT * FROM product ORDER BY productname ASC");
							$rowcount = 0;
							while ($row = mysqli_fetch_array($query)){
								$rowcount ++;
								echo "<tr>
									<td>".$rowcount."</td>
									<td>".$row['productname']."</td>
									<td>".$row['price']."</td>
									<td>".$row['sprice']."</td>
									<td>".$row['stock']."</td>
									<td class='al-center' style='width: 50px;><div class='wrapContent'>
										<a href='editProduct.php?product=".$row['productid']."'><button class='aprvbtn'>Edit</button></a>
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