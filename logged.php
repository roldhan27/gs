<?php
$iNew = new iNew_dbConnect();
?>
<?php include('header.php'); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-info">
				<div class="panel-heading">
					Welcome
				</div>
				<div class="panel-body">
					NAME : <?php echo $iNew->esc($_SESSION['fname'])." ".$iNew->esc($_SESSION['lname']); ?><br>
					Account Type : <?php if($_SESSION['acctype'] == 0) { echo "<font color='#ea6153'>Administrator</font>"; } else if ($_SESSION['acctype'] == 1) { echo "<font color='#9b59b6'>Professor</font>"; } else { echo "<font color='#2ecc71'>Student</font>"; } ?>
					<?php
						if($_SESSION['acctype'] == 2){
					?>
						Course : <?php echo $iNew->esc($_SESSION['course']); ?>
					<?php
						}
					?>
				</div>
			</div>
			<?php
				if($_SESSION['acctype'] == 0){
			?>
			<!-- List of Professor`s Account -->
			<div class="panel panel-info">
				<div class="panel-heading">
					List of Professor`s Account <button class="btn btn-success pull-right"  data-toggle="modal" data-target="#addInstructor">Add</button> <a href="/account.php?prof" class="btn btn-warning pull-right">See All</a>
					<div style="clear:both"></div>
				</div>
				<div class="panel-body">
					<table class="table table-striped">
					  <thead style="font-weight:bolder">
						  <tr>
						  	<td>ID</td>
						  	<td>Instructor</td>
						  </tr
>					  </thead>
					  <tbody>
					  <?php 
					  	$profL = $iNew->dbCon->prepare("SELECT * FROM `gs_users` WHERE `acctype` = ? ORDER BY `id` ASC LIMIT 10");
					  	$profL->bindValue(1,1);
					  	$profL->execute();

					  	foreach ($profL->fetchAll() as $profInfo => $a) {
					  ?>
					  	<tr>
					  		<td><?php echo $a['id']; ?></td>
					  		<td><a href="account.php?prof&id=<?php echo $a['id']; ?>"><?php echo $iNew->esc($a['fname'])." ".$iNew->esc($a['lname']); ?>(<?php echo $iNew->esc($a['username']); ?>)</a></td>
					  	</tr>
					  <?php
					  	}
					  ?>
					  </tbody>
					</table>
					<!-- Add Instructor Modal -->
					<div class="modal fade" id="addInstructor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					        <h4 class="modal-title" id="myModalLabel">Add Instructor</h4>
					      </div>
					      <div class="modal-body">
							<form class="addInstructor">
							  <div class="form-group">
							    <label for="fname">First Name : </label>
							    <input type="input" class="form-control" id="fname" placeholder="First Name" required>
							  </div>
							  <div class="form-group">
							    <label for="lname">Last Name : </label>
							    <input type="input" class="form-control" id="lname" placeholder="Last Name" required>
							  </div>
							  <div class="form-group">
							    <label for="username">Username : </label>
							    <input type="input" class="form-control" id="username" placeholder="Username" required>
							  </div>
							  <div class="form-group">
							    <label for="password">Password</label>
							    <input type="password" class="form-control" id="password" placeholder="Password" required>
							  </div>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					        <button type="submit" class="btn btn-primary addInstructorButt">Add</button>
							</form>
					      </div>
					    </div>
					  </div>
					</div>
				</div>
			</div>
			<!-- List of Student`s Accounts -->
			<div class="panel panel-info">
				<div class="panel-heading">
					List of Student`s Account <button class="btn btn-success pull-right"  data-toggle="modal" data-target="#addStudent">Add</button> <a href="/account.php?student" class="btn btn-warning pull-right">See All</a>
					<div style="clear:both"></div>
				</div>
				<div class="panel-body">
					<table class="table table-striped">
					  <thead style="font-weight:bolder">
						  <tr>
						  	<td>ID</td>
						  	<td>Student Name</td>
						  </tr
>					  </thead>
					  <tbody>
					  <?php 
					  	$profL = $iNew->dbCon->prepare("SELECT * FROM `gs_users` WHERE `acctype` = ? ORDER BY `id` ASC LIMIT 10");
					  	$profL->bindValue(1,2);
					  	$profL->execute();

					  	foreach ($profL->fetchAll() as $profInfo => $a) {
					  ?>
					  	<tr>
					  		<td><?php echo $a['id']; ?></td>
					  		<td><a href="account.php?student&id=<?php echo $a['id']; ?>"><?php echo $iNew->esc($a['fname'])." ".$iNew->esc($a['lname']); ?>(<?php echo $iNew->esc($a['username']); ?>)</a></td>
					  	</tr>
					  <?php
					  	}
					  ?>
					  </tbody>
					</table>
					<!-- Add Student Modal -->
					<div class="modal fade" id="addStudent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					        <h4 class="modal-title" id="myModalLabel">Add Student</h4>
					      </div>
					      <div class="modal-body">
							<form class="addStudent">
							  <div class="form-group">
							    <label for="fname">First Name : </label>
							    <input type="input" class="form-control" id="fname" placeholder="First Name" required>
							  </div>
							  <div class="form-group">
							    <label for="lname">Last Name : </label>
							    <input type="input" class="form-control" id="lname" placeholder="Last Name" required>
							  </div>
							  <div class="form-group">
							    <label for="username">Username : </label>
							    <input type="input" class="form-control" id="username" placeholder="Username" required>
							  </div>
							  <div class="form-group">
							    <label for="password">Password</label>
							    <input type="password" class="form-control" id="password" placeholder="Password" required>
							  </div>
							  <div class="form-group">
							    <label for="course">Course</label>
							    <select class="form-control" id="course">
							    	<option value="BS-IT">BS in Information Technology</option>
							    	<option value="BS-CS">BS in Computer Science</option>
							    	<option value="BS-HRM">BS in Hotel & Restaurant Management</option>
							    	<option value="BS-BA">Bachelor of Science in Business Administration</option>
							    	<option value="BS-A">Bachelor of Science in Accountancy</option>
							    </select>
							  </div>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					        <button type="submit" class="btn btn-primary addStudentButt">Add</button>
							</form>
					      </div>
					    </div>
					  </div>
					</div>
				</div>
			</div>
			<?php
				}
			?>
		</div>
		<?php
			if($_SESSION['acctype'] == "0"){
		?>
		<div class="col-md-8">
			<div class="panel panel-info">
				<div class="panel-heading">
					Available Academic List <button class="btn btn-success pull-right" data-toggle="modal" data-target="#addAcademic">Add</button>
					<div style="clear:both"></div>
				</div>
				<div class="panel-body">
					<table class="table table-striped">
					  <thead style="font-weight:bolder">
						  <tr>
						  	<td>Class Number</td>
						  	<td>Subject Name</td>
						  	<td>Instructor</td>
						  </tr
>					  </thead>
					  <tbody>
					  <?php
					  $selAcademic = $iNew->dbCon->prepare("SELECT * FROM `gs_academics` ORDER BY `id` ASC");
					  $selAcademic->execute();
					  if($selAcademic->rowCount() > 0){
					  ?>
						  <?php
						  foreach ($selAcademic->fetchAll() as $a => $b) {
						  ?>
						  	<tr>
						  		<td><a href="/academic.php?id=<?php echo $b['subject_code'] ?>"><?php echo $b['subject_code'] ?></a></td>
						  		<td><?php echo $b['subject_name'] ?></td>
						  		<td><?php echo $b['instructor'] ?></td>
						  	</tr>
						  <?php
						  }
						  ?>
					  <?php
					  }
					  else {
					  ?>
					  	<tr>
					  		<td colspan="3"><div class="alert alert-danger">No database record yet.</div></td>
					  	</tr>
					  <?php
					  }
					  ?>
					  </tbody>
					</table>
					<!-- Add Academics Modal -->
					<div class="modal fade" id="addAcademic" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					        <h4 class="modal-title" id="myModalLabel">Add Academic</h4>
					      </div>
					      <div class="modal-body">
							<form class="addAcademic">
							  <div class="form-group">
							    <label for="subjectn">Subject Name : </label>
							    <input type="input" class="form-control" id="subjectn" placeholder="Subject Name" required>
							  </div>
							  <div class="form-group">
							    <label for="subjectc">Subject Code : </label>
							    <input type="input" class="form-control" id="subjectc" placeholder="Subject Code" required>
							  </div>
							  <div class="form-group">
							    <label for="prof">Instructor : </label>
							    <select class="form-control" id="prof">
							    	<?php 

							    	$selProf = $iNew->dbCon->prepare("SELECT * FROM `gs_users` WHERE `acctype` = :acctype");
							    	$selProf->execute(array('acctype'=>1));
							    	foreach ($selProf->fetchAll() as $a => $b) {
							    		echo "<option value='".$b['username']."'>".$iNew->esc($b['fname'])." ".$iNew->esc($b['lname'])."</option>";
							    	}

							    	?>
							    </select>
							  </div>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					        <button type="submit" class="btn btn-primary addAcademicButt">Add</button>
							</form>
					      </div>
					    </div>
					  </div>
					</div>
				</div>
			</div>
		</div>
		<?php
			}
		?>
	</div>
</div>
<?php include('footer.php'); ?>