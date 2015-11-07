xShop_Calendar_Editor = function(parent,designer){
	var self = this;
	this.parent = parent;
	this.current_calendar_component = undefined;
	this.designer_tool = designer;
	this.element = $('<div id="xshop-designer-calendar-editor" class="xshop-options-editor atk-row" style="display:block"> </div>').appendTo(this.parent);

	this.row1 = $('<div class="atk-row" style="display:block;margin:0;"> </div>').appendTo(this.element);

//```````````````````````````````````````````````````````````````````````````|
//------------------------------Header Style Options-------------------------
//___________________________________________________________________________|
	
	// header_font_size:16,
	this.col1 = $('<div class="atk-col-3">Header</div>').appendTo(this.row1);
	this.header_font_size_label = $('<div><label for="header_font_size">Font Size :</label></div>').appendTo(this.col1);
	this.header_font_size = $('<select id="header_font_size" class="btn btn-xs">Header Size</select>').appendTo(this.header_font_size_label);
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

	//header font color: default Value Black
	this.header_color_label = $('<div class="xshop-designer-calendar-color-picker"><label for="header_font_color">Color : </label></div>').appendTo(this.col1);
	this.header_color_picker = $('<input id="header_font_color" style="display:none;">').appendTo(this.header_color_label);
	$(this.header_color_picker).colorpicker({
		parts:          'full',
        alpha:          false,
        showOn:         'both',
        buttonColorize: true,
        showNoneButton: true,
        ok: function(event, color){
        	// self.current_calendar_component.options.header_font_color = parseInt((color.cmyk.c)*100)+','+parseInt((color.cmyk.m)*100)+','+parseInt((color.cmyk.y)*100)+','+parseInt((color.cmyk.k)*100);
        	self.current_calendar_component.options.header_font_color = '#'+color.formatted;
        	$('.xshop-designer-tool').xepan_xshopdesigner('check');
        	self.current_calendar_component.render();
        	// console.log('#'+color.formatted);
        	// console.log(parseInt((color.cmyk.c)*100)+','+parseInt((color.cmyk.m)*100)+','+parseInt((color.cmyk.y)*100)+','+parseInt((color.cmyk.k)*100));
        }
	});


//```````````````````````````````````````````````````````````````````````````|
//------------------------------Day Date Style Options-----------------------
//___________________________________________________________________________|
	// day_date_font_size:12,
	this.col2 = $('<div class="atk-col-3">Day Date</div>').appendTo(this.row1);
	this.day_date_font_size_label = $('<div><label for="day_date_font_size">Font Size :</label></div>').appendTo(this.col2);
	this.day_date_font_size = $('<select id="day_date_font_size"class="btn btn-xs">Day Date Size</select>').appendTo(this.day_date_font_size_label);
	for (var i = 7; i < 50; i++) {
		$('<option value="'+i+'">'+i+'</option>').appendTo(this.day_date_font_size);
	};
	$(this.day_date_font_size).change(function(event){
		self.current_calendar_component.options.day_date_font_size = $(this).val();
		$('.xshop-designer-tool').xepan_xshopdesigner('check');
		self.current_calendar_component.render();
	});

	//Day Date Font Color
	//header font color: default Value Black
	this.day_date_color_label = $('<div class="xshop-designer-calendar-color-picker"><label for="day_date_font_color">Color : </label></div>').appendTo(this.col2);
	this.day_date_color_picker = $('<input id="day_date_font_color" style="display:none;">').appendTo(this.day_date_color_label);
	$(this.day_date_color_picker).colorpicker({
		parts:          'full',
        alpha:          false,
        showOn:         'both',
        buttonColorize: true,
        showNoneButton: true,
        ok: function(event, color){
        	// self.current_calendar_component.options.header_font_color = parseInt((color.cmyk.c)*100)+','+parseInt((color.cmyk.m)*100)+','+parseInt((color.cmyk.y)*100)+','+parseInt((color.cmyk.k)*100);
        	self.current_calendar_component.options.day_date_font_color = '#'+color.formatted;
        	$('.xshop-designer-tool').xepan_xshopdesigner('check');
        	self.current_calendar_component.render();
        	// console.log('#'+color.formatted);
        	// console.log(parseInt((color.cmyk.c)*100)+','+parseInt((color.cmyk.m)*100)+','+parseInt((color.cmyk.y)*100)+','+parseInt((color.cmyk.k)*100));
        }
	});


	//```````````````````````````````````````````````````````````````````````````|
	//------------------------------Cell Block Height----------------------------
	//___________________________________________________________________________|
	//Height
	this.height_label = $('<label for="xshop-designer-calendar-height">Height :</label>').appendTo(this.col2);
	this.cell_height = $('<input type="number" id="xshop-designer-calendar-height"  min="10" max="80" value="20" style="padding:0;font-size:12px;" />').appendTo(this.height_label);

	$(this.cell_height).change(function(event){
		self.current_calendar_component.options.calendar_cell_heigth = $(this).val();
		$('.xshop-designer-tool').xepan_xshopdesigner('check');
		self.current_calendar_component.render();

	});	


//```````````````````````````````````````````````````````````````````````````|
//------------------------------Day Name Style Options-----------------------
//___________________________________________________________________________|
	// day_name_font_size:12,
	this.col3 = $('<div class="atk-col-3">Day Name</div>').appendTo(this.row1);
	this.day_name_font_size_label = $('<div><label for="day_name_font_size">Font Size :</label></div>').appendTo(this.col3);
	this.day_name_font_size = $('<select class="btn btn-xs">Day Name Size</select>').appendTo(this.day_name_font_size_label);
	for (var i = 7; i < 50; i++) {
		$('<option value="'+i+'">'+i+'</option>').appendTo(this.day_name_font_size);
	};
	$(this.day_name_font_size).change(function(event){
		self.current_calendar_component.options.day_name_font_size = $(this).val();
		$('.xshop-designer-tool').xepan_xshopdesigner('check');
		self.current_calendar_component.render();
	});

	//Day Name Font Color
	this.day_name_color_label = $('<div class="xshop-designer-calendar-color-picker"><label for="day_name_font_color">Color : </label></div>').appendTo(this.col3);
	this.day_name_color_picker = $('<input id="day_name_font_color" style="display:none;">').appendTo(this.day_name_color_label);
	$(this.day_name_color_picker).colorpicker({
		parts:          'full',
        alpha:          false,
        showOn:         'both',
        buttonColorize: true,
        showNoneButton: true,
        ok: function(event, color){
        	// self.current_calendar_component.options.header_font_color = parseInt((color.cmyk.c)*100)+','+parseInt((color.cmyk.m)*100)+','+parseInt((color.cmyk.y)*100)+','+parseInt((color.cmyk.k)*100);
        	self.current_calendar_component.options.day_name_font_color = '#'+color.formatted;
        	$('.xshop-designer-tool').xepan_xshopdesigner('check');
        	self.current_calendar_component.render();
        	// console.log('#'+color.formatted);
        	// console.log(parseInt((color.cmyk.c)*100)+','+parseInt((color.cmyk.m)*100)+','+parseInt((color.cmyk.y)*100)+','+parseInt((color.cmyk.k)*100));
        }
	});

	//Day Name Background Color
	this.day_name_bg_color_label = $('<div class="xshop-designer-calendar-color-picker"><label for="day_name_bg_color">BG Color : </label></div>').appendTo(this.col3);
	this.day_name_bg_color_picker = $('<input id="day_name_bg_color" style="display:none;">').appendTo(this.day_name_bg_color_label);
	$(this.day_name_bg_color_picker).colorpicker({
		parts:          'full',
        alpha:          false,
        showOn:         'both',
        buttonColorize: true,
        showNoneButton: true,
        ok: function(event, color){
        	// self.current_calendar_component.options.header_font_color = parseInt((color.cmyk.c)*100)+','+parseInt((color.cmyk.m)*100)+','+parseInt((color.cmyk.y)*100)+','+parseInt((color.cmyk.k)*100);
        	self.current_calendar_component.options.day_name_bg_color = '#'+color.formatted;
        	$('.xshop-designer-tool').xepan_xshopdesigner('check');
        	self.current_calendar_component.render();
        	// console.log('#'+color.formatted);
        	// console.log(parseInt((color.cmyk.c)*100)+','+parseInt((color.cmyk.m)*100)+','+parseInt((color.cmyk.y)*100)+','+parseInt((color.cmyk.k)*100));
        }
	});
//```````````````````````````````````````````````````````````````````````````|
//------------------------------Event Style Options--------------------------
//___________________________________________________________________________|
	// event_font_size:10,
	this.col4 = $('<div class="atk-col-3" >Event</div>').appendTo(this.row1);
	this.event_font_size_label = $('<div><label for="day_name_font_size">Font Size :</label></div>').appendTo(this.col4);
	this.event_font_size = $('<select class="btn btn-xs">Event Size</select>').appendTo(this.event_font_size_label);
	for (var i = 7; i < 50; i++) {
		$('<option value="'+i+'">'+i+'</option>').appendTo(this.event_font_size);
	};
	$(this.event_font_size).change(function(event){
		self.current_calendar_component.options.event_font_size = $(this).val();
		$('.xshop-designer-tool').xepan_xshopdesigner('check');
		self.current_calendar_component.render();
	});

	//Event Font Color
	this.event_color_label = $('<div class="xshop-designer-calendar-color-picker"><label for="event_font_color">Color : </label></div>').appendTo(this.col4);
	this.event_color_picker = $('<input id="event_font_color" style="display:none;">').appendTo(this.event_color_label);
	$(this.event_color_picker).colorpicker({
		parts:          'full',
        alpha:          false,
        showOn:         'both',
        buttonColorize: true,
        showNoneButton: true,
        ok: function(event, color){
        	// self.current_calendar_component.options.header_font_color = parseInt((color.cmyk.c)*100)+','+parseInt((color.cmyk.m)*100)+','+parseInt((color.cmyk.y)*100)+','+parseInt((color.cmyk.k)*100);
        	self.current_calendar_component.options.event_font_color = '#'+color.formatted;
        	$('.xshop-designer-tool').xepan_xshopdesigner('check');
        	self.current_calendar_component.render();
        	// console.log('#'+color.formatted);
        	// console.log(parseInt((color.cmyk.c)*100)+','+parseInt((color.cmyk.m)*100)+','+parseInt((color.cmyk.y)*100)+','+parseInt((color.cmyk.k)*100));
        }
	});


//```````````````````````````````````````````````````````````````````````````|
//------------------------------Month Style Options--------------------------
//___________________________________________________________________________|
	//Month
	$('<hr>').appendTo(this.element);
	this.row2 = $('<div class="atk-row" style="display:block;margin:0;"></div>').appendTo(this.element);
	this.col5 = $('<div class="atk-col-3"></div>').appendTo(this.row2);
	
	this.month_label = $('<label for="month">Month :</label>').appendTo(this.col5);
	this.month = $('<select id="month" class="btn btn-xs"></select>').appendTo(this.month_label);
	options = '<option value="00">Starting</option>';
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
		if($(this).val() == "00"){
			self.current_calendar_component.options.month = self.current_calendar_component.options.starting_month;
		}else{
			self.current_calendar_component.options.month = $(this).val();
		}
		$('.xshop-designer-tool').xepan_xshopdesigner('check');
		self.current_calendar_component.render();

	});	


