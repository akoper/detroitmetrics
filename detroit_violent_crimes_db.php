<?php
// recieve AJAX ping from client/JS, query database, pack result into JSON, and send back to JS script
//$conn = mysql_connect("localhost","root","");
//mysql_select_db("metrics",$conn);
$conn = mysql_connect("localhost","workflow_metrics","metrics");
mysql_select_db("workflow_metrics",$conn);

$sql = "SELECT year,d_murder,d_rape,d_robbery,d_assault,d_burglary,d_larceny,d_motor_vehicle_theft 
FROM metrics WHERE year 
IN ('1995','1996','1997','1998','1999','2000','2001','2002','2003','2004','2005','2006','2007','2008','2009','2010')";

$sth = mysql_query($sql, $conn) or die(mysql_error());

//start the json data in the format Google Chart js/API expects to recieve it
//the columns - labels, value, type - are hardcoded b/c we expect only the data to change
$JSONdata = "{
			  \"cols\": [
			        {\"label\":\"Year\",\"type\":\"string\"},
			        {\"label\":\"Murders\",\"type\":\"number\"},
			        {\"label\":\"Rapes\",\"type\":\"number\"},
			        {\"label\":\"Robberies\",\"type\":\"number\"},
			        {\"label\":\"Assaults\",\"type\":\"number\"},
			        {\"label\":\"Burgleries\",\"type\":\"number\"},
			        {\"label\":\"Larcenies\",\"type\":\"number\"},
			        {\"label\":\"Motor Vehicle Thefts\",\"type\":\"number\"}
			      ],
			  \"rows\": [";

//loop through the db query result set and put into the chart cell values (note last ojbect in array has "," behind it but its working)
while($r = mysql_fetch_assoc($sth)) {
	//future dates have a val of "0" which we need to change to null for JavaScript
   //$d_pop = $r['d_pop'] != "0" ? $r['d_pop'] : "null";
   //$m_pop = $r['m_pop'] != "0" ? $r['m_pop'] : "null";
   $JSONdata .= "{\"c\":[{\"v\": " . $r['year'] . "}, {\"v\": " . $r['d_murder'] . "}, {\"v\": " . $r['d_rape'] . "}, {\"v\": " . $r['d_robbery'] . "}, {\"v\": " . $r['d_assault'] . "}, {\"v\": " . $r['d_burglary'] . "}, {\"v\": " . $r['d_larceny'] . "}, {\"v\": " . $r['d_motor_vehicle_theft'] . "}]},";

}    

//end the json data/object literal with the correct syntax
$JSONdata .= "]}";

echo $JSONdata;

mysql_close($conn);
?>