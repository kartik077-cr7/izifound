<?php
session_start();
if(!isset($_GET['product_id']))
{
	$_SESSION['error'] = "Don't Jump Directly";
	header("Location:main.php");
	return;
}
    
    $product_id = $_GET['product_id'];
    $link = mysqli_connect('localhost','root','',"izifound");  

	if(!$link)
	{ 
	  die('Failed to connect to server: ' . mysqli_error($link));
	}
	 $qry = "SELECT * FROM intermediate where product_id = '$product_id'"; 
	 $result = mysqli_query($link,$qry);

	 $qry3 = "SELECT Product_name from product where product_id ='$product_id' ";
		$result3 = mysqli_query($link,$qry3);
	$row3 = mysqli_fetch_assoc($result3);
    echo '<h1 style="text-align:center;">'.$row3["Product_name"].' Provider Details are - </h1>';
    echo  '<table border="1" style="margin-left:auto;margin-right:auto;">

	<th> Email </th> 
	 <th> Product_Name</th>
	 <th> Rent</th>
	 <th> Buy</th>
	 <th> Grab It</th>
	 ';
	 
	    while ($row = mysqli_fetch_assoc($result))
	{ 

		$product_id = $row['product_id'];
		$qry2 = "SELECT Product_name from product where product_id ='$product_id' ";
		$result2 = mysqli_query($link,$qry2);
	$row2 = mysqli_fetch_assoc($result2);

	echo '<tr> 
	<td>'.$row['email'].'</td>
	<td>'.$row2['Product_name'].'</td>
	<td>'.$row['RENT'].'</td>
	<td>'.$row['Buy'].'</td>
	<td><a href = "grab.php?email='.$row['email'].'&product='.$row2['Product_name'].'">'."GRAB".'</a></td> 
	</tr>'; 
	}
 
?>