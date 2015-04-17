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
		$(this.element).addClass('atk-box');
		// $(this.element).css('border','2px solid');
		$(this.element).css('z-index','2000');
		
		this.top_bar = $('<div class="row" style="position:relative;margin:0 auto 0 auto;"></div>');
		this.top_bar.appendTo(this.element);
		toggle_btn = $('<div class="atk-swatch-green icon-up-dir atk-size-peta" style="border-radius: 10px 10px 0px 0px; background-color: #ffffb9";>Notifications</div>').appendTo(this.top_bar);
		
		self.options.activity_area = $('<div class="well">No Result Found</div>').appendTo(this.top_bar);
		self.options.activity_area.css('max-height','300px');
		self.options.activity_area.css('overflow','auto');
		$(self.options.activity_area).slideUp();
		self.footer = $('<div class="text-center atk-swatch-ink atk-padding-small" style="border-radius:0px 0px 10px 10px"><span class="badge ">0</span></div>').appendTo(this.element);

		$(toggle_btn).click(function(){
			if($(this).hasClass('icon-down-dir')){
				$(this).removeClass('icon-down-dir atk-swatch-red');
				$(this).addClass('icon-up-dir atk-swatch-green');
				self.options.status='closed';
				$(self.options.activity_area).empty();
			}else{
				$(this).removeClass('icon-up-dir atk-swatch-green');
				$(this).addClass('icon-down-dir atk-swatch-red');
				self.render();
				self.options.status='open';
			}
			$(self.options.activity_area).slideToggle();
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

				self.options.activities = activities;
				
				if(shake){
					$(self.element).effect('shake');
					self.render()
				}


				if(self.options.status=='open'){
					self.render();
				}
			});
	},

	render: function (){
		var self = this;
		$(this.footer).empty();
		$('<span class="badge atk-swatch-red">'+$(self.options.activities).length+'</span>').appendTo(self.footer);

		$(self.options.activity_area).empty();
		$(self.options.activities).each(function(index,element){
			activity_box = $('<div class="atk-box"></div>').appendTo(self.options.activity_area);
			str = '<small class="atk-swatch-gray pull-right"> '+element.created_at+' </small>';
			str = str+'</br><p>'+element.subject+'</p>';
			str = str+'<small class="icon-user pull-right">'+element.action_from+'</small>';
			$(str).appendTo(activity_box);

			$(activity_box).click(function(event){
				$.univ().frameURL(element.subject,'index.php?page=owner_activitydocument&activity_id='+element.id)
			});
		});
	}

});