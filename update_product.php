<?php
session_start();
if(!isset($_SESSION['admin_college']))
{
	$_SESSION['error'] = "Not authorised to Update";
	header("Location:main.php");
	return;
}
?>
<html>  
<body>  
<center>                              
<?php
     if (isset($_SESSION['success'])) 
      {
	    echo "<p align='center' style='color:green;'>" . $_SESSION['success'] . "</p>";
        unset($_SESSION['success']);
       }
     
     if (isset($_SESSION['error'])) 
       {
	    echo "<p align='center' style='color:red;'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
       }
?>        
<h1>Product Registration/Updation Form</h1>    
<form action="update_product_part2.php" method="post"> 
<table cellpadding = "10">  

<tr>
<td>Product ID</td> 
<td><input type="text" name="Product_id" maxlength="10" required="required"></td> 
</tr> 

<tr>  
<td>Product Name</td> 
<td><input type="text" name="Product_name" maxlength="30"></td> 
</tr>

<td><input type="submit" name="submit" value="Insert"></td> 
<td></td>
<td><input type="submit" name="submit" value="Delete"></td> 
</tr> 
</table> 
</form> 
</center> 
</body> 
</html>