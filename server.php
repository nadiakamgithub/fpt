<?php session_start();
include('connector.php');

if (isset($_POST['userlogin'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$usertype = $_POST['usertype'];
	

	if($usertype == 0){
		echo"<script>window.location='index.php?error=invalidUserType';</script>";
	}elseif ($usertype == 1) {
		$query = mysqli_query($connect,"SELECT * FROM users WHERE username='$username' AND password='$password'");
		$row = mysqli_fetch_array($query);

		if ($username == $row['username'] AND $password == $row['password']) {
			$_SESSION['harvest_user'] = $row['userid'];
			echo"<script>window.location='home.php';</script>";
		} else {
			echo"<script>window.location='index.php?error=invalid';</script>";
		}
	}elseif ($usertype == 2) {
		$query = mysqli_query($connect,"SELECT * FROM suppliers WHERE phone='$username' AND password='$password' AND deleted = 0");
		$row = mysqli_fetch_array($query);

		if ($username == $row['phone'] AND $password == $row['password']) {
			$_SESSION['harvest_user'] = $row['supplierid'];
			echo"<script>window.location='homepage.php';</script>";
		} else {
			echo"<script>window.location='index.php?error=invalid';</script>";
		}
	}elseif ($usertype == 3) {
		$query = mysqli_query($connect,"SELECT * FROM farmers WHERE phone='$username' AND password='$password' AND deleted = 0");
		$row = mysqli_fetch_array($query);

		if ($username == $row['phone'] AND $password == $row['password']) {
			$_SESSION['harvest_user'] = $row['idcard'];
			echo"<script>window.location='homepages.php';</script>";
		} else {
			echo"<script>window.location='index.php?error=invalid';</script>";
		}
	}
}

if (isset($_POST['addnewfarmer'])) {
	$names = $_POST['names'];
	$idcard = $_POST['idcard'];
	$phone = $_POST['phone'];
	$password = $_POST['password'];
	$district = $_POST['district'];
	$sector = $_POST['sector'];

	
	$query = mysqli_query($connect,"INSERT INTO farmers(farmernames, idcard, phone, password, district, sector) VALUES ('$names', '$idcard', '$phone', '$password', '$district', '$sector')");
	echo"<script>window.location='farmers.php?data=success';</script>";
}

if (isset($_POST['addnewEntry'])) {
	$idcard = $_POST['idcard'];
	$productId = $_POST['productId'];
	$qty = $_POST['qty'];

	$queryProduct = mysqli_query($connect,"SELECT * FROM product WHERE productid='$productId'");
	$rowProduct = mysqli_fetch_array($queryProduct);

	$up = $rowProduct['price'];
	$tp = $qty * $up;

	$harvestDate = date('Y-m-d');

	
	$query = mysqli_query($connect,"INSERT INTO harvests (idcard, qty, up, tp, harvestDate, productid) VALUES ('$idcard', '$qty', '$up', '$tp', '$harvestDate', '$productId')");

	$curentStock = $rowProduct['stock'];
	$newStock = $curentStock + $qty;

	$queryFarmer = mysqli_query($connect,"SELECT * FROM farmers WHERE idcard='$idcard'");
	$rowFarmer = mysqli_fetch_array($queryFarmer);
	$currentPayment = $rowFarmer['payment'];
	$newPayment = $currentPayment + $tp;

	mysqli_query($connect,"UPDATE farmers SET payment = '$newPayment' WHERE idcard='$idcard'");

	mysqli_query($connect,"UPDATE product SET stock = '$newStock' WHERE productid='$productId'");

	echo"<script>window.location='entries.php?data=success';</script>";
}

if (isset($_POST['changepass'])) {
	$oldpass = $_POST['oldpass'];
	$newpass = $_POST['newpass'];

	$user = $_SESSION['harvest_user'];
	$query = mysqli_query($connect,"SELECT * FROM suppliers WHERE supplierid='$user' AND password='$oldpass'");
	$row = mysqli_fetch_array($query);

	if ($user == $row['supplierid'] AND $oldpass == $row['password']) {
		$query = mysqli_query($connect,"UPDATE suppliers SET password = '$newpass' WHERE supplierid = '$user'");
		echo"<script>window.location='change.php?data=success';</script>";
	} else {
		echo"<script>window.location='change.php?data=invalid';</script>";
	}
}

if (isset($_POST['changespass'])) {
	$oldpass = $_POST['oldpass'];
	$newpass = $_POST['newpass'];

	$user = $_SESSION['harvest_user'];
	$query = mysqli_query($connect,"SELECT * FROM farmers WHERE idcard='$user' AND password='$oldpass'");
	$row = mysqli_fetch_array($query);

	if ($user == $row['idcard'] AND $oldpass == $row['password']) {
		$query = mysqli_query($connect,"UPDATE farmers SET password = '$newpass' WHERE idcard = '$user'");
		echo"<script>window.location='changes.php?data=success';</script>";
	} else {
		echo"<script>window.location='changes.php?data=invalid';</script>";
	}
}

if (isset($_POST['editfarmer'])) {
	$farmerid = $_POST['farmerid'];
	$names = $_POST['names'];
	$idcard = $_POST['idcard'];
	$phone = $_POST['phone'];
	$district = $_POST['district'];
	$sector = $_POST['sector'];

	
	$query = mysqli_query($connect,"UPDATE farmers SET farmernames = '$names', idcard = '$idcard', phone = '$phone', district = '$district', sector = '$sector' WHERE farmerid = '$farmerid'");
	echo"<script>window.location='farmers.php?data=edited';</script>";
}

if (isset($_POST['addnewProduct'])) {
	$name = $_POST['name'];
	$price = $_POST['price'];
	$sprice = $_POST['sprice'];
	$measurement = $_POST['measurement'];
	
	$query = mysqli_query($connect,"INSERT INTO product(productname,measurement,stock,price,sprice) VALUES('$name', '$measurement', '0', '$price', '$sprice')");
	echo"<script>window.location='products.php?data=success';</script>";
}

if (isset($_POST['editProduct'])) {
	$productid = $_POST['productid'];
	$name = $_POST['name'];
	$price = $_POST['price'];
	$sprice = $_POST['sprice'];
	$measurement = $_POST['measurement'];
	
	$query = mysqli_query($connect,"UPDATE product SET productname = '$name', price = '$price', sprice = '$sprice', measurement = '$measurement' WHERE productId = '$productid'");
	echo"<script>window.location='products.php?data=edited';</script>";
}

if (isset($_GET['deleteFarmer'])) {
	$farmerid = $_GET['deleteFarmer'];
	
	$query = mysqli_query($connect,"UPDATE farmers SET deleted = 1 WHERE farmerid = '$farmerid'");
	echo"<script>window.location='farmers.php?data=deleted';</script>";
}

if (isset($_POST['addnewsupplier'])) {
	$names = $_POST['names'];
	$idcard = $_POST['idcard'];
	$phone = $_POST['phone'];
	$district = $_POST['district'];
	$sector = $_POST['sector'];
	$password = $_POST['password'];

	$redirection = $_POST['redirection'];

	
	$query = mysqli_query($connect,"INSERT INTO suppliers(suppliernames, idcard, phone, district, sector, password) VALUES ('$names', '$idcard', '$phone', '$district', '$sector', '$password')");
	echo"<script>window.location='".$redirection.".php?data=success';</script>";
}

if (isset($_POST['editsupplier'])) {
	$supplierid = $_POST['supplierid'];
	$names = $_POST['names'];
	$idcard = $_POST['idcard'];
	$phone = $_POST['phone'];
	$district = $_POST['district'];
	$sector = $_POST['sector'];

	
	$query = mysqli_query($connect,"UPDATE suppliers SET suppliernames = '$names', idcard = '$idcard', phone = '$phone', district = '$district', sector = '$sector' WHERE supplierid='$supplierid'");
	echo"<script>window.location='suppliers.php?data=edited';</script>";
}

if (isset($_GET['deleteSupplier'])) {
	$supplierid = $_GET['deleteSupplier'];
	
	$query = mysqli_query($connect,"UPDATE suppliers SET deleted = 1 WHERE supplierid = '$supplierid'");
	echo"<script>window.location='suppliers.php?data=deleted';</script>";
}

if (isset($_POST['addneworder'])) {
	$productId = $_POST['productId'];
	$qty = $_POST['qty'];
	$location = $_POST['location'];

	$orderdate = date('d/m/Y');
	$supplier = $_SESSION['harvest_user'];
	$ordercode = strtoupper(uniqid());

	$queryProduct = mysqli_query($connect,"SELECT * FROM product WHERE productid='$productId'");
	$rowProduct = mysqli_fetch_array($queryProduct);
	$curentStock = $rowProduct['stock'];

	if ($qty > $curentStock) {
		$miss = $qty - $curentStock;
		echo"<script>window.location='myorders.php?data=qtyError&order=".$qty."&current=".$curentStock."&miss=".$miss."';</script>";
	}else{
		$path = "images/payments/";
	    $path = $path . basename(time().".png");
	    move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path);

		$query = mysqli_query($connect,"INSERT INTO orders(ordercode, qty, location, supplier, orderdate, productid, bankSlip) VALUES ('$ordercode', '$qty', '$location', '$supplier', '$orderdate', '$productId', '$path')");

		$querySupplier = mysqli_query($connect,"SELECT * FROM suppliers WHERE supplierid='$supplier'");
		$rowSupplier = mysqli_fetch_array($querySupplier);

		$phone = $rowSupplier['phone'];
		$names = $rowSupplier['suppliernames'];

		// $curl = curl_init();

		// curl_setopt_array($curl, array(
		//   CURLOPT_URL => 'https://api.mista.io/sms',
		//   CURLOPT_RETURNTRANSFER => true,
		//   CURLOPT_ENCODING => '',
		//   CURLOPT_MAXREDIRS => 10,
		//   CURLOPT_TIMEOUT => 0,
		//   CURLOPT_FOLLOWLOCATION => true,
		//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		//   CURLOPT_CUSTOMREQUEST => 'POST',
		//   CURLOPT_POSTFIELDS => array('to' => "+25".$phone,'from' => 'NMI','unicode' => '0','sms' => "Hello ".$names."! Your order with code ".$ordercode." have been received and it is being processed, you will be notified after its review. Note that it will be cancelled with in 3 days from approval date. Thank you!",'action' => 'send-sms'),
		//   CURLOPT_HTTPHEADER => array(
		//     'x-api-key: a02c7aaa-48a7-974d-901d-d6476d221271-152d9ab3'
		//   ),
		// ));

		$phno=$phone;

  $messege="Hello".$names."  Your order with code ".$ordercode." have been received and it is being processed, you will be notified after its review. Note that it will be cancelled with in 3 days from approval date. Thank you!";

   require ("sms.php");

		// $response = curl_exec($curl);

		// curl_close($curl);

		echo"<script>window.location='myorders.php?data=success';</script>";
	}
}

if (isset($_GET['approveOrder'])) {
	$orderId = $_GET['approveOrder'];
	$product = $_GET['product'];
	$qty = $_GET['qty'];
		

	$queryProduct = mysqli_query($connect,"SELECT * FROM product WHERE productid='$product'");
	$rowProduct = mysqli_fetch_array($queryProduct);
	$curentStock = $rowProduct['stock'];

	if($qty > $curentStock){
		echo"<script>window.location='orders.php?data=qtyError';</script>";
	}else{

		mysqli_query($connect,"UPDATE orders SET status = 'Confirmed' WHERE id = '$orderId'");

		$newStock = $curentStock - $qty;

		mysqli_query($connect,"UPDATE product SET stock = '$newStock' WHERE productid='$product'");

		$queryOrder = mysqli_query($connect,"SELECT * FROM orders WHERE id='$orderId'");
		$rowOrder = mysqli_fetch_array($queryOrder);
		$querySupplier = mysqli_query($connect,"SELECT * FROM suppliers WHERE supplierid='".$rowOrder['supplier']."'");
		$rowSupplier = mysqli_fetch_array($querySupplier);

		$ordercode = $rowOrder['ordercode'];
		$phone = $rowSupplier['phone'];
		$names = $rowSupplier['suppliernames'];

		// $curl = curl_init();

		// curl_setopt_array($curl, array(
		//   CURLOPT_URL => 'https://api.mista.io/sms',
		//   CURLOPT_RETURNTRANSFER => true,
		//   CURLOPT_ENCODING => '',
		//   CURLOPT_MAXREDIRS => 10,
		//   CURLOPT_TIMEOUT => 0,
		//   CURLOPT_FOLLOWLOCATION => true,
		//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		//   CURLOPT_CUSTOMREQUEST => 'POST',
		//   CURLOPT_POSTFIELDS => array('to' => "+25".$phone,'from' => 'NMI','unicode' => '0','sms' => "Hello ".$names."! Your order with code ".$ordercode." have been APPROVED, Get in touch for delivery. Thank you!",'action' => 'send-sms'),
		//   CURLOPT_HTTPHEADER => array(
		//     'x-api-key: a02c7aaa-48a7-974d-901d-d6476d221271-152d9ab3'
		//   ),
		// ));
         
		// $response = curl_exec($curl);

		// curl_close($curl);

			$phno=$phone;

  $messege="Hello".$names." ! Your order with code ".$ordercode." have been APPROVED, Get in touch for delivery. Thank you!";

   require ("sms.php");

		echo"<script>window.location='orders-c.php?data=success';</script>";
	}
}

if (isset($_GET['denyOrder'])) {
	$orderId = $_GET['denyOrder'];
	$query = mysqli_query($connect,"UPDATE orders SET status = 'Rejected' WHERE id = '$orderId'");

	$queryOrder = mysqli_query($connect,"SELECT * FROM orders WHERE id='$orderId'");
	$rowOrder = mysqli_fetch_array($queryOrder);
	$querySupplier = mysqli_query($connect,"SELECT * FROM suppliers WHERE supplierid='".$rowOrder['supplier']."'");
	$rowSupplier = mysqli_fetch_array($querySupplier);

	$ordercode = $rowOrder['ordercode'];
	$phone = $rowSupplier['phone'];
	$names = $rowSupplier['suppliernames'];

	// $curl = curl_init();

	// curl_setopt_array($curl, array(
	//   CURLOPT_URL => 'https://api.mista.io/sms',
	//   CURLOPT_RETURNTRANSFER => true,
	//   CURLOPT_ENCODING => '',
	//   CURLOPT_MAXREDIRS => 10,
	//   CURLOPT_TIMEOUT => 0,
	//   CURLOPT_FOLLOWLOCATION => true,
	//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	//   CURLOPT_CUSTOMREQUEST => 'POST',
	//   CURLOPT_POSTFIELDS => array('to' => "+25".$phone,'from' => 'NMI','unicode' => '0','sms' => "Hello ".$names."! Your order with code ".$ordercode." have been REJECTED, Try to re-order again. Thank you!",'action' => 'send-sms'),
	//   CURLOPT_HTTPHEADER => array(
	//     'x-api-key: a02c7aaa-48a7-974d-901d-d6476d221271-152d9ab3'
	//   ),
	// ));

	// $response = curl_exec($curl);

	// curl_close($curl);

    			$phno=$phone;

  $messege="Hello".$names." ! Your order with code ".$ordercode." have been REJECTED, Try to re-order again. Thank you!";
  
	echo"<script>window.location='orders-r.php?data=success';</script>";
}

if (isset($_POST['addnewPayment'])) {
	$amount = $_POST['amount'];
	$idcard = $_POST['idcard'];

	$paymentdate = date('d/m/Y H:i:s');
	$code = time();

	$queryFarmer = mysqli_query($connect,"SELECT * FROM farmers WHERE idcard='$idcard'");
	$rowFarmer = mysqli_fetch_array($queryFarmer);

	$currentBalance = $rowFarmer['account'];
	$newBalance = $currentBalance + $amount;

	$currentPayment = $rowFarmer['payment'];
	$newPayment = $currentPayment - $amount;

	$query = mysqli_query($connect,"INSERT INTO payments(code, farmer, account, amount, balance, pdate) VALUES ('$code', '$idcard', '$currentBalance', '$amount', '$newBalance', '$paymentdate')");

	mysqli_query($connect,"UPDATE farmers SET account = '$newBalance', payment = '$newPayment' WHERE idcard='$idcard'");

	$phone = $rowFarmer['phone'];
	$names = $rowFarmer['farmernames'];

	// $curl = curl_init();

	// curl_setopt_array($curl, array(
	//   CURLOPT_URL => 'https://api.mista.io/sms',
	//   CURLOPT_RETURNTRANSFER => true,
	//   CURLOPT_ENCODING => '',
	//   CURLOPT_MAXREDIRS => 10,
	//   CURLOPT_TIMEOUT => 0,
	//   CURLOPT_FOLLOWLOCATION => true,
	//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	//   CURLOPT_CUSTOMREQUEST => 'POST',
	//   CURLOPT_POSTFIELDS => array('to' => "+25".$phone,'from' => 'NMI','unicode' => '0','sms' => "Hello ".$names."! Your account have been recharged with ".$amount." from NYANZA MILK INDUSTRIES, Your new balance is ".$newBalance.", Transaction code: ".$code." Date/Time: ".$paymentdate." Thank you!",'action' => 'send-sms'),
	//   CURLOPT_HTTPHEADER => array(
	//     'x-api-key: a02c7aaa-48a7-974d-901d-d6476d221271-152d9ab3'
	//   ),
	// ));

	// $response = curl_exec($curl);

	// curl_close($curl);

           			$phno=$phone;

  $messege="Hello".$names." ! Your account have been recharged with ".$amount." from Famers payments Tracking, Your new balance is ".$newBalance.", Transaction code: ".$code." Date/Time: ".$paymentdate." Thank you!";
  require ("sms.php");


	echo"<script>window.location='payments.php?data=success';</script>";
}

if (isset($_POST['getPayment'])) {
	$idcard = $_POST['idcard'];

	$queryFarmer = mysqli_query($connect,"SELECT * FROM farmers WHERE idcard='$idcard'");
	$rowFarmer = mysqli_fetch_array($queryFarmer);

	$currentPayment = $rowFarmer['payment'];
	echo"<script>window.location='payments.php?getPayment=true&idcard=".$idcard."&names=".$rowFarmer['farmernames']."&amount=".$currentPayment."';</script>";
}

if (isset($_POST['addnewTransfer'])) {
	$amount = $_POST['amount'];
	$phone = $_POST['phone'];

	$trdate = date('d/m/Y H:i:s');
	$code = time();

	$idcard = $_SESSION['harvest_user'];
	$queryFarmerFrom = mysqli_query($connect,"SELECT * FROM farmers WHERE idcard='$idcard'");
	$rowFarmerFrom = mysqli_fetch_array($queryFarmerFrom);

	$currentBalanceFrom = $rowFarmerFrom['account'];
	$newBalanceFrom = $currentBalanceFrom - $amount;

	$queryFarmerTo = mysqli_query($connect,"SELECT * FROM farmers WHERE phone='$phone'");
	$rowFarmerTo = mysqli_fetch_array($queryFarmerTo);

	$idcardTo = $rowFarmerTo['idcard'];
	$currentBalanceTo = $rowFarmerTo['account'];
	$newBalanceTo = $currentBalanceTo + $amount;

	$query = mysqli_query($connect,"INSERT INTO transfers(code, amount, from_farmer, from_account, from_balance, to_farmer, to_account, to_balance, trdate) VALUES ('$code', '$amount', '$idcard', '$currentBalanceFrom', '$newBalanceFrom', '$idcardTo', '$currentBalanceTo', '$newBalanceTo', '$trdate')");

	mysqli_query($connect,"UPDATE farmers SET account = '$newBalanceFrom' WHERE idcard='$idcard'");
	mysqli_query($connect,"UPDATE farmers SET account = '$newBalanceTo' WHERE idcard='$idcardTo'");

	$phoneFrom = $rowFarmerFrom['phone'];
	$namesFrom = $rowFarmerFrom['farmernames'];

	$phoneTo = $rowFarmerTo['phone'];
	$namesTo = $rowFarmerTo['farmernames'];

	// $curl = curl_init();

	// curl_setopt_array($curl, array(
	//   CURLOPT_URL => 'https://api.mista.io/sms',
	//   CURLOPT_RETURNTRANSFER => true,
	//   CURLOPT_ENCODING => '',
	//   CURLOPT_MAXREDIRS => 10,
	//   CURLOPT_TIMEOUT => 0,
	//   CURLOPT_FOLLOWLOCATION => true,
	//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	//   CURLOPT_CUSTOMREQUEST => 'POST',
	//   CURLOPT_POSTFIELDS => array('to' => "+25".$phoneFrom,'from' => 'NMI','unicode' => '0','sms' => "Hello ".$namesFrom."! Your have transfered ".$amount." to ".$namesTo.", Your new balance is ".$newBalanceFrom.", Transaction code: ".$code." Date/Time: ".$paymentdate." Thank you!",'action' => 'send-sms'),
	//   CURLOPT_HTTPHEADER => array(
	//     'x-api-key: a02c7aaa-48a7-974d-901d-d6476d221271-152d9ab3'
	//   ),
	// ));

	$phno=$phone;

  $messege="Hello ".$namesFrom."! Your have transfered ".$amount." to ".$namesTo.", Your new balance is ".$newBalanceFrom.", Transaction code: ".$code." Date/Time: ".$paymentdate." Thank you!";
  require ("sms.php");

	// $response = curl_exec($curl);

	// curl_close($curl);

	// $curl = curl_init();

	// curl_setopt_array($curl, array(
	//   CURLOPT_URL => 'https://api.mista.io/sms',
	//   CURLOPT_RETURNTRANSFER => true,
	//   CURLOPT_ENCODING => '',
	//   CURLOPT_MAXREDIRS => 10,
	//   CURLOPT_TIMEOUT => 0,
	//   CURLOPT_FOLLOWLOCATION => true,
	//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	//   CURLOPT_CUSTOMREQUEST => 'POST',
	//   CURLOPT_POSTFIELDS => array('to' => "+25".$phoneTo,'from' => 'NMI','unicode' => '0','sms' => "Hello ".$namesTo."! Your account have been recharged with ".$amount." from ".$namesFrom.", Your new balance is ".$newBalanceTo.", Transaction code: ".$code." Date/Time: ".$trdate." Thank you!",'action' => 'send-sms'),
	//   CURLOPT_HTTPHEADER => array(
	//     'x-api-key: a02c7aaa-48a7-974d-901d-d6476d221271-152d9ab3'
	//   ),
	// ));

	// $response = curl_exec($curl);

	// curl_close($curl);

		$phno=$phone;

  $messege="Hello ".$namesTo."! Your account have been recharged with ".$amount." from ".$namesFrom.", Your new balance is ".$newBalanceTo.", Transaction code: ".$code." Date/Time: ".$trdate." Thank you!";
  require ("sms.php");

	echo"<script>window.location='transfers.php?data=success';</script>";
}

if (isset($_GET['cancelOrder'])) {
	$orderId = $_GET['cancelOrder'];
	$product = $_GET['product'];
	$qty = $_GET['qty'];
	$query = mysqli_query($connect,"UPDATE orders SET status = 'Cancelled' WHERE id = '$orderId'");
		

	$queryProduct = mysqli_query($connect,"SELECT * FROM product WHERE productid='$product'");
	$rowProduct = mysqli_fetch_array($queryProduct);
	$curentStock = $rowProduct['stock'];
	$newStock = $curentStock + $qty;
	mysqli_query($connect,"UPDATE product SET stock = '$newStock' WHERE productid='$product'");

	$queryOrder = mysqli_query($connect,"SELECT * FROM orders WHERE id='$orderId'");
	$rowOrder = mysqli_fetch_array($queryOrder);
	$querySupplier = mysqli_query($connect,"SELECT * FROM suppliers WHERE supplierid='".$rowOrder['supplier']."'");
	$rowSupplier = mysqli_fetch_array($querySupplier);

	$ordercode = $rowOrder['ordercode'];
	$phone = $rowSupplier['phone'];
	$names = $rowSupplier['suppliernames'];

	// $curl = curl_init();

	// curl_setopt_array($curl, array(
	//   CURLOPT_URL => 'https://api.mista.io/sms',
	//   CURLOPT_RETURNTRANSFER => true,
	//   CURLOPT_ENCODING => '',
	//   CURLOPT_MAXREDIRS => 10,
	//   CURLOPT_TIMEOUT => 0,
	//   CURLOPT_FOLLOWLOCATION => true,
	//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	//   CURLOPT_CUSTOMREQUEST => 'POST',
	//   CURLOPT_POSTFIELDS => array('to' => "+25".$phone,'from' => 'NMI','unicode' => '0','sms' => "Hello ".$names."! Your order with code ".$ordercode." have been CANCELLED due to delay in stock, Get in touch for re-order. Thank you!",'action' => 'send-sms'),
	//   CURLOPT_HTTPHEADER => array(
	//     'x-api-key: a02c7aaa-48a7-974d-901d-d6476d221271-152d9ab3'
	//   ),
	// ));

	// $response = curl_exec($curl);

	// curl_close($curl);

	$phno=$phone;

  $messege="Hello".$names." Your order with code ".$ordercode." have been CANCELLED due to delay in stock, Get in touch for re-order. Thank you!";
  require ("sms.php");


	echo"<script>window.location='orders-c.php?data=success';</script>";
}

if (isset($_POST['addnewloan'])) {
	$farmer = $_SESSION['harvest_user'];
	$amount = $_POST['amount'];
	$reason = $_POST['reason'];
	$ldate = time();
	
	$query = mysqli_query($connect,"INSERT INTO loan(farmer, amount, reason, ldate) VALUES ('$farmer', '$amount', '$reason', '$ldate')");
	echo"<script>window.location='myloans.php?data=success';</script>";
}

if (isset($_GET['approveLoan'])) {
	$loanId = $_GET['approveLoan'];
	$farmer = $_GET['farmer'];
	$query = mysqli_query($connect,"UPDATE loan SET status = 1 WHERE id = '$loanId'");

	$queryFarmer = mysqli_query($connect,"SELECT * FROM farmers WHERE idcard='$farmer'");
	$rowFarmer = mysqli_fetch_array($queryFarmer);

	$camount = $rowFarmer['account'];
	$amount = $_GET['amount'];
	$namount = $camount + $amount;

	$cpay = $rowFarmer['payment'];
	$npay = $cpay - $amount;

	$query = mysqli_query($connect,"UPDATE farmers SET account = '$namount', payment = '$npay' WHERE idcard = '$farmer'");

	$phone = $rowFarmer['phone'];
	$names = $rowFarmer['farmernames'];

	// $curl = curl_init();

	// curl_setopt_array($curl, array(
	//   CURLOPT_URL => 'https://api.mista.io/sms',
	//   CURLOPT_RETURNTRANSFER => true,
	//   CURLOPT_ENCODING => '',
	//   CURLOPT_MAXREDIRS => 10,
	//   CURLOPT_TIMEOUT => 0,
	//   CURLOPT_FOLLOWLOCATION => true,
	//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	//   CURLOPT_CUSTOMREQUEST => 'POST',
	//   CURLOPT_POSTFIELDS => array('to' => "+25".$phone,'from' => 'NMI','unicode' => '0','sms' => "Hello ".$names."! Your loan have been APPROVED, Check your account to confirm so. Thank you!",'action' => 'send-sms'),
	//   CURLOPT_HTTPHEADER => array(
	//     'x-api-key: a02c7aaa-48a7-974d-901d-d6476d221271-152d9ab3'
	//   ),
	// ));

	// $response = curl_exec($curl);

	// curl_close($curl);

	$phno=$phone;

  $messege="Hello".$names." Your loan have been APPROVED, Check your account to confirm so. Thank you!";
  require ("sms.php");


    
	echo"<script>window.location='loans.php?data=success';</script>";
}

if (isset($_GET['rejectLoan'])) {
	$loanId = $_GET['rejectLoan'];
	$farmer = $_GET['farmer'];
	$query = mysqli_query($connect,"UPDATE loan SET status = 2 WHERE id = '$loanId'");

	$queryFarmer = mysqli_query($connect,"SELECT * FROM farmers WHERE idcard='$farmer'");
	$rowFarmer = mysqli_fetch_array($queryFarmer);

	$phone = $rowFarmer['phone'];
	$names = $rowFarmer['farmernames'];

	// $curl = curl_init();

	// curl_setopt_array($curl, array(
	//   CURLOPT_URL => 'https://api.mista.io/sms',
	//   CURLOPT_RETURNTRANSFER => true,
	//   CURLOPT_ENCODING => '',
	//   CURLOPT_MAXREDIRS => 10,
	//   CURLOPT_TIMEOUT => 0,
	//   CURLOPT_FOLLOWLOCATION => true,
	//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	//   CURLOPT_CUSTOMREQUEST => 'POST',
	//   CURLOPT_POSTFIELDS => array('to' => "+25".$phone,'from' => 'NMI','unicode' => '0','sms' => "Hello ".$names."! Your loan have been REJECTED, Contact NMI for more info. Thank you!",'action' => 'send-sms'),
	//   CURLOPT_HTTPHEADER => array(
	//     'x-api-key: a02c7aaa-48a7-974d-901d-d6476d221271-152d9ab3'
	//   ),
	// ));

	// $response = curl_exec($curl);

	// curl_close($curl);

			$phno=$phone;

  $messege="Hello".$names." Your loan have been REJECTED, Contact NMI for more info. Thank you!";
  require ("sms.php");


	echo"<script>window.location='loans.php?data=success';</script>";
}
?>