//```````````````````````````````````````````````````````````````````````````|
//------------------------------Starting Month Style Options-----------------
//___________________________________________________________________________|
	//Choose Your Calendar's Starting Month 
	this.col6 = $('<div class="atk-col-3"></div>').appendTo(this.row2);
	this.starting_month = $('<label for="startDate">Starting Month :</label>').appendTo(this.col6);
	this.starting_month_text = $('<input name="startDate" id="xshop-designer-startDate" class="xshop-designer-calendar-month-picker" />').appendTo(this.starting_month);	
	$('.xshop-designer-calendar-month-picker').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'MM yy',
        onClose: function(dateText, inst) { 
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var month = parseInt(month) + 1;
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();

            $(this).attr('month',month);
            $(this).attr('year',year);
            $(this).datepicker('setDate', new Date(year, month, 0));

            self.designer_tool.options.calendar_starting_month = $(this).val();
            self.current_calendar_component.options.starting_date = $(this).val();
    		self.current_calendar_component.options.starting_month = month;
    		self.current_calendar_component.options.starting_year = year;
    		if(!self.current_calendar_component.options.month)
    			self.current_calendar_component.options.month = month;
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


//```````````````````````````````````````````````````````````````````````````|
//------------------------------Starting Month Style Options-----------------
//___________________________________________________________________________| 
    //Calendar Events
	this.col7 = $('<div class="atk-col-3"></div>').appendTo(this.row2);
    event_btn = $('<div class="btn atk-swatch-blue"><i class="glyphicon glyphicon-star-empty"></i>Events</div>').appendTo(this.col7);
	
	event_frame = $('<div id="xshop-designer-calendar-events-dialog" class="xshop-designer-calendar-events-frame"></div>').appendTo(this.element);

	form_row = $('<div class="atk-row atk-padding-small">').appendTo(event_frame);
	form_col1 = $('<div class="atk-col-4">').appendTo(form_row);
	this.event_date = $('<input type="text" name="event_date" id="xshop-designer-calendar-event-date" PlaceHolder="Date"/>').appendTo(form_col1);
	form_col2 = $('<div class="atk-col-6">').appendTo(form_row);
	this.event_message = $('<input type="text" name="event" id="xshop-designer-calendar-event" PlaceHolder="Event"/>').appendTo(form_col2);
	form_col3 = $('<div class="atk-col-2">').appendTo(form_row);
	this.event_add = $(' <button type="button">Add</button> ').appendTo(form_col3);
	// this.event_date = $('<input type="text" name="event_date" id="xshop-designer-calendar-event-date" PlaceHolder="Date"/>').appendTo(event_frame);
	// this.event_message = $('<input type="text" name="event" id="xshop-designer-calendar-event" PlaceHolder="Event"/>').appendTo(event_frame);
	// this.event_add = $(' <button type="button">Add</button> ').appendTo(event_frame);
		
	$(this.event_date).datepicker({
		dateFormat: 'dd-MM-yy'
	});

	event_dialog= event_frame.dialog({
	 	autoOpen: false,
		width: 500,
		modal: true,
		open:function(){
			
			$('div').remove('#xshop-designer-calendar-events');
			table = '<div id="xshop-designer-calendar-events" class="atk-box"><div class="atk-table atk-table-zebra atk-table-bordered"><div class="atk-box-small atk-align-center"><h3>Your All Events</h3></div><table><thead><tr><th>Date</th><th>Message</th><th>Actions</th></tr></thead><tbody>';
			$.each(self.designer_tool.options.calendar_event,function(index,month_events){
				$.each(month_events,function(date,message){
					table += '<tr><td>'+date+'</td><td>'+message+'</td><td><a href="#">Edit</a></td></tr>';
				});
			});

			table +='</tbody></table></div></div>';
			$(table).appendTo(this);
		},
		close:function(){

		}
	});

	$(event_btn).click(function(event){
		event_dialog.dialog("open");
	});

	$(this.event_add).click(function(event){
		curr_month = self.current_calendar_component.options.month;
		
		if(self.designer_tool.options.calendar_event[curr_month]== undefined)
		self.designer_tool.options.calendar_event[curr_month]= new Object;

		self.designer_tool.options.calendar_event[curr_month][self.event_date.val()]=new Object;
		// self.designer_tool.options.calendar_event[curr_month][self.event_date.val()] = self.event_message.val();
		self.designer_tool.options.calendar_event[curr_month][self.event_date.val()] = self.event_message.val();
		self.current_calendar_component.render();
		$(event_dialog).dialog('close');
	});


//```````````````````````````````````````````````````````````````````````````|
//------------------------------Delete Button--------------------------------
//___________________________________________________________________________| 
	//Delete Button
	this.col8 = $('<div class="atk-col-3"></div>').appendTo(this.row2);
	this.calendar_remove = $('<div class="btn atk-swatch-red"><span class="glyphicon glyphicon-trash"></span> Remove</div>').appendTo(this.col8);
	this.calendar_remove.click(function(){
		dt  = self.current_calendar_component.designer_tool;
		$.each(dt.pages_and_layouts[dt.current_page][dt.current_layout].components, function(index,cmp){
			if(cmp === dt.current_selected_component){
				// console.log(self.pages_and_layouts);
				$(dt.current_selected_component.element).remove();
				dt.pages_and_layouts[dt.current_page][dt.current_layout].components.splice(index,1);
				dt.current_selected_component = null;
				dt.option_panel.hide();
			}
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
		header_font_color:'#000000',
		day_date_font_size:12,
		day_date_font_color:'#00000',
		day_name_font_size:12,
		day_name_font_color:'#00000',
		event_font_size:10,
		event_font_size:'#00000',
		day_name_bg_color:'#FFFFFF',
		calendar_cell_heigth:20,

		month:undefined,
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
		y:undefined,
		events:{},
		type: 'Calendar',
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

	this.render = function(place_in_center){

		var self = this;
		if(self.options.load_design == true){
			self.designer_tool.options.calendar_event = JSON.parse(self.options.events);
			self.designer_tool.options.calendar_starting_month = self.options.starting_month;
			self.options.load_design = "false";
			console.log(self.designer_tool.options.calendar_event);
			console.log(self.designer_tool.options.calendar_starting_month);
		}
		// console.log(JSON.stringify(self.designer_tool.options.calendar_event));
		// console.log(self.designer_tool.options.calendar_event);
		self.options.events = JSON.stringify(self.designer_tool.options.calendar_event);
		self.options.starting_date = self.designer_tool.options.calendar_starting_month;

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
				handles: "e, se, s",
				autoHide: true,
				stop: function(e,ui){
					self.options.width = self.designer_tool.screen2option(ui.size.width);
					self.options.height = self.designer_tool.screen2option(ui.size.height);
					// alert(self.options.width);
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
					header_font_size:self.options.header_font_size,
					header_font_color:self.options.header_font_color,
					day_date_font_size:self.options.day_date_font_size,
					day_date_font_color:self.options.day_date_font_color,
					day_name_font_size:self.options.day_name_font_size,
					day_name_font_color:self.options.day_name_font_color,
					event_font_size:self.options.event_font_size,
					event_font_color:self.options.event_font_color,
					day_name_bg_color:self.options.day_name_bg_color,
					calendar_cell_heigth:self.options.calendar_cell_heigth,

					zoom: self.designer_tool.zoom,
					zindex:self.options.zindex,
					month:self.options.month,
					width:self.options.width,
					height:self.options.height,

					starting_date:self.designer_tool.options.calendar_starting_month, //Show Only Date and Month // Default Value currentYear-1st Jan Month
					starting_month:self.options.starting_month,
					starting_year:self.options.starting_year,
					resizable:self.options.resizable,
					movable:self.options.movable,
					colorable:self.options.colorable,
					editor:self.options.editor,
					designer_mode:self.options.designer_mode,
					x:self.options.x,
					y:self.options.y,
					events:JSON.stringify(self.designer_tool.options.calendar_event)
					},
		})
		.done(function(ret) {
			self.element.find('img').attr('src','data:image/jpg;base64, '+ ret);
			// $(ret).appendTo(self.element.find('span').html(''));
			self.xhr=undefined;
			if(place_in_center){
				window.setTimeout(function(){
					self.element.center(self.designer_tool.canvas);
					self.options.x = self.element.css('left').replace('px','') / self.designer_tool.zoom;
					self.options.y = self.element.css('top').replace('px','') / self.designer_tool.zoom;
				},200);
				place_in_center = 0;
			}
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