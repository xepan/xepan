$.each({
	runIntro: function(my_steps,options){
		var intro = introJs();
         intro.setOptions({
           steps: my_steps
         });
         intro.onbeforechange(function(targetElement) {
		  	if($(targetElement).closest('.ui-layout-container').length){
			  	$(targetElement).closest('.ui-layout-container').data('layout').open('west');
		  	}
		 });
         intro.start();	
	}
}, $.univ._import);