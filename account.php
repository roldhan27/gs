<?php
include('includes/config.php');
$iNew = new iNew_dbConnect();
if(!isset($_SESSION['ses_id']) || $_SESSION['acctype'] != 0){
	echo "<script>location.href='/';</script>";
	exit();
}
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
		</div>
		<div class="col-md-8">
		<?php
			if(isset($_GET['prof']) && $iNew->esc($_GET['id'])){
				if(isset($_GET['delete'])){
					$delete = $iNew->dbCon->prepare("DELETE FROM `gs_users` WHERE `id` = :id AND `acctype` = :acctype");
					$delete->execute(array("id" => $iNew->esc($_GET['id']), "acctype" => 1));
					if($delete->rowCount() > 0){
		?>
			<div class="alert alert-danger">Account Deleted.</div>
			<script type="text/javascript">
			setTimeout(function(){
				location.href="/account.php?prof";
			},3000);
			</script>
		<?php
					}
					else {
		?>
			<div class="alert alert-danger">Account doesn`t exist.<a href="/account.php?prof">Click Here</a> to get back.</div>
		<?php
					}
				}
				else {
					$profS = $iNew->dbCon->prepare("SELECT * FROM `gs_users` WHERE `id` = :id AND `acctype` = :acctype");
					$profS->execute(array('id' => $iNew->esc($_GET['id']), 'acctype' => 1));
					if($profS->rowCount() > 0){
						$dataP = $profS->fetch();
						$username = $iNew->esc($dataP['username']);
						$fname = $iNew->esc($dataP['fname']);
						$lname = $iNew->esc($dataP['lname']);
						$course = $iNew->esc($dataP['course']);
		?>
			<div class="panel panel-info">
				<div class="panel-heading">
					Edit <font color="#e74c3c"><?php echo $fname; ?> <?php echo $lname; ?></font>`s Account
				</div>
				<div class="panel-body">
					<form class="editInstructor" data-id="<?php echo $iNew->esc($_GET['id']); ?>">
						<div class="form-group">
							<label for="fname">First Name : </label>
							<input type="input" class="form-control" id="fname" value="<?php echo $fname ?>" placeholder="First Name" required>
						</div>
						<div class="form-group">
							<label for="lname">Last Name : </label>
							<input type="input" class="form-control" id="lname" value="<?php echo $lname ?>" placeholder="Last Name" required>
						</div>
						<div class="form-group">
							<label for="username">Username : </label>
							<input type="input" class="form-control" id="username" value="<?php echo $username ?>" placeholder="Username" required disabled>
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control" id="password" placeholder="Password">
						</div>
						<a href="account.php?prof" class="btn btn-warning">Back to Professor`s Account list</a>
						<a href="account.php?prof&delete&id=<?php echo $iNew->esc($_GET['id']); ?>" class="btn btn-danger" onclick="return confirm('Do you really want to delete it?');">Delete</a>
					  	<button type="submit" class="btn btn-primary editInstructorButt">Edit</button>
					</form>
				</div>
			</div>
		<?php
					}
					else {
						echo '<div class="alert alert-danger">This account doesn`t exist. <a href="/account.php?prof">Click here</a> to get back.</div>';
					}
					
				}
			}
			else if(isset($_GET['student']) && $iNew->esc($_GET['id'])){
				if(isset($_GET['delete'])){
					$delete = $iNew->dbCon->prepare("DELETE FROM `gs_users` WHERE `id` = :id AND `acctype` = :acctype");
					$delete->execute(array("id" => $iNew->esc($_GET['id']), "acctype" => 2));
					if($delete->rowCount() > 0){
		?>
			<div class="alert alert-danger">Account Deleted.</div>
			<script type="text/javascript">
			setTimeout(function(){
				location.href="/account.php?student";
			},3000);
			</script>
		<?php
					}
					else {
		?>
			<div class="alert alert-danger">Account doesn`t exist.<a href="/account.php?student">Click Here</a> to get back.</div>
		<?php
					}
				}
				else {
					$selectS = $iNew->dbCon->prepare("SELECT * FROM `gs_users` WHERE `id` = :id AND `acctype` = :acctype");
					$selectS->execute(array("id"=>$iNew->esc($_GET['id']),"acctype"=>2));
					if($selectS->rowCount() > 0){
						$dataS = $selectS->fetch();
						$fname = $iNew->esc($dataS['fname']);
						$lname = $iNew->esc($dataS['lname']);
						$username = $iNew->esc($dataS['fname']);
						$course = $iNew->esc($dataS['course']);
		?>
			<div class="panel panel-info">
				<div class="panel-heading">
					Edit <font color="#e74c3c"><?php echo $fname; ?> <?php echo $lname; ?></font>`s Account
				</div>
				<div class="panel-body">
					<form class="editStudent" data-id="<?php echo $iNew->esc($_GET['id']); ?>">
						<div class="form-group">
							<label for="fname">First Name : </label>
							<input type="input" class="form-control" id="fname" value="<?php echo $fname ?>" placeholder="First Name" required>
						</div>
						<div class="form-group">
							<label for="lname">Last Name : </label>
							<input type="input" class="form-control" id="lname" value="<?php echo $lname ?>" placeholder="Last Name" required>
						</div>
						<div class="form-group">
							<label for="username">Username : </label>
							<input type="input" class="form-control" id="username" value="<?php echo $username ?>" placeholder="Username" required disabled>
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control" id="password" placeholder="Password">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<select id="course" class="form-control">
							    <option value="<?php echo $course; ?>">
							    	<?php 
							    		if($course == "BS-IT"){
							    			echo "BS in Information Technology";
							    		}
							    		else if ($course == "BS-CS"){
							    			echo "BS in Computer Science";
							    		}
							    		else if ($course == "BS-HRM"){
							    			echo "BS in Hotel & Restaurant Management";
							    		}
							    		else if ($course == "BS-BA"){
							    			echo "Bachelor of Science in Business Administration";
							    		}
							    		else{
							    			echo "Bachelor of Science in Accountancy";
							    		}
							    	?>
							    </option>
							    <option value="BS-IT">BS in Information Technology</option>
							    <option value="BS-CS">BS in Computer Science</option>
							    <option value="BS-HRM">BS in Hotel & Restaurant Management</option>
							    <option value="BS-BA">Bachelor of Science in Business Administration</option>
							    <option value="BS-A">Bachelor of Science in Accountancy</option>
							</select>
						</div>
						<a href="account.php?student" class="btn btn-warning">Back to Student`s Account list</a>
						<a href="account.php?student&delete&id=<?php echo $iNew->esc($_GET['id']); ?>" class="btn btn-danger" onclick="return confirm('Do you really want to delete it?');">Delete</a>
					  	<button type="submit" class="btn btn-primary editStudentButt">Edit</button>
					</form>
				</div>
			</div>
		<?php
					}
					else {
						echo '<div class="alert alert-danger">This account doesn`t exist. <a href="/account.php?student">Click here</a> to get back.</div>';
					}
				}
			}
			else if (isset($_GET['prof'])){
		?>
			<!-- List of Professor`s Account -->
			<div class="panel panel-info">
				<div class="panel-heading">
					List of Professor`s Account <button class="btn btn-success pull-right"  data-toggle="modal" data-target="#addInstructor">Add</button>
					<div style="clear:both"></div>
				</div>
				<div class="panel-body">
					<table class="table table-striped">
					  <thead style="font-weight:bolder">
						  <tr>
						  	<td>Instructor</td>
						  	<td>Action</td>
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
					  		<td><a href="account.php?prof&id=<?php echo $a['id']; ?>"><?php echo $iNew->esc($a['fname'])." ".$iNew->esc($a['lname']); ?>(<?php echo $iNew->esc($a['username']); ?>)</a></td>
					  		<td><a href="/account.php?prof&delete&id=<?php echo $a['id']; ?>" onclick="return confirm('Do you really want to delete it?');">Delete</a>|<a href="/account.php?prof&id=<?php echo $a['id']; ?>">Edit</a></td>
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
		<?php
		}
		else if(isset($_GET['student'])){
		?>
			<!-- List of Student`s Accounts -->
			<div class="panel panel-info">
				<div class="panel-heading">
					List of Student`s Account <button class="btn btn-success pull-right"  data-toggle="modal" data-target="#addStudent">Add</button>
					<div style="clear:both"></div>
				</div>
				<div class="panel-body">
					<table class="table table-striped">
					  <thead style="font-weight:bolder">
						  <tr>
						  	<td>Student Name</td>
						  	<td>Action</td>
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
					  		<td><a href="account.php?student&id=<?php echo $a['id']; ?>"><?php echo $iNew->esc($a['fname'])." ".$iNew->esc($a['lname']); ?>(<?php echo $iNew->esc($a['username']); ?>)</a></td>
					  		<td><a href="/account.php?student&delete&id=<?php echo $a['id']; ?>" onclick="return confirm('Do you really want to delete it?');">Delete</a>|<a href="/account.php?student&id=<?php echo $a['id']; ?>">Edit</a></td>
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
		else {
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
						  	<td>Instructor</td>
						  	<td>Action</td>
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
					  		<td><a href="account.php?prof&id=<?php echo $a['id']; ?>"><?php echo $iNew->esc($a['fname'])." ".$iNew->esc($a['lname']); ?>(<?php echo $iNew->esc($a['username']); ?>)</a></td>
					  		<td><a href="/account.php?prof&delete&id=<?php echo $a['id']; ?>" onclick="return confirm('Do you really want to delete it?');">Delete</a>|<a href="/account.php?prof&id=<?php echo $a['id']; ?>">Edit</a></td>
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
					List of Student`s Account <button class="btn btn-success pull-right"  data-toggle="modal" data-target="#addStudent">Add</button>  <a href="/account.php?student" class="btn btn-warning pull-right">See All</a>
					<div style="clear:both"></div>
				</div>
				<div class="panel-body">
					<table class="table table-striped">
					  <thead style="font-weight:bolder">
						  <tr>
						  	<td>Student Name</td>
						  	<td>Action</td>
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
					  		<td><a href="account.php?student&id=<?php echo $a['id']; ?>"><?php echo $iNew->esc($a['fname'])." ".$iNew->esc($a['lname']); ?>(<?php echo $iNew->esc($a['username']); ?>)</a></td>
					  		<td><a href="/account.php?student&delete&id=<?php echo $a['id']; ?>" onclick="return confirm('Do you really want to delete it?');">Delete</a>|<a href="/account.php?student&id=<?php echo $a['id']; ?>">Edit</a></td>
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
		<?php } ?>
		</div>
	</div>
</div>
<?php include('footer.php'); ?>