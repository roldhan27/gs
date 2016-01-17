<?php
include('./config.php');
$gs_func = new gs_func();
try {
	switch ($_GET['do']) {
		case 'login':
			$balik = $gs_func->logIn($_POST['uname'],$_POST['pword']);
			break;

		case 'addInstructor':
			$balik = $gs_func->addInstructor($_POST['username'],$_POST['password'],$_POST['fname'],$_POST['lname']);
			break;

		case 'addStudent':
			$balik = $gs_func->addStudent($_POST['username'],$_POST['password'],$_POST['fname'],$_POST['lname'],$_POST['course']);
			break;

		case 'addAcademic':
			$balik = $gs_func->addAcademic($_POST['subjectn'],$_POST['subjectc'],$_POST['prof']);
			break;

		case 'editInstructor':
			$balik = $gs_func->editInstructor($_POST['id'],$_POST['fname'],$_POST['lname'],$_POST['password']);
			break;

		case 'editStudent':
			$balik = $gs_func->editStudent($_POST['id'],$_POST['fname'],$_POST['lname'],$_POST['password'],$_POST['course']);
			break;

		case 'logOut':
			$balik = $gs_func->logOut();
			break;
		
		default:
			$balik = "Invalid parameter";
			break;
	}

	echo json_encode($balik);
}
catch(exception $e){
	echo $e." Opps!!";
}
class gs_func {

	public function logIn($username,$password){
		if(!isset($_SESSION['ses_id'])){
			$iNew = new iNew_dbConnect();
			$chk = $iNew->dbCon->prepare("SELECT * FROM `gs_users` WHERE `username` = ?");
			$chk->bindValue(1,$this->esc($username));
			$chk->execute();
			if($chk->rowCount() > 0){
				$data = $chk->fetch();
				if($data['password'] == md5($password)){
					$upd = $iNew->dbCon->prepare('UPDATE `gs_users` SET `sesid` = ? WHERE `username` = ?');
					$upd->bindValue(1,md5(microtime()));
					$upd->bindValue(2,$this->esc($username));
					$upd->execute();
					$_SESSION['ses_id'] = md5(microtime());
					$_SESSION['accessed'] = true;
					$_SESSION['fname'] = $data['fname'];
					$_SESSION['lname'] = $data['lname'];
					$_SESSION['username'] = $data['username'];
					$_SESSION['acctype'] = $data['acctype'];
					$_SESSION['course'] = $data['course'];
					return $this->tagaBalik("You have successfully logged in! :)<br>Welcome ".$data['fname']." ".$data['lname']."<br>You`ll be redirected in member page in 5 seconds.<script>window.setTimeout(function(){window.location='members.php'},5000);</script>",1);
				}
				else {
					return $this->tagaBalik("Password is not valid!",0);
				}
			}
			else {
				return $this->tagaBalik('Username('.$username.') is not valid.',0);
			}
		}
		else {
			return $this->tagaBalik('You are already logged in as '.$_SESSION['uname'].'!.',0);
		}
	}

	public function logOut(){
		unset($_SESSION['ses_id']);
		session_destroy();
		echo "<script>window.location='../'</script>";
	}

	//add instructor account
	public function addInstructor($username,$password,$fname,$lname){
		if(isset($_SESSION['ses_id'])){
			$iNew = new iNew_dbConnect();
			$addcheck = $iNew->dbCon->prepare("SELECT `username` FROM `gs_users` WHERE `username` = :username");
			$addcheck->execute(array('username' => $username));
			$addcheck2 = $iNew->dbCon->prepare("SELECT `fname`,`lname` FROM `gs_users` WHERE `fname` = :fname AND `lname` = :lname");
			$addcheck2->execute(array('fname' => $fname,'lname' => $lname));
			if($addcheck->rowCount() > 0){
				return $this->tagaBalik("Username already used",0);
			}
			else if($addcheck2->rowCount() > 0){
				return $this->tagaBalik("Name already in the record",0);
			}
			else{
				$add = $iNew->dbCon->prepare("INSERT INTO `gs_users`(`sesid`,`username`,`password`,`fname`,`lname`,`acctype`) VALUES(:sesid,:username,:password,:fname,:lname,:acctype)");
				$add->execute(array(
						"sesid" => md5(microtime()),
						"username" => $this->esc($username),
						"password" => md5($password),
						"fname" => $this->esc($fname),
						"lname" => $this->esc($lname),
						"acctype" => 1
					));
				return $this->tagaBalik("Successfully Added",1);
			}
		}
		else {
			return $this->tagaBalik("Please Log in",0);
		}
	}

