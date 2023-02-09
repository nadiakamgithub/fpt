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
		<div class="indexLogoSection">
			<center>
				<img src="images/logo.png" class="indexLogo">
				<p class="proName">Farmers Payments Tracking System</p>
			</center>
		</div>
		<div class="logInSection">
			<div class="heading">Signup Here</div>
			<?php
				if (isset($_GET['data'])) {
					$data = $_GET['data'];

					if ($data == 'success') {
						echo"<p class='errorMsg'>New supplier account is created successfully.</p>";
					}
				}
			?>
			<form method="POST" action="server.php">
				<input type="text" name="names" onkeypress="return onlyAlphabets(event,this);" class="textInput" placeholder="supplie's names" required>
				<input type="text" minlength="16" maxlength="16" name="idcard" onkeypress="return isNumber(event);" class="textInput" placeholder="National ID Card NO" required>
				<input type="text" name="phone" minlength="10" maxlength="10" onkeypress="return isNumber(event);" class="textInput" placeholder="Phone number" required>
				<input type="text" name="district" class="textInput" placeholder="Address | District" required>
				<input type="text" name="sector" class="textInput" placeholder="Address | Sector" required>
				<input type="text" name="password" class="textInput" placeholder="Password" required>
				<input type="hidden" name="redirection" value="signup">
				<div class="wrapContent">
					<button class="submitBtn" name="addnewsupplier">Signup</button>
					<a href="index.php" style="position: relative;top: 5px;">Click here to login</a>
				</div>
			</form>
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
</html>