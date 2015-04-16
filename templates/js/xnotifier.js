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
		activity_area:undefined
	},

	_create: function(){
		this.setupLayout();
	},
	
	setupLayout: function(){
		var self=this;

		$(this.element).css('position','fixed');
		$(this.element).css('bottom','10px');
		$(this.element).css('left','10px');
		$(this.element).css('width','300px');
		$(this.element).css('min-height','50px');
		// $(this.element).css('border','2px solid');
		$(this.element).css('z-index','2000');
		
		this.top_bar = $('<div class="row" style="position:relative;margin:0 auto 0 auto;"></div>');
		this.top_bar.appendTo(this.element);
		toggle_btn = $('<div class="atk-swatch-red icon-down-dir" style="background-color:gray;"></div>').appendTo(this.top_bar);
		
		self.options.activity_area = $('<div class="well">No Result Found</div>').appendTo(this.top_bar);
		self.options.activity_area.css('min-height','300px');
		$(self.options.activity_area).slideUp();
		self.footer = $('<div class="text-center atk-swatch-ink"><span class="badge">0</span></div>').appendTo(this.element);

		$(toggle_btn).click(function(){
			self.render();
			$(self.options.activity_area).slideToggle();
			if($(this).hasClass('icon-down-dir')){
				$(this).removeClass('icon-down-dir atk-swatch-red');
				$(this).addClass('icon-up-dir atk-swatch-green');
				self.options.status='closed';
			}else{
				$(this).removeClass('icon-up-dir atk-swatch-green');
				$(this).addClass('icon-down-dir atk-swatch-red');
				self.options.status='open';
			}
		});

		$.univ().setInterval(function(){
			$(self.element).xnotifier('reload');
		},5000);

	},

	reload: function(){
		var self=this;

		$.ajax({
				url: self.options.url + '&cut_object='+ $(this.element).attr('id') + '&cut_page=1&'+ $(this.element).attr('id') + '=true&xnotifier=1',
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
					self.render()
				}

				self.options.activities = activities;

				if(self.options.status=='open'){
					self.render();
				}
			});
	},

	render: function (){
		var self = this;
		$(this.footer).empty();
		$('<span class="badge">'+$(self.options.activity_area).length+'</span>').appendTo(self.footer);
		
		$(self.options.activities).each(function(index,element){
			$(self.options.activity_area).empty();
			activity_box = $('<div class="atk-box"></div>').appendTo(self.options.activity_area);
			$('<i>'+element.subject+'</i>').appendTo(activity_box);
			$(activity_box).click(function(event){
				$.univ().frameURL(element.subject,'index.php?page=owner_activitydocument&activity_id='+element.id)
			});
			console.log(element.id);
		});
	}

});