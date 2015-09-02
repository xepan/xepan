$.each({
	notify: function(xTitle, xText, xType, isDesktop, callback, sticky){
		var nn = new PNotify(
			{ 
				title: xTitle,
				text: xText,
				type: xType==null?"notice":xType,
				desktop: {
					desktop: isDesktop==null?false:true
				}
			}
			);
		if(callback !==undefined) nn.get().click(callback);	
		if(sticky !== null) {
			var nn = new PNotify(
			{ 
				title: xTitle,
				text: xText,
				type: xType==null?"notice":xType,
				hide: false,
				desktop: {
						desktop: false
					}
				}
			);
		}
	},
	
	getNotification: function (){
		$.ajax({
			url: 'index.php?page=owner_notification',
		})
		.done(function(ret) {
			try{
				msg = JSON.parse(ret);
				if(msg['message']){
					$.univ().notify(msg['title'], msg['message'],msg['type'],true,undefined,msg['sticky']);
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