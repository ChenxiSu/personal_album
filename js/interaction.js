$(document).ready(function() {
	
	$("#showButton").click(function (){
		var element = $("#photo_uploading_area");
		if(element.css("display") == "none") element.css('display','block');
		else element.css('display','none');
		
	});

	$("#showDeletion").click( function (){
		var element = $("#album_deletion_form");
		if(element.css("display") == "none") element.css('display','block');
		else element.css('display','none');
	});

	

	$(".thumbNailImg").click( function (){
		
		var img = this;
		console.log(img);
		var initalContainer=img.closest(".thumbnailContainer");
		console.log(initalContainer);
		$("#myModel").css('display','block');
		var thumbNailSrc=img.src;
		console.log(thumbNailSrc);
		var srcArray = thumbNailSrc.split("/");
		var src = "src/photos/"+srcArray[srcArray.length-1];
		$("#curImg").attr("src",src);
		
		$("#leftClickArea").click(initalContainer, function (){
			var container = initalContainer.previousSibling;
			initalContainer = container;
			console.log(container);
			var imgEle=container.childNodes[0];
			var thumbNailSrc1=imgEle.src;
			var srcArray1 = thumbNailSrc1.split("/");
			var src1 = "src/photos/"+srcArray1[srcArray1.length-1];
			$("#curImg").attr("src",src1);
		});

		$("#rightClickArea").click(initalContainer, function (){
			var container = initalContainer.nextSibling;
			initalContainer = container;
			console.log(container);
			var imgEle=container.childNodes[0];
			var thumbNailSrc1=imgEle.src;
			var srcArray1 = thumbNailSrc1.split("/");
			var src1 = "src/photos/"+srcArray1[srcArray1.length-1];
			$("#curImg").attr("src",src1);
		});
		
	});
	// change the description of img
	$(".thumbnailContainer p").on("dblclick", function (){
		$(this).css("display","none");;
		var input = this.nextSibling;
		$(input).css("display","block");
	})
	$(".thumbnailContainer input").keypress( function (e){
		if(e.which == 13) {
        	var request;
        	var input = this;
        	var newContent = $(this).val();
        	var album_id = $(this).attr("album_id");

        	var photoID = $(this).attr("id");
        	console.log(""+album_id+" "+photoID+" "+newContent);
        	var newEdition = {alID:album_id, pID:photoID, newtext:newContent};
        	
        	console.log(newEdition);
        	request = $.ajax({
        		url:'featureGeneration/albumRecordDescEdit.php',
        		type:'get',
        		data:newEdition,
        		dataType:'text',
        		error:function(error){
        			console.log(error);
        		}
        	})
        	request.success(input, function(data){
        		console.log(input);
        		console.log("recevied!!!!!");
				console.log(data);
				if(data=="success"){
					var p =input.previousSibling;
					console.log(p);
					$(p).text(newContent);
					
					$(p).css("display","block");
					$(input).css("display","none");
				}
        	});
    	}

	});


	$(".thumbnailContainer input").focus(function(){

	}).blur(function () {
		$(this).css("display", "none");
		var p = this.previousSibling;
		$(p).css("display","block")
	})

	$("#close").click( function (){
		$("#myModel").css("display","none");
	});
});

function readURL(imageDirectory){
		
		if(imageDirectory.files && imageDirectory.files[0]){
			console.log("inside");
			console.log(imageDirectory.files[0].name);
			var fileName = imageDirectory.files[0].name;
			var type = fileName.split(".")[1];
			if(type === "jpg" ||type === "JPG"|| 
				type ==="png" || type==="PNG" ||
				type === "gif" || type === "GIF"){
				
				$(".file_upload_type_limit").css("color","black");
				var reader = new FileReader();
				reader.onload = function (e){
					$("#preview").css("background-image","url("+e.target.result+")");

				};

				reader.readAsDataURL(imageDirectory.files[0]);
			}
			else{
				$(".file_upload_type_limit").css("color","red");
				return false;
			}			
		}
}

function validationAlbumCreation(){
	var album_name = $("#album_name_input").val();
	var description = $("textarea").val();
	var message = "";
	var ringAlert=false;
	if(album_name.length == 0){
		message =  message+"album name must not be empty!\n";
		ringAlert=true;
	}
	if( album_name.length>50 ){
		message = message+"Please limit your album name within 50 letters.\n";
		ringAlert=true;
	}
	if( description.length > 64*1000){
		message = message+"please limit your description within 64k letters."
		ringAlert=true;
	}

	if(ringAlert){
		alert(message);
		return false;
	}
	else{
		return true;
	}
	
}

function validationPhotoUploadingInAlbumPHP(){
	var description = $("#descriptionInput").val();
	var file = $("#file_input").val();
	console.log(description);
	if(description.length>64*1000){
		alert("Please limit the size of your letters within 64k.");
		return false;
	}
	if($(".file_upload_type_limit").css("color") === "rgb(255, 0, 0)" ){
		alert("Please limit the type of your image within jpg, png and gif!");
		return false;
	}

	if(file.length ==0){
		alert("Plese choose a file before uploading!");
		return false;
	}

}

function imageDisplay(image){

}