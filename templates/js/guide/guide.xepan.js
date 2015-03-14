$.each({
	runIntro: function(options){
		console.log(options);
		
		var trip = new Tour($.extend({
			storage: false
		},options));

		trip.init();
		trip.start(true);
		  	// if($(targetElement).closest('.ui-layout-container').length){
			  // 	$(targetElement).closest('.ui-layout-container').data('layout').open('west');
		  	// }
	}
}, $.univ._import);