$.each({
	notify: function(xTitle, xText, xType, isDesktop, callback, icon){
		var nn = new PNotify(
			{ 
				title: xText,
				text: xText,
				type: xType==null?"notice":xType,
				desktop: {
					desktop: isDesktop==null?false:true
				}
			}
			);
		if(callback !==undefined) nn.get().click(callback);	
	},
	
	getNotification: function (){
		$.ajax({
			url: 'index.php?page=owner_notification',
		})
		.done(function(ret) {
			try{
				msg = JSON.parse(ret);
				if(msg['message']){
					$.univ().notify("Title Here", msg['message'],null,true);
				}
			}catch(e){

			}
		})
		.fail(function() {
			// console.log("error");
		})
		.always(function() {
			$.univ().getNotification();
			// console.log("complete");
		});		
	}
	
}, $.univ._import);