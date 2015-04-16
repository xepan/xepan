// xEpan jQuery Widget for Notifier
jQuery.widget("ui.xnotifier",{

	options:{
		activities:[
		/*
		{
			activity_id: id
			document:name,
			by: actor,
			time: datetime,
			subject: activity_subject
		},...
		*/
		],
		status: 'closed',
		activity_area=undefined
	},

	_create: function(){
		this.setupLayout();
	},
	
	setupLayout: function(){
		var self=this;

		$(this.element).css('position','fixed');
		$(this.element).css('bottom','10px');
		$(this.element).css('left','10px');
		$(this.element).css('width','200px');
		$(this.element).css('height','20px');
		$(this.element).css('border','2px solid red');

		this.top_bar = $('<div class="row" style="position:relative;"></div>');
		this.top_bar.prependTo(this.element);

		$('<div class="col-md-2"></div>').appendTo(this.top_bar);
		$('<div class="col-md-8">11</div>').appendTo(this.top_bar);
		
		$.univ().setInterval(function(){
			$(self.element).xnotifier('reload');
		},5000);

	},

	reload: function(){
		var self=this;

		$.ajax({
				url: self.options.url + '&cut_object='+ $(this.element).attr('id') + '&cut_page=1&'+ $(this.element).attr('id') + '=true',
				type: 'GET',
				datatype: "json",
				data: {},
			}).done(function(ret){
				var activities = JSON.parse(ret);
				var shake=false;
				
				if(activities.length != self.options.activities.length){
					shake=true;
				}

				if(shake){
					$(self.element).effect('shake');
				}

				self.options.activities = activities;

				if(self.options.status=='open'){
					self.render();
				}
			});

		$.univ().successMessage('running');
	},

	render: function (){
		var self = this;
	}

});