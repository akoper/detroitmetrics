<?php
// recieve AJAX ping from client/JS, query database, pack result into JSON, and send back to JS script
//$conn = mysql_connect("localhost","root","");
//mysql_select_db("metrics",$conn);
$conn = mysql_connect("localhost","workflow_metrics","metrics");
mysql_select_db("workflow_metrics",$conn);

//$sql = "SELECT year,d_murder,m_murder
//FROM metrics WHERE year 
//IN ('1990','1991','1992','1993','1994','1995','1996','1997','1998','1999','2000','2001','2002','2003','2004','2005','2006','2007','2008','2009','2010')";

$sql = "SELECT year,
d_murder/(d_pop/100000) AS d_murder, 
(m_murder-d_murder)/((m_pop-d_pop)/100000) AS m_murder 
FROM metrics WHERE  year = '1990' OR year = '2000' OR year = '2010'";

$sth = mysql_query($sql, $conn) or die(mysql_error());

//start the json data in the format Google Chart js/API expects to recieve it
//the columns - labels, value, type - are hardcoded b/c we expect only the data to change
$JSONdata = "{
			  \"cols\": [
			        {\"label\":\"Year\",\"type\":\"string\"},
			        {\"label\":\"Detroit Murders\",\"type\":\"number\"},
			        {\"label\":\"Michigan Murders\",\"type\":\"number\"}
			      ],
			  \"rows\": [";

//loop through the db query result set and put into the chart cell values (note last ojbect in array has "," behind it but its working)
while($r = mysql_fetch_assoc($sth)) {
	//db vals of "0" we need to change to null for JavaScript
   $d_murder = $r['d_murder'] != "0" ? $r['d_murder'] : "null";
   $m_murder = $r['m_murder'] != "0" ? $r['m_murder'] : "null";
   $JSONdata .= "{\"c\":[{\"v\": " . $r['year'] . "}, {\"v\": " . $d_murder . "}, {\"v\": " . $m_murder . "}]},";

}    

//end the json data/object literal with the correct syntax
$JSONdata .= "]}";

echo $JSONdata;

mysql_close($conn);
?>