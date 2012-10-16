//detroitmetrics.js copywrite 2012 Andrew Koper

$(document).ready(function() {
	
	  //jump to map page when user selects map from pulldown menu
	  $('#pulldown').change(function() {
		  var mapURL = $("#pulldown option:selected").val();
		  top.location.href = mapURL;
	  	  return true;
	  });
	  
	//have today's date appear in date field in example add data form
	var today = new Date();
	var date = today.getDate();
	var month = new Array();
	month[0]="January";
	month[1]="February";
	month[2]="March";
	month[3]="April";
	month[4]="May";
	month[5]="June";
	month[6]="July";
	month[7]="August";
	month[8]="September";
	month[9]="October";
	month[10]="November";
	month[11]="December";
	var month1 = month[today.getMonth()];
	var year = today.getFullYear();
	$('#dateN').val(month1 + " " + date + ", " + year);
	//document.getElementById('#dateN').val = month1 + " " + date + ", " + year;
	//console.log(month1 + " " + date + ", " + year);
	  
});

