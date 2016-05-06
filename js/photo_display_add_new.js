$(document).ready( function (){
	$("#uploading").click(function (){
		var uploadAreaSwitch =  $("#add_new_photo");
		if(uploadAreaSwitch.css("display") == "none" ) {
			uploadAreaSwitch.css("display","block");
		}
		else{
			uploadAreaSwitch.css("display","none");
		}
	})
	//show or hide album edit
	$("#editAlbum").click(function (){
		var albumEditionSwitch =  $("#edit_album");
		if(albumEditionSwitch.css("display")=="none"){
			albumEditionSwitch.css("display","block");
		}else{
			albumEditionSwitch.css("display", "none");
		}
	});
	$("#choose_file_input").click(function (){

	});


})

function readURL(imageDirectory){
		
		if(imageDirectory.files && imageDirectory.files[0]){
			console.log("inside");
			var reader = new FileReader();
			reader.onload = function (e){
				$("#preview").css("background-image","url("+e.target.result+")");
			};

			reader.readAsDataURL(imageDirectory.files[0]);
		}
}
function descriptionValidation(){
	var description = $("#uploadButton").val();
	var file = $("#chooseFileButton").val();
	if(description.length > 64*1000){
		alert("Description should limit the number of its letters within 64k.");
		return false;
	}
	if(file.length ==0){
		alert("Plese choose a file before uploading!");
		return false;
	}
}