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
		activity_area:undefined,
		see_activity:0
	},

	_create: function(){
		this.setupLayout();
		// $(this.element).draggable({
		// 	containment: 'parent'
		// });
	},
	
	setupLayout: function(){
		var self=this;

		$(this.element).css('position','fixed');
		$(this.element).css('bottom','10px');
		$(this.element).css('right','10px');
		// $(this.element).css('width','300px');
		$(this.element).css('min-height','50px');
		$(this.element).addClass('atk-box atk-padding-small');
		// $(this.element).css('border','2px solid');
		$(this.element).css('z-index','2000');
		
		this.top_bar = $('<div class="row" style="position:relative;margin:0 auto 0 auto;"></div>');
		this.top_bar.appendTo(this.element);
		toggle_btn = $('<div class="atk-swatch-green icon-up-dir atk-size-peta" style="border-radius: 10px 10px 0px 0px; background-color: #ffffb9";></div>').appendTo(this.top_bar);
		
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
				self.options.see_activity = 1;
				// $(self.options.activity_area).empty();
			}else{
				$(this).removeClass('icon-up-dir atk-swatch-green');
				$(this).addClass('icon-down-dir atk-swatch-red');
				// self.render();
				self.options.status='open';
			}
			$(self.options.activity_area).slideToggle();
		});
		
		self.reload();
		$.univ().setInterval(function(){
			$(self.element).xnotifier('reload');
		},300000);

	},

	reload: function(){
		var self=this;

		$.ajax({
				url: self.options.url + '&cut_object='+ $(this.element).attr('id') + '&cut_page=1&'+ $(this.element).attr('id') + '=true&xnotifier=1&see=1',
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
			activity_box = $('<div class="atk-box atk-row atk-size-micro atk-padding-small" style="cursor:pointer;"></div>').appendTo(self.options.activity_area);
			
			//Action
			action = $('<div class="atk-col-6 atk-swatch-red icon-flash" style="text-transform:capitalize;">'+element.action+'</div>').appendTo(activity_box);
			//Date
			date = $('<div class="atk-col-6 icon-calendar"> '+element.created_date+'</div>').appendTo(self.options.activity_box);
			//Activity No LIKE xShop\Order::000067
			document_root = $('<small class="atk-col-12 atk-hr-small text-center">'+element.related_root_document_name+' :: '+element.related_document+'</small>').appendTo(activity_box);
			//subject
			str = '<div class="atk-col-12 atk-effect-info atk-label atk-size-reset">'+element.subject+'</div><div class="atk-hr-large"></div>';
			//Action
			// str = str+'<div class="atk-col-12 text-center">Action</div>';
			//Action from
			str = str+'<div class="atk-col-5 icon-user">'+element.action_from+'</div>';
			str = str+'<div class="atk-col-2 glyphicon glyphicon-arrow-right"></div>';
			//Action To
			str = str+'<div class="atk-col-5 icon-user">'+element.action_to+'</div>';
			
			$(str).appendTo(activity_box);

			$(document_root).click(function(event){
				$.univ().frameURL(element.subject,'index.php?page=owner_activitydocument&activity_id='+element.id)
				event.stopPropagation();
			});

			$(activity_box).click(function(event){
				$.univ().frameURL(element.subject,'index.php?page=owner_activitydocument&show_activity_view_id='+element.id);
				event.stopPropagation();
			});

		});
	}

});