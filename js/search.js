$(document).ready(function(){

	$("#albumNameSelector").change(function(){
		var curId = $("option:selected").attr("id");
		$("#hiddenSpan").val(curId);
	})
	
	
})