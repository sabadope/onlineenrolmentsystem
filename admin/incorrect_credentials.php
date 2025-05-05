<?php
require_once("../include/initialize.php");

 ?>
  <?php
 if (isset($_SESSION['ACCOUNT_ID'])){
      redirect(web_root."admin/index.php");
     } 
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title>Green Valley College Foundation, Inc.</title>

<!-- Bootstrap core CSS -->
<link href="<?php echo web_root; ?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo web_root; ?>css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<link href="<?php echo web_root; ?>css/dataTables.bootstrap.css" rel="stylesheet" media="screen">
<link rel="stylesheet" type="text/css" href="<?php echo web_root; ?>css/jquery.dataTables.css"> 
<link href="<?php echo web_root; ?>css/bootstrap.css" rel="stylesheet" media="screen">

<link href="<?php echo web_root; ?>fonts/font-awesome.min.css" rel="stylesheet" media="screen">
<!-- Plugins -->
<script type="text/javascript" language="javascript" src="<?php echo web_root; ?>js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo web_root; ?>js/jquery.dataTables.js"></script>
<!-- <script type="text/javascript" language="javascript" src="<?php echo web_root; ?>js/fixnmix.js"></script> / -->


<style>
    @import url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --poppins: 'Poppins', sans-serif;

        --light: #F9F9F9;
        --blue: #3C91E6;
        --light-blue: #CFE8FF;
        --grey: #eee;
        --dark-grey: #AAAAAA;
        --dark: #342E37;
    }

    body {
        font-family: var(--poppins);
        background: var(--grey);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        overflow: hidden;

    .login-container {
        background: var(--light);
        padding: 30px 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        width: 400px;
        text-align: center;
    }

    .login-form img {
        width: 70px;
        margin-bottom: 10px;
    }

    .login-form h2 {
        color: var(--dark);
        margin-bottom: 25px;
        font-weight: 600;
        font-size: 26px;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 16px;
        width: 100%;
    }

    .input-group {
        display: flex;
        flex-direction: column;
        text-align: left;
        width: 100%;
    }

    .input-group label {
        font-weight: 600;
        color: var(--dark);
        font-size: 14px;
        margin-bottom: 6px;
    }

    .input-group input {
        padding: 10px 12px;
        border: 1px solid var(--dark-grey);
        border-radius: 6px;
        font-size: 14px;
        outline: none;
        width: 100%;
    }

    .input-group input:focus {
        border-color: var(--blue);
    }

    .btn {
        background: var(--blue);
        color: var(--light);
        border: none;
        padding: 10px;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
        transition: background 0.3s;
    }

    .btn:hover {
        background: var(--light-blue);
        color: var(--dark);
    }

    .register-link {
        margin-top: 15px;
        font-size: 14px;
    }

    .register-link a {
        color: var(--blue);
        text-decoration: none;
        font-weight: 600;
    }

    .register-link a:hover {
        text-decoration: underline;
    }
</style>
 
<body>


<div class="login-container">
  <section class="login-form">
    <?php echo check_message(); ?>
    <img src="../img/school_seal_100X100.png" alt="Logo" />
    <h2>Admin Authentication</h2>

    <form method="post" action="" role="login">
      <div class="input-group">
        <label for="user_email">Username</label>
        <input type="text" name="user_email" id="user_email" required />
      </div>

      <div class="input-group">
        <label for="user_pass">Password</label>
        <input type="password" name="user_pass" id="user_pass" required />
      </div>

      <button type="submit" name="btnLogin" class="btn">Sign in</button>
    </form>

    <div class="register-link">
      <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
  </section>
</div>
   
</body>

 <?php 

if(isset($_POST['btnLogin'])){
  $email = trim($_POST['user_email']);
  $upass  = trim($_POST['user_pass']);
  $h_upass = sha1($upass);
  
   if ($email == '' OR $upass == '') {

      message("Invalid Username and Password!", "error");
      redirect("login.php");
         
    } else {  
  //it creates a new objects of member
    $user = new User();
    //make use of the static function, and we passed to parameters
    $res = $user::userAuthentication($email, $h_upass);
    if ($res==true) { 
       message("You logon as ".$_SESSION['ACCOUNT_TYPE'].".","success");
       
       $sql="INSERT INTO `tbllogs` (`USERID`, `LOGDATETIME`, `LOGROLE`, `LOGMODE`) 
          VALUES (".$_SESSION['ACCOUNT_ID'].",'".date('Y-m-d H:i:s')."','".$_SESSION['ACCOUNT_TYPE']."','Logged in')";
          $mydb->setQuery($sql);
          $mydb->executeQuery();

      if ($_SESSION['ACCOUNT_TYPE']=='Administrator'){ 
         redirect(web_root."admin/index.php");
      }elseif($_SESSION['ACCOUNT_TYPE']=='Registrar'){
          redirect(web_root."admin/index.php");

      }else{
           redirect(web_root."admin/login.php");
      }
    }else{
      message("Account does not exist! Please contact Administrator.", "error");
       redirect(web_root."admin/login.php"); 
    }
 }
 } 
 ?> 
</head>
</html>