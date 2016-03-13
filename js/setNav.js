var path=location.pathname;
var array = path.split("/");
var fileName = array[array.length-1];
console.log(fileName);
$(document).ready(function(){
	if(fileName=="albums.php"){
	$("#albums").addClass("navActive");//css("background", "white")
}
else if(fileName == "contact.php"){
	$("#contact").addClass("navActive");
	console.log("contact should work");
}
else if(fileName =="index.php"){
	$("#about").addClass("navActive");
}
else{

}
})


