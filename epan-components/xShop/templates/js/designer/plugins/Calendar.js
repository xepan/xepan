xShop_Calendar_Editor = function(parent,designer){
	var self = this;
	this.parent = parent;
	this.current_calendar_component = undefined;
	this.designer_tool = designer;
	this.element = $('<div id="xshop-designer-calendar-editor" class="xshop-options-editor" style="display:block"> </div>').appendTo(this.parent);

	// add font_selection with preview
	// header_font_size:16,

	this.header_font_size = $('<select class="btn btn-xs">Header Size</select>').appendTo(this.element);
	options = '';
	for (var i = 7; i < 50; i++) {
		options += '<option value="'+i+'">'+i+'</option>';
	};
	$(options).appendTo(this.header_font_size);
	$(this.header_font_size).change(function(event){
		self.current_calendar_component.options.header_font_size = $(this).val();
		$('.xshop-designer-tool').xepan_xshopdesigner('check');
		self.current_calendar_component.render();
	});

	// day_date_font_size:12,
	this.day_date_font_size = $('<select class="btn btn-xs">Day Date Size</select>').appendTo(this.element);
	for (var i = 7; i < 50; i++) {
		$('<option value="'+i+'">'+i+'</option>').appendTo(this.day_date_font_size);
	};
	$(this.day_date_font_size).change(function(event){
		self.current_calendar_component.options.day_date_font_size = $(this).val();
		$('.xshop-designer-tool').xepan_xshopdesigner('check');
		self.current_calendar_component.render();
	});

	// day_name_font_size:12,
	this.day_name_font_size = $('<select class="btn btn-xs">Day Name Size</select>').appendTo(this.element);
	for (var i = 7; i < 50; i++) {
		$('<option value="'+i+'">'+i+'</option>').appendTo(this.day_name_font_size);
	};
	$(this.day_name_font_size).change(function(event){
		self.current_calendar_component.options.day_name_font_size = $(this).val();
		$('.xshop-designer-tool').xepan_xshopdesigner('check');
		self.current_calendar_component.render();
	});

	// event_font_size:10,
	this.event_font_size = $('<select class="btn btn-xs">Event Size</select>').appendTo(this.element);
	for (var i = 7; i < 50; i++) {
		$('<option value="'+i+'">'+i+'</option>').appendTo(this.event_font_size);
	};
	$(this.event_font_size).change(function(event){
		self.current_calendar_component.options.event_font_size = $(this).val();
		$('.xshop-designer-tool').xepan_xshopdesigner('check');
		self.current_calendar_component.render();
	});

	//Month
	this.month = $('<select class="btn btn-xs"></select>').appendTo(this.element);
	options = '';
	options += '<option value="01">January</option>';
	options += '<option value="02">Febuary</option>';
	options += '<option value="03">March</option>';
	options += '<option value="04">April</option>';
	options += '<option value="05">May</option>';
	options += '<option value="06">June</option>';
	options += '<option value="07">July</option>';
	options += '<option value="08">August</option>';
	options += '<option value="09">September</option>';
	options += '<option value="10">Octomber</option>';
	options += '<option value="11">November</option>';
	options += '<option value="12">December</option>';
	$(options).appendTo(this.month);

	$(this.month).change(function(event){
		self.current_calendar_component.options.month = $(this).val();
		$('.xshop-designer-tool').xepan_xshopdesigner('check');
		self.current_calendar_component.render();
	});	


	//Choose Your Calendar's Starting Month 
	this.starting_month = $('<label for="startDate">Starting Month :</label>').appendTo(this.element);
	this.starting_month_text = $('<input name="startDate" id="xshop-designer-startDate" class="xshop-designer-calendar-month-picker" />').appendTo(this.starting_month);	
	$('.xshop-designer-calendar-month-picker').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'MM yy',
        onClose: function(dateText, inst) { 
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).attr('month',month);
            $(this).attr('year',year);
            $(this).datepicker('setDate', new Date(year, month, 1));

            self.designer_tool.options.calendar_starting_month = $(this).val();
            self.current_calendar_component.options.starting_date = $(this).val();
    		self.current_calendar_component.options.starting_month = month;
    		self.current_calendar_component.options.starting_year = year;
			$('.xshop-designer-tool').xepan_xshopdesigner('check');
			self.current_calendar_component.render();

        }
    });
    $(".xshop-designer-calendar-month-picker").focus(function () {
		$(".ui-datepicker-calendar").hide();
		$("#ui-datepicker-div").position({
			my: "center top",
			at: "center bottom",
			of: $(this)
		});
	});



    //Set from Saved Values
	this.setCalendarComponent = function(component){
		this.current_calendar_component  = component;
		$(this.font_size).val(component.options.font_size);
		$(this.font_selector).val(component.options.font);
		$(this.text_color_picker).val(component.options.color_formatted);
		$(this.text_color_picker).colorpicker('setColor',component.options.color_formatted);
	}
}


