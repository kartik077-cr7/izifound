<?php
 session_start();

 if(!isset($_SESSION['college_seller']))
 {
 	$_SESSION['error'] = "ONLY SELLERS ARE GRANTED PERMISSION TO ACESS THEIR LOG";
 	header("Location:index.php");
 	return;
 }
 
 $link = mysqli_connect('localhost','root','','Izifound');

 if(!$link)
 {
    die('Failed to connect to server: ' . mysqli_error($link)); 
 }
 
 $email = $_SESSION['email'];
 $qry = "SELECT * FROM pendin_buyes where From_Email = '$email'";
 $result = mysqli_query($link,$qry);

 $positions = array();                    
    
    while($row = mysqli_fetch_assoc($result))
     {                      
           $positions[] = $row;
     } 


  if(isset($_POST['cancel']))
  {
    header("Location:sell_main.php");
    return;
  }
  if(isset($_POST['edit']))
  {
     $link = mysqli_connect('localhost','root','','izifound');
     
     if(!$link)
     {
      die('Failed to connect to server: ' . mysqli_error($link));
     }
     $email = $_SESSION['email'];

     
     $rank = 1;

     for($i=0;$i<9;$i++)
     {
        if(!isset($_POST['requestor'.$i]))
          continue;

        $requestor = $_POST['requestor'.$i];
        $college = $_POST['college'.$i];
        $product = $_POST['product'.$i];
        $to = $_SESSION['email'];
        $status = $_POST['status'.$i];
        $quantity = $_POST['quantity'.$i];
        $email = $_SESSION['email'];
         
         if($quantity <0)
           continue;
       if($status == "Yes")
       {
               
             $qry = "SELECT * FROM product WHERE Product_name = '$product'";
             $result = mysqli_query($link,$qry);
             $row = mysqli_fetch_assoc($result);
              
              $id = $row['product_id'];
           
            $qry = "SELECT * FROM intermediate where email = '$email' AND product_id = $id";
            $result = mysqli_query($link,$qry);
            $row = mysqli_fetch_assoc($result);
            $left = $row['Quantity'];
            
            if($left < $quantity)
            {
              $_SESSION['error'] = "Not possible to sell more than existing.Process Blocked!!!"."Only ".$left."peices are left id of ".$product;
              header("Location:provider_log.php");
              return;
            }
            else
            {
              $college = $_SESSION['college_seller'];
              $qry = "INSERT INTO history(Email,product_name,From_Email,College,Quantity,rated) VALUES('$requestor','$product','$to','$college',$quantity,0)";

            $result = mysqli_query($link,$qry);
            if($result==False)
            {
               $_SESSION['error'] = mysqli_error($link).$requestor;
              header("Location:provider_log.php");
              return;
            }

             $qry = "DELETE from pendin_buyes where From_Email = '$email' AND To_Email='$requestor' AND product_name = '$product'";
              $result = mysqli_query($link,$qry);
              

            $reval = $left-$quantity;
            $qry = "UPDATE intermediate SET Quantity=$reval where email='$email' AND product_id=$id";
            $result = mysqli_query($link,$qry);

            $qry = "INSERT INTO feedback(From_Email,To_Email,Product)
                    VALUES('$email','$requestor','$product')";
           $result = mysqli_query($link,$qry);

             }
         }
     }
                                            
     $_SESSION['success'] = "Changes saved";
        header("Location:sell_main.php");
        return;
  }
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	 <link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" 
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" 
    crossorigin="anonymous">

<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" 
    integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" 
    crossorigin="anonymous">

<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>
	<style type="text/css">
	#position_fields
{
   opacity: 0.7;
	 background-color: white;
    margin-left: 35%;
    margin-right: 30%;
}
body
{
	font-size: 2em;
}
</style>
</head>
<body style="background-image: url('Images/green.jpg');
image-rendering: pixelated;
 image-rendering: -webkit-optimize-contrast;
  height: 100%;

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
 color: black;">
	<?php 

        if(isset($_SESSION['error']))
        {
          echo "<p align='center' style='color:red;'>" . $_SESSION['error'] . "</p>";
          unset($_SESSION['error']);
        }

     
      	  if(count($positions) == 0)
      	  {
      	  	echo "<p align='center' style='color:green;'>Congrats! your log is clean</p>";

      	  }
      	  else
      {
    ?>
	<form method="post">
		<?php
	        $pos = 0;
	        echo('<div id="position_fields"><br>');
            echo("<h1 align='center'>YOUR LOG</h1>");
	        foreach($positions as $position)
	        {
	        	$pos++;
	        	echo('<div id="position'.$pos.'">');
	        	echo('<p>Requestor:<input type="text" readonly="readonly" name="requestor'.$pos.'"');
	        	echo('value = "'.$position['To_Email'].'"/>');
	        	echo('<input type = "button" value ="-" ');
                echo('onclick="$(\'#position'.$pos.'\').remove();return false;">');
                echo("</p>");
               echo('<p>College:<input type="text" readonly="readonly" name="college'.$pos.'"');
	        	echo('value = "'.$position['College'].'"/>');
                echo('<p>Product:<input type="text" readonly="readonly" name="product'.$pos.'"');
	        	echo('value = "'.$position['Product_Name'].'"/></p>');
            echo('<p>Quantity:<input type="number" required="required" name="quantity'.$pos.'"');
            echo('value = " "/>');
            echo('<p>Status: <select name="status'.$pos.'"');
            echo('value = ""/>');
            echo('<option value="Yes">Successfull</option>');
            echo('<option value="No">Pending</option></select></p>');   
                echo('<hr></div>');
	        }
	        echo("</div>");
	    ?>
	       <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <input style="margin-left: 46%;" type="submit" name="edit" value="Save">
		    <input type="submit" name="cancel" value="Cancel">
	  </form>
	  <?php
	}
	  ?>
</body>
</html>