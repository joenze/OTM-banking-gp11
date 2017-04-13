<?php
session_start();
error_reporting(0);
include("dbconnection.php");

if(!(isset($_SESSION['customerid'])))
    header('Location:login.php?error=nologin');

$result = mysql_query("select * from registered_payee WHERE customer_id='$_SESSION[customer_id]'");
?>
<html>
<head>
<?php  include('header.php'); ?>
<link href="css/LoginPageStyle.css" rel="stylesheet" type="text/css" />
<link href="images/Dashboard-512.png" rel="shortcut icon">
</head>
<body>
    <?php include('nav2.php'); ?>
   <div class="container ">
              <div class="row">
             <div class="col-sm-10 col-md-offset-1">
    
<div class="panel panel-primary">
    <div class="panel-body">

    <div>
        
        	<h2  style="color:#3399CC;margin-left:40px; text-decoration:underline;">Fund Transfer</h2>

        	<form id="form1" name="form1" method="post" action="">
        	  <p style="font-size:18px;">Fund Transfer menu provide you to make fund transfers between your different accounts as well as making a transfer to a third party. You can even make an enquiry about your transfers and view the pending transfers through this menu.</p>
       	  </form>
     		
    </div>
    
    <div class='col-md-4' >
        <h2  style="color:#3399CC;margin-left:40px; text-decoration:underline;">Transfer Funds</h2>
         
                <ul>
                <li><a href="addexternalpayee.php">Add External Payee</a></li>
                <li><a href="viewexternalpayee.php">View registered Payee</a></li>
                <li><a href="Makepayment.php">Make a Payement</a></li>
                <li><a href="Transactionmade.php?pst=Complete">Payements Made</a></li>
                </ul>
    </div>
</div>
</div>
                  </div>
       </div>
    </div>
<?php include'footer.php' ?>
    
</body>
</html>
