<?php      
session_start();
include('connection.php'); 


if (isset($_POST['submit'])) {
     // code...

    $username = $_POST['user'];  
    $password = $_POST['password'];  

    //to prevent from mysqli injection  
    $username = stripcslashes($username);  
    $password = stripcslashes($password);  
    $username = mysqli_real_escape_string($con, $username);  
    $password = mysqli_real_escape_string($con, $password);  

    $sql = "select * from pass where UserName = '$username' and Password = '$password'";  
    $result = mysqli_query($con, $sql);  
    $row = mysqli_fetch_assoc($result);  
    $count = mysqli_num_rows($result);  
    ///$EmployeeID = $row['ID'];
    if($count == 1){
        $_SESSION['user']=$row['UserName'];
        $_SESSION['userid']=$row['ID'];
        $_SESSION['usertype']=$row['UserType'];
        if ($_SESSION['usertype']=="Reporting" or $_SESSION['usertype']=='Dataentry' or $_SESSION['userid']==32) {
         header("location: reporting/reporting.php?");
     }elseif ($_SESSION['usertype']=="Reception") {
        header("location: reception/");
    }elseif ($_SESSION['usertype']=="Executive") {
        header("location: executive/");
    }elseif ($_SESSION['usertype']=="Production") {
        header("location: SaaS/protable.php");
    }elseif ($_SESSION['usertype']=="Store") {
        header("location: SaaS/storetable.php");
    }elseif ($_SESSION['usertype']=="Installation") {
        header("location: SaaS/instable.php");
    }elseif ($_SESSION['usertype']=="Sim Provider") {
        header("location: SaaS/simtable.php");
    }elseif ($_SESSION['usertype']=="Inventory") {
        header("location: inventory/");
    }elseif ($_SESSION['usertype']=="Reminders") {
        header("location: reminders/");
    }elseif ($_SESSION['usertype']=="Accounts") {
        header("location: accounts/");
    }      
}else{  
    echo '<script>alert("Invalid Username or Password")</script>';  
} 

}     
?>  


<!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="Anant Singh Suryavanshi">
        <title>Cyrus</title>
        <!-- Bootstrap core CSS -->
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="css/sign-in.css" rel="stylesheet">
        <link rel="icon" href="cyrus logo.png" type="image/icon type">
    </head>
    <body>
        <div class="container">
            <center>
                <img class="img-fluid mb-4" alt="Cyrus Logo" height="50" src="cyrus logo.png" width="50">
                <h1 class="h3 mb-3 font-weight-normal">Welcome to Cyrus</h1>
                <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
            </center>
            <form class="form-signin" action="" method="post">           
                <input type="text" id="UName" name="user" class="form-control select" placeholder="User Name" required autofocus>
                
                <input type="password" id="pass" name="password" class="form-control select" placeholder="Password" required>
                <center>
                    <button class="w-100 btn btn-lg btn-primary" type="submit" name="submit">Sign in</button>
                    <p class="mt-5 mb-3 text-muted">&copy; Cyrus Electronics Pvt. Ltd.</p>
                </center>
            </form>
        </div>
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/popper.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
    </html>
