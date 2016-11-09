<?php 
	require 'db/connection.php';
	session_start();
	$_SESSION['hotelid'] = '88';
	if(!isset($_SESSION['hotelid'])){
		header("refresh:0;url=hotels.php");
	}
	$hotel = $_SESSION['hotelid'];
	$query = ("SELECT name FROM hotel WHERE hotelID = $hotel"); 
	$result = mysqli_query($db, $query) or die('Error querying from database.');
	if (mysqli_num_rows($result)>0){
		while($row = mysqli_fetch_assoc($result)) {
			$hotelName = $row["name"];
		}
	}else{
		//echo "0 results";
	}
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>pickRoom</title>
		<meta charset="utf-8">
 		<meta name="viewport" content="width=device-width, initial-scale=1">
  		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
		<!--topbanner spanning whole width on top of page-->
		<div class="topbanner">
			<img class="img-responsive" src="images/banner-project.jpg"/>
			<br />
		</div>
		
		<!--the rest of the page-->
		<div class="container-fluid">
			<div class="row">
				<!--leftbanner-->
				<div class="col-sm-2">
					<img class="img-responsive" src="images/ARNAbanner.PNG"/>
				</div>

				<!--mainroompickpart-->
				<div class="col-sm-10">
					<div class="container-fluid" style="border:solid 1px black;">
						<div class="row">
							<div class="col-sm-3">
								<h4><?php if(isset($hotelName)){echo $hotelName;}else{echo "This hotel does not exist.";}; ?><!--insert hotel name--></h4>
								<!--image of the hotel(now it is the logo)-->
								<img class="img-responsive" src="images/hotels/<?php echo str_replace(" ", "", strtolower($hotelName)); ?>">
								<h4>Facilities:</h4>
								<ul>
									<?php
									
									$query = ("SELECT * FROM facilities WHERE HOTEL_hotelID = $hotel"); 
									$result = mysqli_query($db, $query) or die('Error querying from database.');
									if (mysqli_num_rows($result)>0){
										while($row = mysqli_fetch_assoc($result)) {
											foreach($row as $key => $value){
												if($value == 1 ){
													echo "<li>".ucfirst(preg_replace('/(?<!\ )[A-Z]/', ' $0', $key))."</li>";
												}
											}
										}
									}else{
										echo "<li>None</li>";
									}
									?>
								</ul>
							</div>	
							
							<!--insert rooms etc here-->
							<!--get amount of rooms in hotel, then go print this for every room -->	
							<div class="col-sm-9">
								<br />
								<?php
									
									$query = ("SELECT * FROM room WHERE Hotel_hotelID = $hotel"); 
									$result = mysqli_query($db, $query) or die('Error querying from database.');
									if (mysqli_num_rows($result)>0){
										while($row = mysqli_fetch_assoc($result)) {
											$roomType = $row["TYPE"];	
											echo 
												"<div class=\"container-fluid\" style=\"border:solid 1px black;\">
													<div class=\"row\">
														<div class=\"col-sm-3\">".			
															"<p>Roomname: " . $row["TYPE"]. "</p>".
															"<p>Beds: " .$row["beds"]. "</p>".
															"<p>Price: ".$row["price"]. "</p>".
														"</div>
														<div class=\"col-sm-6\">
															<img class=\"img-responsive\" src=\"images/rooms/" .strtolower($row["TYPE"]) . "\">
														</div>
														<div class=\"col-sm-3\">
														<br />
														<a href=\"index.php\" class=\"confirmation\"><button>Book now!</button></a>								
															<script type=\"text/javascript\">
																$('.confirmation').on('click', function () {
																	return confirm('Are you sure?\\nDo you want to confirm this room and hotel?');
																});
															</script>
														</div>
													</div>
												</div><br />";						
										}
									}else{
										echo "No rooms";
									}
									mysqli_close($db); 
								?>
							</div>
						</div>
					</div>
				</div>
			</div>	
		</div>
	</body>
</html>

