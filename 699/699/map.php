<html>
	<head>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_qZQB6TCC25UFeh-ZzmiQSCeU4JD3pzI&callback=initMap" type="text/javascript"></script>
	<link rel="stylesheet" href="assets/demo.css">
	<link rel="stylesheet" href="assets/form-mini.css">
	</head>
	<body>
		<header>
			
				<img src="logo.png" align="left" style="vertical-align:middle;"height="50px">
			

	  		<h1 style="padding-top: 5px; padding-left: 17px;">
	  			Outbreak monitoring over IITB</h1>
	          	<a href="index.html">Back</a>
	      		</header>
				<?php
				$conn = new mysqli("localhost","phpmyadmin1","vaishu","cs699");
					if ($conn->connect_error) {
						echo("Connection failed!!!!!!!!!!!: " . $conn->connect_error);

					}

							// $sql = "SELECT * FROM gps WHERE 1";
							// $result = $conn->query($sql);
							// if ($result->num_rows > 0) {
							// 	echo '<table border="1" align="center"><tr><th>Hostel</th><th>Latitude</th><th>Longitude</th></tr>';
							// 	while($row = $result->fetch_assoc()) 
							// 		echo '<tr><td class="text-left" style="background:#FFFFFF;text-align:left;vertical-align:middle;font-weight:300;text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);">'. $row["hostel"].'</td><td class="text-left" style="background:#FFFFFF;text-align:left;vertical-align:middle;font-weight:300;text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);">'. $row["lat"].'</td><td class="text-left" style="background:#FFFFFF;text-align:left;vertical-align:middle;font-weight:300;text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);">'. $row["lng"].'</td></tr>';
							// 	echo "<tr><td colspan='5'>".$result->num_rows." records found</td></tr></table>";
							// }
							// else {
							// 	echo '<table><tr><th>Id of event</th><th>Date of Event`</th><th>Start Time of event</th><th>End Time of Event</th><th>Description</th></tr>';
							// 	echo "<tr><td colspan='5'>0 Row found in database</td></tr></table>";

							// }
							// $conn->close();
							// $resarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
							// echo array_keys($result	);			
						$sql = "insert into user values(DEFAULT,'".$_GET['hostel']."','".$_GET['disease']."','".$_GET['symp']."')";
						$result = $conn->query($sql);
						//echo $result;
						if(mysqli_insert_id($conn) != 0)
						{
							echo '<script language="javascript">';
							echo 'alert("Entry recorded successfully")';
							echo '</script>';
						}

						$count_hostel[17] = 0;
					// disease array
						$disease_arr=['Heart, Lung and Other Organ Diseases','Blood and Immune System Diseases','Cancer','Injury','Brain and Nervous System Diseases','Endocrine System Diseases','Infectious and Parasitic Diseases','Pregnancy and Childbirth-Related Diseases','Inherited Diseases','Environmentally-Acquired Diseases'];
						$disease_count=array();
					//count no of people sick in hostel of a 
						for ($i=1; $i <17 ; $i++) 
						{ 
							$sql = "select * from user where hostel='".$i."'";
							$result = $conn->query($sql);
							$count_hostel[$i]=$result->num_rows;
							
							//find no of disease
							for ($j=0; $j < count($disease_arr); $j++) { 
							$sql2 = "select * from user where (hostel='".$i."'&& disease='".$disease_arr[$j]."')";
							$result2 = $conn->query($sql2);

							$disease_count[$i][$j]=$result2->num_rows;
								
							}
							
						}

						//print_r($disease_count);
						//print("<p>hostel count");
						//print_r($count_hostel);

					

				?>

				<script type="text/javascript">
				 var result = <?php echo json_encode($disease_count);?>;
				 //alert(JSON.stringify(result));
				 //Google maps API
				</script>
				<div id="map" align="" style="width: 100%; height: 100%;"></div>

			  	<script type="text/javascript">
			    var locations = [
			['1',19.1362234,72.91411670000002],
			['2',19.1363147,72.9127729],
			['3', 19.1367294, 72.9114977],
			['4', 19.1365161, 72.9101256],
			['5', 19.135069, 72.90964],
			['6', 19.1358053, 72.9070786],
			['7', 19.1343521, 72.9081447],
			['8', 19.1333055, 72.911066],
			['9', 19.1354274, 72.908137],
			['10', 19.12860354, 72.91559458],
			['11', 19.13344615, 72.91203395],
			['12', 19.1354443, 72.90416066],
			['13', 19.1350652, 72.9053384],
			['14', 19.1342672, 72.9060188],
			['15', 19.1378382, 72.9139958],
			['16',19.1377929,72.91309118,1]];

			    var map = new google.maps.Map(document.getElementById('map'), {
			      zoom: 16,
			      center: new google.maps.LatLng( 19.135069, 72.90964),
			      mapTypeId: google.maps.MapTypeId.SATELLITE
			    });

			    var infowindow = new google.maps.InfoWindow();

			    var marker, i;

			    for (i = 0; i <= locations.length; i++) {  
			      marker = new google.maps.Marker({
			        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
			        map: map
			      });

			      google.maps.event.addListener(marker, 'click', (function(marker, i) {
			      	
			      	var table='<div class="table-title" align="center" style="text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);"><b> Disease Outbreak Hostel:'+(i+1)+'</b></div><table class="table-fill" style="width:100%; ;box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);animation: float 5s infinite;background: white;">'+'<thead><tr>'+'<th class="text-left" style=" color:#D5DDE5;background:#1b1e24; solid #9ea7af;solid #343a45;  ;  font-weight: 100;    text-align:left;  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1); vertical-align:middle;">TYPE</th>'+
		    '<th class="text-left" style=" color:#D5DDE5;background:#1b1e24; solid #9ea7af; solid #343a45;    font-weight: 100;    text-align:left;  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1); vertical-align:middle;">COUNT</th>'+ 
		  '</tr></thead>'+
		  '<tbody class="table-hover">	<tr>'+	
		    '<td class="text-left" style="background:#FFFFFF;text-align:left;vertical-align:middle;font-weight:300;text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);">Heart, Lung and Other Organ Diseases</td>'+
		    '<td class="text-left" style="background:#FFFFFF;text-align:left;vertical-align:middle;font-weight:300;text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);">'+result[i+1][0]+'</td>'+ 
		    
		  '</tr>'+
		  '<tr>'+
		    '<td class="text-left" style="background:#FFFFFF;text-align:left;vertical-align:middle;font-weight:300;text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);">Blood and Immune System Diseases</td>'+
		    '<td class="text-left" style="background:#FFFFFF;text-align:left;vertical-align:middle;font-weight:300;text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);">'+result[i+1][1]+'</td> '+
		  '</tr>'+
		  '<tr>'+
		    '<td class="text-left" style="background:#FFFFFF;text-align:left;vertical-align:middle;font-weight:300;text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);">Cancer</td>'+
		    '<td class="text-left" style="background:#FFFFFF;text-align:left;vertical-align:middle;font-weight:300;text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);">'+result[i+1][2]+'</td>'+ 
		  '</tr>'+
		  '<tr>'+
		    '<td class="text-left" style="background:#FFFFFF;text-align:left;vertical-align:middle;font-weight:300;text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);">Injury</td>'+
		    '<td class="text-left" style="background:#FFFFFF;text-align:left;vertical-align:middle;font-weight:300;text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);">'+result[i+1][3]+'</td>'+ 
		  '</tr><tr>'+
		    '<td class="text-left" style="background:#FFFFFF;text-align:left;vertical-align:middle;font-weight:300;text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);">Brain and Nervous System Diseases</td>'+
		    '<td class="text-left" style="background:#FFFFFF;text-align:left;vertical-align:middle;font-weight:300;text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);">'+result[i+1][4]+'</td>'+ 
		  '</tr><tr>'+
		    '<td class="text-left" style="background:#FFFFFF;text-align:left;vertical-align:middle;font-weight:300;text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);">Endocrine System Diseases</td>'+
		    '<td class="text-left" style="background:#FFFFFF;text-align:left;vertical-align:middle;font-weight:300;text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);">'+result[i+1][5]+'</td>'+ 
		  '</tr>'+
		  '<tr>'+
		    '<td class="text-left" style="background:#FFFFFF;text-align:left;vertical-align:middle;font-weight:300;text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);">Infectious and Parasitic Diseases</td>'+
		    '<td class="text-left" style="background:#FFFFFF;text-align:left;vertical-align:middle;font-weight:300;text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);">'+result[i+1][6]+'</td>'+ 
		  '</tr>'+
		  '<tr>'+
		    '<td class="text-left" style="background:#FFFFFF;text-align:left;vertical-align:middle;font-weight:300;text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);">Pregnancy and Childbirth-Related Diseases</td>'+
		    '<td class="text-left" style="background:#FFFFFF;text-align:left;vertical-align:middle;font-weight:300;text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);">'+result[i+1][7]+'</td>' +
		  '</tr>'+
		  '<tr>'+
		    '<td class="text-left" style="background:#FFFFFF;text-align:left;vertical-align:middle;font-weight:300;text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);">Inherited Diseases</td>'+
		    '<td class="text-left" style="background:#FFFFFF;text-align:left;vertical-align:middle;font-weight:300;text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);">'+result[i+1][8]+'</td>' +
		  '</tr>'+
		  '<tr>'+
		    '<td class="text-left" style="background:#FFFFFF;text-align:left;vertical-align:middle;font-weight:300;text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);">Environmentally-Acquired Diseases</td>'+
		    '<td class="text-left" style="background:#FFFFFF;text-align:left;vertical-align:middle;font-weight:300;text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);">'+result[i+1][9]+'</td> '+

		  '</tr>'+'</tbody>	</table>'



			        return function() {
			          infowindow.setContent(table);
			          infowindow.open(map, marker);
			        }
			      })(marker, i));
			    }
			  </script>



				</body>
				</html>

