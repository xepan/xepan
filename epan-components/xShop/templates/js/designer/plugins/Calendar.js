Calendar_Component = function (params){
	this.parent=undefined;
	this.designer_tool= undefined;
	this.canvas= undefined;
	this.element = undefined;
	this.editor = undefined;

	this.options = {
		month:08,
		year:2015
	};

	this.init = function(designer,canvas){
		this.designer_tool = designer;
		this.canvas = canvas;
	}

	this.initExisting = function(params){

	}

	this.renderTool = function(parent){
		var self=this;
		this.parent = parent;
		tool_btn = $('<div class="btn"><i class="glyphicon glyphicon-calendar"></i><br>Calendar</div>').appendTo(parent.find('.xshop-designer-tool-topbar-buttonset'));

		// CREATE NEW Calendar COMPONENT ON CANVAS Default 
		tool_btn.click(function(event){
			// create new CalendarComponent type object
				// $.univ().frameURL('Add Calendar Form','index.php?page=xShop_page_designer_calendar&item_id='+self.designer_tool.options.item_id+'&item_member_design_id='+self.designer_tool.options.item_member_design_id+'&xsnb_design_template='+self.designer_tool.options.designer_mode);
			self.designer_tool.current_selected_component = undefined;
			// create new CalendarComponent type object
			var new_calendar = new Calendar_Component();
			new_calendar.init(self.designer_tool,self.canvas, self.editor);

			self.designer_tool.pages_and_layouts[self.designer_tool.current_page][self.designer_tool.current_layout].components.push(new_calendar);
			new_calendar.render(true);
		});

	}

	this.render = function(){
		var self = this;
		
		this.element = $('<div style="position:absolute" class="xshop-designer-component"><span><img></img></span></div>').appendTo(this.canvas);
		this.element.show();
		if(this.xhr != undefined)
			this.xhr.abort();

		this.xhr = $.ajax({
			url: 'index.php?page=xShop_page_designer_rendercalendar',
			type: 'GET',
			data: { 
					year:self.options.year,
					month: self.options.month,
					zoom: self.designer_tool.zoom,
					width: self.options.width,
					height: self.options.height,
					zindex:self.options.zindex
					},
		})
		.done(function(ret) {
			self.element.find('img').attr('src','data:image/jpg;base64, '+ ret);
			// $(ret).appendTo(self.element.find('span').html(''));
			self.xhr=undefined;
			// if(place_in_center === true){
				window.setTimeout(function(){
					self.element.center(self.designer_tool.canvas);
					self.options.x = self.element.css('left').replace('px','') / self.designer_tool.zoom;
					self.options.y = self.element.css('top').replace('px','') / self.designer_tool.zoom;
				},200);
			// }
		})
		.fail(function(ret) {
			// evel(ret);
			console.log("Calendar Error");
		})
		.always(function() {
			console.log("Calendar complete");
		});
	}
}