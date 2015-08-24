$.each({

    blogPostDetailUpdate:function(container_id,post_id_in){
     	html_body = $('#'+container_id).html();
     	html_body = encodeURIComponent(html_body);
     	// html_crc = crc32(html_body);
        $.ajax({
	        url: 'index.php?page=xBlog_page_owner_updatecontent',
	        type: 'POST',
	        dataType: 'html',
	        data: {
	            body_html: html_body,
	            // crc32: html_crc,
	            xblog_title: 'nope',
	            xblog_post_id: post_id_in,
	            length: html_body.length
	        },
    	})
        .done(function(message) {
            if (message == 'updated') {
                $('body').univ().successMessage('Update');
                // $(overlay).remove();
            } else {
                // $(overlay).remove();
                $('body').univ().errorMessage('Could Not Update content');
                eval(message);
            }
            // $('body').trigger('saveSuccess');
            $('body').triggerHandler('saveSuccess');
            console.log("Updated");
        })
        .fail(function(err) {
            $('body').trigger('saveFail');
            console.log(err);
            console.log('Error got it');
        })
        .always(function() {
            // $('body').trigger('afterSave');
            $('body').triggerHandler('afterSave');
            console.log("complete");
        });
    }
},$.univ._import);  