$(document).ready(function(){
		 $(document).on('change', '#file', function(){
		  var name = document.getElementById("file").files[0].name;
		  $('#fileName').text(name);
		  var form_data = new FormData();
		  var ext = name.split('.').pop().toLowerCase();
		  if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
		  {
		   alert("Invalid Image File");
		  }
		  var oFReader = new FileReader();
		  oFReader.readAsDataURL(document.getElementById("file").files[0]);
		  var f = document.getElementById("file").files[0];
		  var fsize = f.size||f.fileSize;
		  var _URL = window.URL || window.webkitURL;
		  img = new Image();
		  var img_width = 0;
		  var img_height = 0;
		  var max_img_width = 250;
		  var max_img_height = 250;

		  img.src = _URL.createObjectURL(f);
		  img.onload = function(){
		  	img_width = this.width;
		  	img_height = this.height;

		  	if(fsize > 2000000)
			  {
			   alert("Image File Size is very big");
			  }
			  else if (img_width <= max_img_height && img_height <= max_img_height) {
			  	form_data.append("file", document.getElementById('file').files[0]);
			   $.ajax({
			    url:"upload_processor.php",
			    method:"POST",
			    data: form_data,
			    contentType: false,
			    cache: false,
			    processData: false,
			    beforeSend:function(){
			     $("#placeholderImg").attr("src","../img/lode.gif");
			    },   
			    success:function(data)
			    {
			    	$("#placeholderImg").attr("src",""+data);
			    	//$("#placeholderImg").show();
			    	$("#imgInput").attr("value",""+data);
			    }
			  });

			  }
			  else{
			  	alert("Invalid image dimension. Image dimension should not exceed 250 X 250.\n"+"Your imgae width: "+img_width+"\n"+"Your image height: "+img_height);
			  }

		  }
	});
});