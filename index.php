<?php
include('includes/config.php');
if(isset($_SESSION['accessed'])){
	include('logged.php');
}
else {
	include('home.php');
}

?>