Calendar_Component = function (params){
	this.parent=undefined;
	this.designer_tool= undefined;
	this.canvas= undefined;
	this.element = undefined;
	this.editor = undefined;

	this.options = {
		header_font_size:16,
		day_date_font_size:12,
		day_name_font_size:12,
		event_font_size:10,

		month:08,
		width:400,
		height:300,

		starting_date:undefined, //Show Only Date and Month // Default Value currentYear-1st Jan Month
		starting_month:undefined,
		starting_year:undefined,

		resizable:undefined,
		movable:undefined,
		colorable:undefined,
		editor:undefined,
		designer_mode:false,
		x:undefined,
		y:undefined
	};
	
	this.init = function(designer,canvas, editor){
		this.designer_tool = designer;
		this.canvas = canvas;
		if(editor !== undefined)
			this.editor = editor;
	}

	this.initExisting = function(params){

	}

	this.renderTool = function(parent){
		var self=this;
		this.parent = parent;
		tool_btn = $('<div class="btn"><i class="glyphicon glyphicon-calendar"></i><br>Calendar</div>').appendTo(parent.find('.xshop-designer-tool-topbar-buttonset'));

		this.editor = new xShop_Calendar_Editor(parent.find('.xshop-designer-tool-topbar-options'),self.designer_tool);

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
		console.log(self);
		if(this.element == undefined){
			this.element = $('<div style="position:absolute" class="xshop-designer-component"><span><img></img></span></div>').appendTo(this.canvas);
			this.element.draggable({
				containment: self.designer_tool.safe_zone,
				smartguides:".xshop-designer-component",
			    tolerance:5,
				stop:function(e,ui){
					var position = ui.position;
					self.options.x = self.designer_tool.screen2option(position.left);
					self.options.y = self.designer_tool.screen2option(position.top);
				}
			}).resizable({
				containment: self.designer_tool.safe_zone,
				handles: "e",
				autoHide: true,
				stop: function(e,ui){
					self.options.width = self.designer_tool.screen2option(ui.size.width);
					self.render();
				}
			});
			$(this.element).data('component',self);			

			$(this.element).click(function(event) {
				$('.ui-selected').removeClass('ui-selected');
	            $(this).addClass('ui-selected');
	            $('.xshop-options-editor').hide();
	            self.editor.element.show();
	            self.designer_tool.option_panel.fadeIn(500);

	            self.designer_tool.current_selected_component = self;
	            self.designer_tool.option_panel.css('z-index',70);
	            self.designer_tool.option_panel.addClass('xshop-text-options');
	            self.designer_tool.option_panel.css('top',0);

	            designer_currentTarget = $(event.currentTarget);
	            height_diff = parseInt($(self.designer_tool.option_panel).height());
	            top_value = parseInt($(designer_currentTarget).offset().top) - parseInt(height_diff);

	            self.designer_tool.option_panel.css('top',top_value);
	            self.designer_tool.option_panel.css('left',$(designer_currentTarget).offset().left);

	            self.editor.setCalendarComponent(self);
	            
	            if(self.designer_tool.options.designer_mode){
		            self.designer_tool.freelancer_panel.FreeLancerComponentOptions.element.show();
		            self.designer_tool.freelancer_panel.setComponent($(this).data('component'));
	            }
		        event.stopPropagation();
			});
		}else{
			this.element.show();
		}

		this.element.css('top',self.options.y  * self.designer_tool.zoom);
		this.element.css('left',self.options.x * self.designer_tool.zoom);

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