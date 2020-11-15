<?php
session_start();
header("Access-Control-Allow-Origin: *");
	$host = "fifadb.cq170artqy4j.ap-southeast-1.rds.amazonaws.com";
	$user = "fifa";
	$pass = "fifa_2bkmutt";
	$db_name = "image_innocent";
	$connect = mysqli_connect($host,$user,$pass,$db_name);
    if(isset($_GET['register'])){
        $reg_id=$_POST['username'];
        $reg_pass=$_POST['password'];
        $reg_name=$_POST['uname'];
        $sql = "INSERT INTO tb_login (login_id, login_pass, login_name) VALUES ('$reg_id', '$reg_pass', '$reg_name')";
        $sql1 = "select login_id from tb_login where login_id='$reg_id'";
        $row = mysqli_query($connect, $sql1);
        $_SESSION['name']=$_POST['uname'];
        $_SESSION['userid']=$_POST['username'];
        if(mysqli_num_rows($row) > 0){
            exit(false);
            //echo "Email is used";
        }else{
            mysqli_query($connect, $sql);
            exit(true);
            // echo "<script>alert(Register success welcome : '$reg_name');</script>";
            // header('Location:upload.html');
        }
    }
    if(isset($_GET['logout'])){
        unset($_SESSION['name']);
        unset($_SESSION['userid']);
        exit(true);
    }
    if(isset($_GET['logincheck'])){
        if(isset($_SESSION['name'])){
            exit(true);
            //header('Location:upload.html');
        }else{
            exit(false);
            //header('Location:login.html');
        }
    }
    if(isset($_GET['login'])){
        $username=$_POST['username'];
        $password=$_POST['password'];
        $query="select * from tb_login where login_id='$username' and login_pass='$password'";
        $sql=mysqli_query($connect, $query);
        if(mysqli_num_rows($sql) > 0){
            $who1 = mysqli_fetch_assoc($sql);
            $_SESSION['userid']=$who1['login_id'];
            $_SESSION['name']=$who1['login_name'];
            exit(true);
            //header('Location:upload.html');
        }else{
            echo "<script>alert('Email or password is wrong');window.history.back()</script>";
            //header('Location:login.html');
        }
    }
    if(isset($_GET['upload'])){
    	if ( 0 < $_FILES['file']['error'] ) {
         	echo 'Error: ' . $_FILES['file']['error'];
     	}
     	else {
     	$show = pathinfo($_FILES['file']['name']);
        //echo ($show['extension']);
         	if(move_uploaded_file($_FILES['file']['tmp_name'],/* 'uploads/' .*/ $_FILES['file']['name'])){
	         	if($show['extension'] == 'jpg' || $show['extension'] == 'JPG' || $show['extension'] == 'jpeg' || $show['extension'] == 'JPEG' || $show['extension'] == 'png' || $show['extension'] == 'PNG' || $show['extension'] == 'gif' || $show['extension'] == 'GIF'){
		         	$md5_result = md5_file(/*'uploads/'.*/$_FILES['file']['name']);
                    $uname=$_SESSION['name'];
                    $uid=$_SESSION['userid'];
		         	$sql = "INSERT INTO tb_img (img_md5, login_id) VALUES ('$md5_result', '$uid')";
		         	$sql1 = "select img_md5 from tb_img where img_md5='$md5_result'";
		         	$row = mysqli_query($connect, $sql1);
		         	if(mysqli_num_rows($row) > 0){
		         		echo "Image is uploaded";
		         	}else{
		         		mysqli_query($connect, $sql);
		         		echo ("Upload success your md5 is : ".$md5_result);
		         	}
	         	}else{
	         		echo "File isn't supported";
	         	}
         	unlink(/*'uploads/'.*/$_FILES['file']['name']);
        }
     }
    }
    if(isset($_GET['check'])){
    	if ( 0 < $_FILES['file']['error'] ) {
         echo 'Error: ' . $_FILES['file']['error'];
     	}
     else {
         if(move_uploaded_file($_FILES['file']['tmp_name'],/* 'uploads/' .*/ $_FILES['file']['name'])){
         	//echo (explode(".",$_FILES['file']['name']));
         	$md5_result = md5_file(/*'uploads/'.*/$_FILES['file']['name']);
         	//echo ($_FILES['file']['name']);
         	$sql1 = "select img_md5,login_id from tb_img where img_md5='$md5_result'";
         	$row = mysqli_query($connect, $sql1);
         	$who = mysqli_fetch_assoc($row);
            $a0 = $who['login_id'];
            $a1 = "select login_name from tb_login where login_id='$a0'";
            $a2 = mysqli_query($connect, $a1);
            $a3 = mysqli_fetch_assoc($a2);
         	if(mysqli_num_rows($row) > 0){
         		echo "Not modified Owner is : ".$a3['login_name'];
         	}else{
         		echo "Modified or No Data";
         	}
         	unlink(/*'uploads/'.*/$_FILES['file']['name']);
         }
     }
    }
//   echo "HERE"; 
?>