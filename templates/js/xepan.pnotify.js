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
	}
}, $.univ._import);