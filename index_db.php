<?php
// recieve AJAX ping from client/JS, query database, pack result into JSON, and send back to JS script
//$conn = mysql_connect("localhost","root","");
//mysql_select_db("metrics",$conn);
$conn = mysql_connect("localhost","workflow_metrics","metrics");
mysql_select_db("workflow_metrics",$conn);

$sql = "SELECT year,d_pop FROM metrics WHERE year IN ('1940','1950','1960','1970','1980','1990','2000','2010','2020','2030')";

$sth = mysql_query($sql, $conn) or die(mysql_error());

//start the json data in the format Google Chart js/API expects to recieve it
//the columns - labels, value, type - are hardcoded b/c we expect only the data to change
$JSONdata = "{
			  \"cols\": [
			        {\"label\":\"Year\",\"type\":\"string\"},
			        {\"label\":\"Detroit Population\",\"type\":\"number\"}
			      ],
			  \"rows\": [";

//loop through the db query result set and put into the chart cell values (note last ojbect in array has "," behind it but its working)
while($r = mysql_fetch_assoc($sth)) {
	//future dates have a val of "0" which we need to change to null for JavaScript
   $d_pop = $r['d_pop'] != "0" ? $r['d_pop'] : "null";
   $JSONdata .= "{\"c\":[{\"v\": " . $r['year'] . "}, {\"v\": " . $d_pop . "}]},";

}    

//end the json data/object literal with the correct syntax
$JSONdata .= "]}";

echo $JSONdata;

mysql_close($conn);
?>