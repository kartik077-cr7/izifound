<?php
session_start();
if(!isset($_SESSION['admin_college']))
{
	$_SESSION['error'] = "Not authorised to Update";
	header("Location:index.php");
	return;
}
?>
<html>  
<head>
  <style type="text/css">
    form
    {
      background-color: white;
      opacity: 0.8;
      margin-left: 35%;
      margin-right: 35%;
    }
  </style>
</head>
<body style="background-image: url('Images/green-2.jpg');
image-rendering: pixelated;
 image-rendering: -webkit-optimize-contrast;
  height: 100%;

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
 color: black;"> 
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
<h1>User Registration/Updation Form</h1>    
<form action="update_user_part2.php" method="post"> 
<table cellpadding = "10">  
<tr>                    
<td>Provider Email*</td>                                          
<td><input type="email" name="Email" maxlength="25"></td> 
</tr> 
<tr>  
<td>Name</td> 
<td><input type="text" name="Name" maxlength="15"></td> 
</tr>
<td>Username</td> 
<td><input type="text" name="Username" maxlength="10"></td> 
</tr> 
<td>Password</td> 
<td><input type="password" name="Password" maxlength="10"></td> 
</tr> 
<td><input type="submit" name="submit" value="Insert"></td> 
<td><input type="submit" name="submit" value="Cancel"></td>
<td><input type="submit" name="submit" value="Delete"></td> 
</tr> 
</table> 
</form> 
</center> 
</body> 
</html>