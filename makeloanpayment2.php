<?php
session_start();
error_reporting(0);
include("dbconnection.php");

if(!(isset($_SESSION['customerid'])))
    header('Location:login.php?error=nologin');

$dt = date("Y-m-d h:i:s");
if(isset($_POST["pay2"]))
{
$custid=  mysql_real_escape_string($_SESSION['customerid']);
$resul = mysql_query("select * from customers WHERE customerid='$custid'");
$arrpayment1 = mysql_fetch_array($resul);
if(!($_POST['trpass'] == $arrpayment1['transpassword']))
{
    $successresult = "Invalid Transaction Password";
}
else{
$rr = mysql_query("SELECT * FROM accounts WHERE customerid ='".$_SESSION['customerid']."'");
$rrarr=  mysql_fetch_array($rr);
$amount=$_POST[amt];
if ($amount>$rrarr['accountbalance'])
{
    $successresult = "Insufficient Fund!! Payment Failed";
}
else{
$sql="INSERT INTO loanpayment (customerid,paymentid,loanid,amount,paymentdate) VALUES ('$_SESSION[customerid]','','$_POST[paytoo]','$_POST[amt]','$dt')";
$sq="UPDATE accounts SET accountbalance = accountbalance -".$_POST[amt]." WHERE customerid='$_SESSION[customerid]'";
if ((!mysql_query($sql)))
  {
  die('Error: ' . mysql_error());
  print_r($sql);
  }
  if(mysql_affected_rows() == 1)
  {
	$successresult = "Transaction successfull";
  }
  else
  {
	  $successresult = "Failed to transfer";
  }
  if (!(mysql_query($sq)))
  {
      die("Error : ".mysql_error());
      print_r($sq);
  }
  if(mysql_affected_rows() == 1)
  {
	$successresult = "Transaction successfull";
  }
  else
  {
	  $successresult = "Failed to transfer";
  }
}
}
}
?>
<html>
<head>
<link href="images/Dashboard-512.png" rel="shortcut icon">
<?php include('header.php'); ?>
<link href="css/LoginPageStyle.css" rel="stylesheet" type="text/css" />

<script>
function validate()
{
var x=document.forms["form1"]["conftrpass"].value;
var y=document.forms["form1"]["trpass"].value;

if (x==null || x=="")
  {
  alert("Confirm Password must be filled out");
  return false;
  }
  if (y==null || y=="")
  {
  alert("Password must be filled out");
  return false;
  }
  if(!(x==y))
      {
          alert("Password Mismatch");
          return false;
      }
}
</script>


</head>
<body>
    <?php include('nav2.php'); ?>
    <div class="container ">
              <div class="row">
             <div class="col-sm-10 col-md-offset-1">
    
<div class="panel panel-primary" style="margin-bottom:60px;">
    <div class="panel-body">

    <div>
 
        <?php if(isset($successresult))
            echo "<h1>".$successresult."</h1>"; ?>
       <form id="form1" name="form1" method="post" action="" onsubmit="return validate()">
            <?php
			if(isset($_POST[pay]))
			{ ?>
           	<h2  style="color:#3399CC;margin-left:40px; text-decoration:underline;">Make Loan Payment</h2> 
                                
                                <table class="table table-striped" width="580" height="220" border="1">
                                    <tr>
                                        <td class="info" width="203"><strong>Loan account information</strong></td>
                                        <td class="info" width="361">
                                        <?php	
				  	$result3 = mysql_query("select * from loan WHERE loanid='$_POST[payto]'");
                                        $arrpayment3 = mysql_fetch_array($result3);
                                        $qq="SELECT * FROM loanpayment WHERE loanid='$_POST[payto]'";
                                        $x = mysql_query($qq) or die(mysql_error());
                                        $aamt=0;
                                        for($i=0;$i<mysql_num_rows($x);$i++)
                                        {
                                        $arrpayment2 = mysql_fetch_array($x);
                                        $aamt = $aamt+$arrpayment2[amount];
                                        }
                                    
                                        $balance = $arrpayment3[loanamt] + ($arrpayment3[interest]*$arrpayment3[loanamt]/100) - $aamt;
                                        echo "<b>&nbsp;Loan No. : </b>".$arrpayment3[loanid];
                                        echo "<br><b>&nbsp;Loan type. : </b>".  $arrpayment3[loantype];
				echo "<br><b>&nbsp;Loan amount : </b>".$arrpayment3[loanamt];
				echo "<br><b>&nbsp;Interest : </b>".$arrpayment3[interest]. "%";
				echo "<br><b>&nbsp;Balance : </b>".$balance;
				echo "<br><b>&nbsp;Created at : </b>".$arrpayment3[startdate];
	
                  ?>
                <input type="hidden" name="paytoo" value="<?php echo $_POST[payto]; ?>"  />
                <input type="hidden" name="amt" value="<?php echo $_POST[pay_amt]; ?>"  />
				  </td>
                </tr>
                <tr>
                  <td><strong>Loan amount</strong></td>
                  <td>&nbsp;<?php echo number_format($_POST[pay_amt],2); ?></td>
                </tr>
                <tr>
                  <td><strong>Enter Transaction Password</strong></td>
                  <td><input name="trpass" type="password" id="trpass" size="35" /></td>
                </tr>
                <tr>
                  <td><strong>Confirm Password</strong></td>
                  <td><input name="conftrpass" type="password" id="conftrpass" size="35" /></td>
                </tr>
                <tr>
                  <td colspan="2"><div align="right">
                    <input class="btn btn-primary" type="submit" name="pay2" id="pay2" value="Pay" />
                    <input class="btn btn-info" name="button" type="button" onclick="<?php echo "window.location.href='payloans.php'"; ?>" value="Cancel" alt="Pay Now" />
                  </div></td>
                </tr>
              </table>
              
              <?php
			}
			?>
       </form>
    </div>
    
    <div class="col-md-3">
        <h2  style="color:#3399CC;text-decoration:underline;">Pay Loans</h2> 
         
                <ul>
                <li><a href="viewloanac.php">View Loan Account</a></li>
                <li><a href="makeloanpayment.php">Pay loan</a></li>
                <li><a href="loanpayment.php">View Loan Payments</a></li>
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
