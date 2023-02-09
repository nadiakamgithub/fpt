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
					<a href="myorders.php"><li class="active">Orders</li></a>
					<a href="stock.php"><li>Stock status</li></a>
					<a href="change.php"><li>Change password</li></a>
					<a href="logout.php"><li>Logout</li></a>
				</ul>
			</div>
			<div class="naviSection">
				<ul>
					<a href="homepage.php"><li>Home</li></a>
					<a href="myorders.php"><li class="active">Orders</li></a>
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
			<p class="pageHeader">Orders related data</p>
			<div class="wrapContent">
				<div class="inputForm">
					<div class="heading">Add new order</div>
					<?php
						if (isset($_GET['data'])) {
							$data = $_GET['data'];

							if ($data == 'success') {
								echo"<p class='errorMsg'>New order is sent successfully.</p>";
							} elseif ($data == 'qtyError') {

								echo"<p class='errorMsg'>Quantity ordered is not found in stock.<br><br>Order: <b>".$_GET['order']."</b>, Current stock blance: <b>".$_GET['current']."</b>, Missing: <b>".$_GET['miss']."</b></p>";
							} 
						}  else {
							echo "<p class='errorMsg'>Before you can make an order, you have to pay respective quantity to be ordered on this account number <b>474929-627-24-02</b> in Bank of Kigali.</p>";
						}
					?>
					<form method="POST" action="server.php" enctype="multipart/form-data">
						<select required="" name="productId" class="textInput">
							<?php
								$query = mysqli_query($connect,"SELECT * FROM product WHERE deleted = 0 ORDER BY  productname ASC");
								while ($row = mysqli_fetch_array($query)){
									$queryProduct = mysqli_query($connect,"SELECT * FROM product WHERE productid='".$row['productid']."'");
									$rowProduct = mysqli_fetch_array($queryProduct);

									echo "<option value='".$row['productid']."'>".$row['productname']." ".$row['sprice']." Frw/".$rowProduct['measurement']."</option>";
								}
							?>
						</select>
						<input type="text" name="qty" onkeypress="return isNumber(event);" class="textInput" placeholder="Quantity" required>
						<input type="text" name="location" class="textInput" placeholder="Delively location" required>
						<p>Upload payment-slip</p>
						<br>
						<input type="file" name="uploaded_file" accept=".jpg,.jpeg,.png" required>
						<br><br>
						<button class="submitBtn" name="addneworder">Add new</button>
					</form>
				</div>
				<div class="allData">
					<div class="heading">All sent orders data</div>
					<table>
						<tr>
							<th></th>
							<th>Order Code</th>
							<th>Supplier's Names</th>
							<th>Product</th>
							<th>Quantity</th>
							<th>Delively location</th>
							<th>Date</th>
							<th>Payment</th>
							<th>Status</th>
						</tr>
						<?php
							$supplier = $_SESSION['harvest_user'];
							$query = mysqli_query($connect,"SELECT * FROM orders WHERE supplier = '$supplier' ORDER BY ordercode DESC");
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
									<td>".$row['qty']." ".$rowProduct['measurement']."</td>
									<td>".$row['location']."</td>
									<td>".$row['orderdate']."</td>
									<td style='text-align: center;'><a style='color: #09f;' target='_blank' href='".$row['bankSlip']."'>View</a></td>
									<td>".$row['status']."</td>
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