jQuery(document).ready(function($){
    jQuery('.button-primary').on('click' , function(e) {
		var putimg=jQuery(this).attr('data-id');
        e.preventDefault();
		putimg1 = putimg.toLowerCase().replace(/\b[a-z]/g, function(letter) { return letter.toUpperCase(); });
		if(putimg1 == "Img2"){
			title1 = "Thumbnail";
		}
		else
		{
			title1 = "Main";
		}
		
        var image = wp.media({
            title: 'Upload '+title1+' Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            // We convert uploaded_image to a JSON object to make accessing it easier
            // Output to the console uploaded_image
            console.log(uploaded_image);
            var image_url = uploaded_image.toJSON().url;
            // Let's assign the url value to the input field
           jQuery('#'+putimg).val(image_url);
		   jQuery('#'+putimg1).attr('src', image_url);
        });
    });
});
