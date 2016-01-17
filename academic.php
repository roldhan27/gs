<?php
include('includes/config.php');
$iNew = new iNew_dbConnect();
if(!isset($_SESSION['ses_id'])){
	echo "<script>location.href='/';</script>";
	exit();
}
?>
<?php include('header.php'); ?>

<?php include('footer.php'); ?>