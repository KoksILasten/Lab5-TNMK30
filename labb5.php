<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" \>
    <title>Labb 4</title>
    <link href="lab5styles.css" media="screen" rel="stylesheet" type="text/css"/>
</head>
<body>
<h2> Inventory of set 375-2:</h2>
<h3>Parts in set:</h3>
<div>
<table id="partstable">
	<tr>
		<th>Quantity</th>
		<th>File name</th>
		<th>Pictures</th>
		<th>Colour</th>
		<th>Part name</th>
	</tr>
	
<?php

error_reporting(E_ALL);
ini_set("display_errors",1);

$con = mysqli_connect("mysql.itn.liu.se", "lego", "", "lego");
if(!$con){
	die("Error, Could not connect to server");
}else{
	$query = "SELECT inventory.Quantity, inventory.itemTypeID, inventory.ItemID, inventory.ColorID, colors.Colorname, parts.Partname FROM inventory, parts, colors
	WHERE inventory.SetID='375-2' AND inventory.ItemTypeID='P' AND inventory.ItemID=parts.PartID AND inventory.ColorID=colors.ColorID";

	$cont = mysqli_query($con, $query);

	while($row = mysqli_fetch_array($cont)){
		
		$quant = $row['Quantity'];
		$colorID = $row['ColorID'];
		$itemID = $row['ItemID'];
		$colorname = $row['Colorname'];
		$partname = $row['Partname'];
		
		$link = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
		$imgquery = "SELECT * FROM images WHERE ItemID='$itemID' AND ColorID='$colorID'"; // * = Alla 
		$imgrow = mysqli_query($con, $imgquery);
		$imginfo = mysqli_fetch_array($imgrow);
		
		if($imginfo['has_gif']){
			$filename = "P/$colorID/$itemID.gif";
		}else if($imginfo['has_jpg']){
			$filename = "P/$colorID/$itemID.jpg";
		}else{
			$filename = "P/0/128stk01.jpg";
		}
		$path = $link . $filename; 
		
		print("<tr>");
		print("<td>$quant</td>");
		print("<td>$filename</td>");
		print("<td><img src=$path alt=\"Image of lego part\"></td>");
		print("<td>$colorname</td>");
		print("<td>$partname</td>");
		print("</tr>");
		
		
	} //while
}
mysqli_close($con);
?>

			</table>
		</div>
	</body>
</html>
