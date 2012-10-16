<?php
// recieve AJAX ping from client/JS, query database, pack result into JSON, and send back to JS script
//$conn = mysql_connect("localhost","root","");
//mysql_select_db("metrics",$conn);
$conn = mysql_connect("localhost","workflow_metrics","metrics");
mysql_select_db("workflow_metrics",$conn);

$sql = "SELECT year,d_mayor,d_council1,d_council2,d_council3,d_council4,d_council5,d_council6,d_council7,d_council8,d_council9 
FROM metrics WHERE year 
IN ('1998','1999','2000','2001','2002','2003','2004','2005','2006','2007','2008','2009','2010','2011','2012')";

$sth = mysql_query($sql, $conn) or die(mysql_error());

//start the json data in the format Google Chart js/API expects to recieve it
//the columns - labels, value, type - are hardcoded b/c we expect only the data to change
$JSONdata = "{
			  \"cols\": [
			  		{\"label\":\"Year\",\"type\":\"string\"},
			        {\"label\":\"City Council 1\",\"type\":\"number\"},
			        {\"label\":\"City Council 2\",\"type\":\"number\"},
			        {\"label\":\"City Council 3\",\"type\":\"number\"},
			        {\"label\":\"City Council 4\",\"type\":\"number\"},
			        {\"label\":\"City Council 5\",\"type\":\"number\"},
			        {\"label\":\"City Council 6\",\"type\":\"number\"},
			        {\"label\":\"City Council 7\",\"type\":\"number\"},
			        {\"label\":\"City Council 8\",\"type\":\"number\"},
			        {\"label\":\"City Council 9\",\"type\":\"number\"},
			        {\"label\":\"Mayor\",\"type\":\"number\"}
			      ],
			  \"rows\": [";

//loop through the db query result set and put into the chart cell values (note last ojbect in array has "," behind it but its working)
while($r = mysql_fetch_assoc($sth)) {
   $JSONdata .= "{\"c\":[{\"v\": " . $r['year'] . "},  {\"v\": 1, \"f\": \"" . $r['d_council1'] . "\"}, {\"v\": 2, \"f\": \"" . $r['d_council2'] . "\"}, {\"v\": 3, \"f\": \"" . $r['d_council3'] . "\"}, {\"v\": 4, \"f\": \"" . $r['d_council4'] . "\"}, {\"v\": 5, \"f\": \"" . $r['d_council5'] . "\"}, {\"v\": 6, \"f\": \"" . $r['d_council6'] . "\"}, {\"v\": 7, \"f\": \"" . $r['d_council7'] . "\"}, {\"v\": 8, \"f\": \"" . $r['d_council8'] . "\"}, {\"v\": 9, \"f\": \"" . $r['d_council9'] . "\"}, {\"v\": 10, \"f\": \"" . $r['d_mayor'] . "\"},]},";
}    

//end the json data/object literal with the correct syntax
$JSONdata .= "]}";

echo $JSONdata;

mysql_close($conn);
?>