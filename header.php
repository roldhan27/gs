<!DOCTYPE html>
<html>
<head>
<title>Grading System - TFVC</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name=description content="TFVC Student Grading System" />
	<meta name=author content="Roldhan Dasalla(iNew Works)" />
	<meta property=og:url content=http://www.tfvc-gradingsystem.com/ />
	<meta property=og:type content=website />
	<meta property=og:title content="Grading System - TFVC" />
	<meta property=og:image content="" />
	<meta property=og:description content="TFVC Student Grading System" />
	<meta property=profile:first_name content="Roldhan Dasalla(iNew Works)" />

	<link rel="stylesheet" href="assets/css/bootstrap.css"/>
	<link rel="stylesheet" href="assets/css/index.css"/>
	<script src="assets/js/jquery.min.js" type="text/javascript"></script>
	<link rel="icon" type="image/png" href="favicon.png">
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">TFVC - GS</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="/">Home </a></li>
        <li><a href="/account.php">Accounts </a></li>
        <li><a href="/academic.php">Academics </a></li>

        <!--<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Students <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Add</a></li>
            <li><a href="#">Edit/Delete</a></li>
          </ul>
        </li>-->

        <li><a href="/includes/functions.php?do=logOut" onclick="return confirm('Are you sure you wannna log out ?')">Log Out</a></li>
      </ul>
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
      </form>
    </div>
  </div>
</nav>