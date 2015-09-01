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
		$.atk4.get('index.php?page=owner_notification',{},function(ret){
			msg = JSON.parse(ret);
			$.univ().notify("Title Here", msg['message'],null,true);
			$.univ().getNotification();
		});
	}
}, $.univ._import);