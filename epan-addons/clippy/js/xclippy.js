agent=undefined;

$.each(
{
	loadAgent: function(agent_name){
		$.atk4.includeJS("epan-addons/clippy/js/build/clippy.min.js");
		$.atk4.includeCSS("epan-addons/clippy/js/build/clippy.css");
		$.atk4(function(){
			clippy.load(agent_name, function(a){
				agent=a;
	        	a.show();
	    	});
		});
	}

},$.univ._import);