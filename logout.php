<?php session_start();
	unset($_SESSION['harvest_user']);
	echo"<script>window.location='index.php';</script>";
?>