	//add student account
	public function addStudent($username,$password,$fname,$lname,$course){
		if(isset($_SESSION['ses_id'])){
			$iNew = new iNew_dbConnect();
			$addcheck = $iNew->dbCon->prepare("SELECT `username` FROM `gs_users` WHERE `username` = :username");
			$addcheck->execute(array('username' => $username));
			$addcheck2 = $iNew->dbCon->prepare("SELECT `fname`,`lname` FROM `gs_users` WHERE `fname` = :fname AND `lname` = :lname");
			$addcheck2->execute(array('fname' => $fname,'lname' => $lname));
			if($addcheck->rowCount() > 0){
				return $this->tagaBalik("Username already used",0);
			}
			else if($addcheck2->rowCount() > 0){
				return $this->tagaBalik("Name already in the record",0);
			}
			else{
				$add = $iNew->dbCon->prepare("INSERT INTO `gs_users`(`sesid`,`username`,`password`,`fname`,`lname`,`acctype`,`course`) VALUES(:sesid,:username,:password,:fname,:lname,:acctype,:course)");
				$add->execute(array(
						"sesid" => md5(microtime()),
						"username" => $this->esc($username),
						"password" => md5($password),
						"fname" => $this->esc($fname),
						"lname" => $this->esc($lname),
						"course" => $this->esc($course),
						"acctype" => 2
					));
				return $this->tagaBalik("Successfully Added",1);
			}
		}
		else {
			return $this->tagaBalik("Please Log in",0);
		}
	}

	//add Academic Subject
	public function addAcademic($subjectn,$subjectc,$prof){
		if (isset($_SESSION['ses_id'])) {
			$iNew = new iNew_dbConnect();
			$addcheck = $iNew->dbCon->prepare("SELECT `subject_code` FROM `gs_academics` WHERE `subject_code` = :subjectc ");
			$addcheck->execute(array('subjectc' => $subjectc));
			if($addcheck->rowCount() > 0){
				return $this->tagaBalik("Subject Code already in the record",0);
			}
			else {
				$info = $iNew->dbCon->prepare("SELECT * FROM `gs_users` WHERE `username` = :prof");
				$info->execute(array('prof' => $this->esc($prof)));
				$data = $info->fetch();
				$instructor = $this->esc($data['fname'])." ".$this->esc($data['lname']);
				if($info->rowCount() > 0){
					$add = $iNew->dbCon->prepare("INSERT INTO `gs_academics`(`subject_name`,`subject_code`,`instructor`,`prof_username`) VALUES(:subjectn,:subjectc,:instructor,:prof_name)");
					$add->execute(array(
							'subjectn' => $this->esc(urldecode($subjectn)),
							'subjectc' => $this->esc($subjectc),
							'instructor' => $instructor,
							'prof_name' => $this->esc($prof)
						));
					return $this->tagaBalik("New Academic Subject Added",1);
				}
				else {
					return $this->tagaBalik("Professor account doesn't exist",0);
				}
			}
		}
		else {
			return $this->tagaBalik("Please Log in",0);
		}
	}

	//Edit Instructor
	public function editInstructor($id,$fname,$lname,$password){
		if(isset($_SESSION['ses_id'])){
			$iNew = new iNew_dbConnect();
			if(empty($password)){
				$edit = $iNew->dbCon->prepare("UPDATE `gs_users` SET `fname` = :fname, `lname` = :lname WHERE `id` = :id");
				$edit->execute(array(
					"id" => $this->esc($id),
					"fname" => $this->esc($fname),
					"lname" => $this->esc($lname)
					));
				return $this->tagaBalik("Account has been updated",1);
			}
			else {
				$edit = $iNew->dbCon->prepare("UPDATE `gs_users` SET `fname` = :fname, `lname` = :lname, `password` = :password WHERE `id` = :id");
				$edit->execute(array(
					"id" => $this->esc($id),
					"fname" => $this->esc($fname),
					"lname" => $this->esc($lname),
					"password" => md5($password)
					));
				return $this->tagaBalik("Account has been updated",1);
			}
		}
		else {
			return $this->tagaBalik("Please Log in",0);
		}
	}

	//Edit Student
	public function editStudent($id,$fname,$lname,$password,$course){
		if(isset($_SESSION['ses_id'])){
			$iNew = new iNew_dbConnect();
			if(empty($password)){
				$edit = $iNew->dbCon->prepare("UPDATE `gs_users` SET `fname` = :fname, `lname` = :lname, `course` = :course WHERE `id` = :id");
				$edit->execute(array(
					"id" => $this->esc($id),
					"fname" => $this->esc($fname),
					"lname" => $this->esc($lname),
					"course" => $this->esc($course)
					));
				return $this->tagaBalik("Account has been updated",1);
			}
			else {
				$edit = $iNew->dbCon->prepare("UPDATE `gs_users` SET `fname` = :fname, `lname` = :lname, `password` = :password, `course` = :course WHERE `id` = :id");
				$edit->execute(array(
					"id" => $this->esc($id),
					"fname" => $this->esc($fname),
					"lname" => $this->esc($lname),
					"password" => md5($password),
					"course" => $this->esc($course)
					));
				return $this->tagaBalik("Account has been updated",1);
			}
		}
		else {
			return $this->tagaBalik("Please Log in",0);
		}
	}

	public function esc($str){
		return htmlentities($str);
	}

	public function tagaBalik($text,$status){
		return array(
				'text' => $text,
				'status' => $status
			);
	}
}
?>