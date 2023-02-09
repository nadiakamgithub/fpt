<?php session_start();
	if (!isset($_SESSION['harvest_user'])) {
		echo"<script>window.location='index.php?error=login';</script>";
	}else{
		include('connector.php');
		$query = mysqli_query($connect,"SELECT * FROM farmers WHERE farmerid='".$_GET['farmerid']."'");
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
					<a href="farmers.php"><li class="active">Farmers</li></a>
					<a href="products.php"><li>Products</li></a>
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
					<a href="farmers.php"><li class="active">Farmers</li></a>
					<a href="products.php"><li>Products</li></a>
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
			<p class="pageHeader">Farmers information</p>
			<div class="wrapContent">
				<div class="inputForm">
					<div class="heading">Add a new farmer</div>
					<?php
						echo" <form method='POST' action='server.php'>
							<input type='hidden' name='farmerid' class='textInput' placeholder='Farmers names' required value='".$row['farmerid']."'>
							<input type='text' onkeypress='return onlyAlphabets(event,this);' name='names' class='textInput' placeholder='Farmers names' required value='".$row['farmernames']."'>
							<input type='text' name='idcard' class='textInput' placeholder='National ID Card NO' minlength='16' maxlength='16' onkeypress='return isNumber(event);' required value='".$row['idcard']."'>
							<input type='text' name='phone' minlength='10' maxlength='10' onkeypress='return isNumber(event);' class='textInput' placeholder='Phone number' required value='".$row['phone']."'>
							<input type='text' name='district' class='textInput' placeholder='Address | District' required value='".$row['district']."'>
							<input type='text' name='sector' class='textInput' placeholder='Address | Sector' required value='".$row['sector']."'>
							<button class='submitBtn' name='editfarmer'>Save changes</button>
						</form>";
					?>
				</div>
				<div class="allData">
					<div class="searchSection">
						<form method="GET" action='farmers.php'>
							<input type="text" name="keyCode" placeholder="Search" required>
							<button class="aprvbtn">Search</button>
						</form>
					</div>
					<div class="heading">All recorded farmers data</div>
					<table>
						<tr>
							<th></th>
							<th>Farmer's name</th>
							<th>National ID Card NO</th>
							<th>Phone number</th>
							<th>District</th>
							<th>Sector</th>
							<th></th>
						</tr>
						<?php
							$query = mysqli_query($connect,"SELECT * FROM farmers WHERE deleted = 0 ORDER BY farmernames ASC");
							$rowcount = 0;
							while ($row = mysqli_fetch_array($query)){
								$rowcount ++;
								echo "<tr>
									<td>".$rowcount."</td>
									<td>".$row['farmernames']."</td>
									<td>".$row['idcard']."</td>
									<td>".$row['phone']."</td>
									<td>".$row['district']."</td>
									<td>".$row['sector']."</td>
									<td class='al-center' style='width: 150px;><div class='wrapContent'>
										<a href='editFarmer.php?farmerid=".$row['farmerid']."'><button class='aprvbtn'>Edit</button></a>
										<a href='server.php?deleteFarmer=".$row['farmerid']."'><button class='denybtn'>Delete</button></a>
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