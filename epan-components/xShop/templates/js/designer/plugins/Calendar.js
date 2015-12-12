xShop_Calendar_Editor = function(parent,designer){
	var self = this;
	this.parent = parent;
	this.current_calendar_component = undefined;
	this.designer_tool = designer;
	this.element = $('<div id="xshop-designer-calendar-editor" class="xshop-options-editor atk-row" style="display:block"> </div>').appendTo(this.parent);
	this.editor_close_btn = $('<div class="atk-row" style="padding:0;margin:0;"><i class="atk-box-small pull-right glyphicon glyphicon-remove"></i></div>').appendTo(this.element);

	$(this.editor_close_btn).click(function(event){
		self.element.hide();
	});

	this.row1 = $('<div class="atk-row" style="display:block;margin:0;"> </div>').appendTo(this.element);

//```````````````````````````````````````````````````````````````````````````|
//------------------------------Header Style Options-------------------------
//___________________________________________________________________________|
	
	// header_font_size:16,
	this.col1 = $('<div class="atk-col-31 atk-box-small atk-box-designer"></div>').appendTo(this.row1);
	$('<div class="xshop-calendar-editor-header" style="">Header</div>').appendTo(this.col1);
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

	/*Header Font Family*/
	
	this.header_font_family_label = $('<div><label for="header_font_family">Font Family :</label></div>').appendTo(this.col1);
	this.header_font_family = $('<select id="header_font_family" class="btn btn-xs">Header Font Family</select>').appendTo(this.header_font_family_label);
	
	// get all fonts via ajax
	$.ajax({
		url: 'index.php?page=xShop_page_designer_fonts',
		type: 'GET',
		data: {param1: 'value1'},
	})
	.done(function(ret) {
		$(ret).appendTo(self.header_font_family);
		// console.log("success");
	})
	.fail(function() {
		// console.log("error");
	})
	.always(function() {
		// console.log("complete");
	});

	$(this.header_font_family).change(function(event){
		self.current_calendar_component.options.header_font_family = $(this).val();
		$('.xshop-designer-tool').xepan_xshopdesigner('check');
		self.current_calendar_component.render();
	});


//```````````````````````````````````````````````````````````````````````````|
//------------------------------Day Date Style Options-----------------------
//___________________________________________________________________________|
	// day_date_font_size:12,
	this.col2 = $('<div class="atk-col-31 atk-box-small atk-box-designer"></div>').appendTo(this.row1);
	$('<div class="xshop-calendar-editor-header" style="">Day Date</div>').appendTo(this.col2);
	// this.col2 = $('<div class="atk-col-31 atk-box-small atk-box-designer"></div>').appendTo(this.row1);
	// $('<div class="atk-col-31" class="xshop-calendar-editor-header" >Day Date</div>').appendTo(this.col2);
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
	this.height_div = $('<div></div>').appendTo(this.col2);
	this.height_label = $('<label for="xshop-designer-calendar-height" style="float:left;">Height :</label>').appendTo(this.height_div);
	this.cell_height = $('<input type="number" id="xshop-designer-calendar-height"  min="10" max="80" value="20" style="padding:0;font-size:12px;float:left;width:60px !important" />').appendTo(this.height_div);

	$(this.cell_height).change(function(event){
		self.current_calendar_component.options.calendar_cell_heigth = $(this).val();
		$('.xshop-designer-tool').xepan_xshopdesigner('check');
		self.current_calendar_component.render();

	});	

	//```````````````````````````````````````````````````````````````````````````|
	//----------------------------Day Date Horizental Alignment Style Options-----
	//___________________________________________________________________________|

	this.alignment_label = $('<div><label for="xcalendar-alignment">H-Align :</label></div>').appendTo(this.col2);
	this.alignment_btn_set = $('<div class="btn-group btn-group-xs xshop-calendar-align" role="group" aria-label="Text Alignment"></div>').appendTo(this.alignment_label);
	this.align_left_btn = $('<div class="btn" title="Left"><span class="glyphicon glyphicon-align-left"></span></div>').appendTo(this.alignment_btn_set);
	this.align_center_btn = $('<div class="btn" title="Center"><span class="glyphicon glyphicon-align-center"></span></div>').appendTo(this.alignment_btn_set);
	this.align_right_btn = $('<div class="btn" title="Right"><span class="glyphicon glyphicon-align-right"></span></div>').appendTo(this.alignment_btn_set);

	$(this.align_left_btn).click(function(){
		$(this).addClass('active');
		self.current_calendar_component.options.alignment = "left";

		//Render Current Selected Calendar
		$('.xshop-designer-tool').xepan_xshopdesigner('check');
		self.current_calendar_component.render();

		//Remove active Align Class form other options
		$(self.align_right_btn).removeClass('active');
		$(self.align_center_btn).removeClass('active');

	});

	$(this.align_center_btn).click(function(){
		$(this).addClass('active');
		self.current_calendar_component.options.alignment = "center";

		//Render Current Selected Calendar
		$('.xshop-designer-tool').xepan_xshopdesigner('check');
		self.current_calendar_component.render();

		//Remove active Align Class form other options
		$(self.align_right_btn).removeClass('active');
		$(self.align_left_btn).removeClass('active');
	});

	$(this.align_right_btn).click(function(){
		$(this).addClass('active');
		self.current_calendar_component.options.alignment = "right";

		//Render Current Selected Calendar
		$('.xshop-designer-tool').xepan_xshopdesigner('check');
		self.current_calendar_component.render();

		//Remove active Align Class form other options
		$(self.align_left_btn).removeClass('active');
		$(self.align_center_btn).removeClass('active');
	});

	//```````````````````````````````````````````````````````````````````````````|
	//----------------------------Day Date Vertical Alignment Style Options-------
	//___________________________________________________________________________|

	this.valignment_label = $('<div><label for="xcalendar-alignment">V</label></div>').appendTo(this.col2);
	this.valignment_btn_set = $('<div class="btn-group btn-group-xs xshop-calendar-valign" role="group" aria-label="Text Alignment"></div>').appendTo(this.valignment_label);
	this.valign_top_btn = $('<div class="btn" title="Top"><span class="glyphicon glyphicon-align-left"></span></div>').appendTo(this.valignment_btn_set);
	this.valign_middle_btn = $('<div class="btn" title="Middle"><span class="glyphicon glyphicon-align-center"></span></div>').appendTo(this.valignment_btn_set);
	this.valign_bottom_btn = $('<div class="btn" title="Bottom"><span class="glyphicon glyphicon-align-right"></span></div>').appendTo(this.valignment_btn_set);

	$(this.valign_top_btn).click(function(){
		$(this).addClass('active');
		self.current_calendar_component.options.valignment = "top";

		//Render Current Selected Calendar
		$('.xshop-designer-tool').xepan_xshopdesigner('check');
		self.current_calendar_component.render();

		//Remove active Align Class form other options
		$(self.valign_middle_btn).removeClass('active');
		$(self.valign_bottom_btn).removeClass('active');

	});

	$(this.valign_middle_btn).click(function(){
		$(this).addClass('active');
		self.current_calendar_component.options.valignment = "middle";

		//Render Current Selected Calendar
		$('.xshop-designer-tool').xepan_xshopdesigner('check');
		self.current_calendar_component.render();

		//Remove active Align Class form other options
		$(self.valign_top_btn).removeClass('active');
		$(self.valign_bottom_btn).removeClass('active');

	});

	$(this.valign_bottom_btn).click(function(){
		$(this).addClass('active');
		self.current_calendar_component.options.valignment = "bottom";

		//Render Current Selected Calendar
		$('.xshop-designer-tool').xepan_xshopdesigner('check');
		self.current_calendar_component.render();

		//Remove active Align Class form other options
		$(self.valign_top_btn).removeClass('active');
		$(self.valign_middle_btn).removeClass('active');

	});
//```````````````````````````````````````````````````````````````````````````|
//------------------------------Day Name Style Options-----------------------
//___________________________________________________________________________|
	// day_name_font_size:12,
	// this.col3 = $('<div class="atk-col-31"><b class="xshop-calendar-editor-header">Day Name</b></div>').appendTo(this.row1);
	
	this.col3 = $('<div class="atk-col-31 atk-box-small atk-box-designer"></div>').appendTo(this.row1);
	$('<div class="xshop-calendar-editor-header" style="">Day Name</div>').appendTo(this.col3);

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
	// this.col4 = $('<div class="atk-col-31"><b class="xshop-calendar-editor-header">Event</b></div>').appendTo(this.row1);
	this.col4 = $('<div class="atk-col-31 atk-box-small atk-box-designer"></div>').appendTo(this.row1);
	$('<div class="xshop-calendar-editor-header" style="">Event </div>').appendTo(this.col4);
	
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
	// $('<hr>').appendTo(this.element);
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
	this.col6 = $('<div class="atk-col-5 xdesigner-starting-month"></div>').appendTo(this.row2);
	this.starting_month = $('<label for="startDate">Starting Month :</label>').appendTo(this.col6);
	this.starting_month_text = $('<input name="startDate" id="xshop-designer-startDate" class="xshop-designer-calendar-month-picker" />').appendTo(this.col6);	
	this.starting_month_datepicker = $('.xshop-designer-calendar-month-picker').datepicker( {
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
    // <div class="atk-buttonset">
    	//<button class="atk-button">Button</button>
    	//<button class="atk-button">Button</button>
    	//<button class="atk-button">Button</button>
    //</div>
	this.col7 = $('<div class="atk-col-4"></div>').appendTo(this.row2);
	this.buttonset = $('<div class="atk-buttonset"></div>').appendTo(this.col7);
    event_btn = $('<button class="atk-button atk-swatch-blue"><i class="glyphicon glyphicon-star-empty"></i>Add Events </button>').appendTo(this.buttonset);
	
	event_frame = $('<div id="xshop-designer-calendar-events-dialog" class="xshop-designer-calendar-events-frame"></div>').appendTo(this.element);

	form_row = $('<div class="atk-row atk-padding-small">').appendTo(event_frame);
	form_col1 = $('<div class="atk-col-4">').appendTo(form_row);
	this.event_date = $('<input type="text" name="event_date" id="xshop-designer-calendar-event-date" PlaceHolder="Date"/>').appendTo(form_col1);
	form_col2 = $('<div class="atk-col-6">').appendTo(form_row);
	this.event_message = $('<input type="text" name="event" id="xshop-designer-calendar-event" PlaceHolder="Event"/>').appendTo(form_col2);
	form_col3 = $('<div class="atk-col-2">').appendTo(form_row);
	this.event_add = $(' <button type="button">Add</button> ').appendTo(form_col3);
	this.event_count = $('<span class="badge1 xshop-designer-calendar-event-count"  title="Total Event Count"></span>').appendTo(event_btn);
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
			$('.xshop-designer-calendar-event-count').empty();
			$('.xshop-designer-calendar-event-count').text(' '+self.getCalendarEvent());
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
		$(self.event_message).val("");
		self.event_date.val("");
	});
	
	this.getCalendarEvent = function(){		
		// console.log(self.current_calendar_component);
		count = 0 ;
		$.each(self.designer_tool.options.calendar_event,function(index,month_events){
				$.each(month_events,function(date,message){
					count += 1;
				});
			});

		return count;
	};



//```````````````````````````````````````````````````````````````````````````|
//------------------------------Delete Button--------------------------------
//___________________________________________________________________________| 
	// this.col8 = $('<div class="atk-col-3"></div>').appendTo(this.row2);
	this.calendar_remove = $('<button class="atk-button atk-swatch-red" title="Remove Selected Calendar"><span class="glyphicon glyphicon-trash"></span></button>').appendTo(this.buttonset);
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

//```````````````````````````````````````````````````````````````````````````|
//------------------------------Add Hide Show Button-------------------------
//___________________________________________________________________________| 
	this.hide_show_btn = $('<button class="atk-button btn-warning" title="Hide or show thw options"> <i class="icon-atkcog"></i> </button>').appendTo(this.buttonset);
	hide_show_frame = $('<div id="xshop-designer-calendar-options-dialog" class="xshop-designer-calendar-options-frame"></div>').appendTo(this.element);
	
	header_options = $('<div class="panel panel-default xshop-calendar-editor-options-to-show"><div class="panel-heading">Header options to show/hide</div><div class="panel-body"></div><ul class="list-group"><li class="list-group-item" data_variable="hide_header_font_size">Font Size<input data_variable="hide_header_font_size" class="xshop-calendar-show-hide-checkbox" type="checkbox" /></li><li class="list-group-item" data_variable="hide_header_font_color">Font Color<input data_variable="hide_header_font_color" class="xshop-calendar-show-hide-checkbox" type="checkbox" /></li></ul></div>').appendTo(hide_show_frame);
	day_date_options = $('<div class="panel panel-default xshop-calendar-editor-options-to-show"><div class="panel-heading">Day Date options to show/hide</div><div class="panel-body"></div><ul class="list-group"><li class="list-group-item" data_variable="hide_day_date_font_size">Font Size<input data_variable="hide_day_date_font_size" class="xshop-calendar-show-hide-checkbox" type="checkbox" /></li><li class="list-group-item" data_variable="hide_day_date_font_color">Font Color<input data_variable="hide_day_date_font_color" class="xshop-calendar-show-hide-checkbox" type="checkbox" /></li><li class="list-group-item" data_variable="hide_day_date_font_height">Cell Height<input data_variable="hide_day_date_font_height" class="xshop-calendar-show-hide-checkbox" type="checkbox" /></li></ul></div>').appendTo(hide_show_frame);
	day_name_options = $('<div class="panel panel-default xshop-calendar-editor-options-to-show"><div class="panel-heading">Day Name options to show/hide</div><div class="panel-body"></div><ul class="list-group"><li class="list-group-item" data_variable="hide_day_name_font_size">Font Size<input data_variable="hide_day_name_font_size" class="xshop-calendar-show-hide-checkbox" type="checkbox" /></li><li class="list-group-item" data_variable="hide_day_name_font_color">Font Color<input data_variable="hide_day_name_font_color" class="xshop-calendar-show-hide-checkbox" type="checkbox" /></li><li class="list-group-item" data_variable="hide_day_name_font_bg_color">Background Color<input data_variable="hide_day_name_font_bg_color" class="xshop-calendar-show-hide-checkbox" type="checkbox" /></li></ul></div>').appendTo(hide_show_frame);
	event_options = $('<div class="panel panel-default xshop-calendar-editor-options-to-show"><div class="panel-heading">Event options to show/hide</div><div class="panel-body"></div><ul class="list-group"><li class="list-group-item" data_variable="hide_event_font_size">Font Size	<input data_variable="hide_event_font_size" class="xshop-calendar-show-hide-checkbox" type="checkbox" /></li><li class="list-group-item" data_variable="hide_event_font_color">Font Color	<input data_variable="hide_event_font_color" class="xshop-calendar-show-hide-checkbox" type="checkbox" /></li></ul></div>').appendTo(hide_show_frame);
	other_calendar_options = $('<div class="panel panel-default xshop-calendar-editor-options-to-show"><div class="panel-heading">Other Calendar options to show/hide</div><div class="panel-body"></div><ul class="list-group"><li class="list-group-item" data_variable="hide_month">Hide Month/Sequence<input data_variable="hide_month" class="xshop-calendar-show-hide-checkbox" type="checkbox" /></li><li class="list-group-item" data_variable="hide_starting_month">Starting Month<input data_variable="hide_starting_month" class="xshop-calendar-show-hide-checkbox" type="checkbox" /></li><li class="list-group-item" data_variable="hide_remove_btn">Remove Button<input data_variable="hide_remove_btn" class="xshop-calendar-show-hide-checkbox" type="checkbox" /></li></ul></div>').appendTo(hide_show_frame);

	$('.xshop-calendar-editor-options-to-show  li').click(function(event){
		option = $(this).attr('data_variable');
		current_value = eval('self.current_calendar_component.options.'+option);
		if(current_value == true)
			current_value=false;
		else
			current_value=true;

		eval('self.current_calendar_component.options.'+option+' = '+current_value+';');
		$(this).find(':checkbox').prop('checked', current_value);
	});

	option_display_dialog = hide_show_frame.dialog({
	 	autoOpen: false,
		width: 500,
		modal: true,
		height:400,
		open:function(){
			// console.log(self.current_calendar_component.options);
			//Show to default/Save Options
			$('input[data_variable="hide_header_font_size"]').prop('checked',self.current_calendar_component.options.hide_header_font_size);
			$('input[data_variable="hide_header_font_color"]').prop('checked',self.current_calendar_component.options.hide_header_font_color);
			
			$('input[data_variable="hide_day_date_font_size"]').prop('checked',self.current_calendar_component.options.hide_day_date_font_size);
			$('input[data_variable="hide_day_date_font_color"]').prop('checked',self.current_calendar_component.options.hide_day_date_font_color);
			$('input[data_variable="hide_day_date_font_height"]').prop('checked',self.current_calendar_component.options.hide_day_date_font_height);
			
			$('input[data_variable="hide_day_name_font_size"]').prop('checked',self.current_calendar_component.options.hide_day_name_font_size);
			$('input[data_variable="hide_day_name_font_color"]').prop('checked',self.current_calendar_component.options.hide_day_name_font_color);
			$('input[data_variable="hide_day_name_font_bg_color"]').prop('checked',self.current_calendar_component.options.hide_day_name_font_bg_color);

			$('input[data_variable="hide_event_font_size"]').prop('checked',self.current_calendar_component.options.hide_event_font_size);
			$('input[data_variable="hide_event_font_color"]').prop('checked',self.current_calendar_component.options.hide_event_font_color);

			$('input[data_variable="hide_month"]').prop('checked',self.current_calendar_component.options.hide_month);
			$('input[data_variable="hide_starting_month"]').prop('checked',self.current_calendar_component.options.hide_starting_month);
			$('input[data_variable="hide_remove_btn"]').prop('checked',self.current_calendar_component.options.hide_remove_btn);
		
		}
	});

	$(this.hide_show_btn).click(function(){
		option_display_dialog.dialog("open");
	});

    //Set from Saved Values
	this.setCalendarComponent = function(component){
		// console.log(component);
		this.current_calendar_component  = component;		
		$(this.header_font_size).val(component.options.header_font_size);
		$(this.header_color_picker).colorpicker('setColor',component.options.header_font_color);

		$(this.day_date_color_picker).colorpicker('setColor',component.options.day_date_font_color);
		$(this.day_date_font_size).val(component.options.day_date_font_size);

		$(this.day_name_bg_color_picker).colorpicker('setColor',component.options.day_name_bg_color);

		$(this.day_name_color_picker).colorpicker('setColor',component.options.day_name_font_color);
		$(this.day_name_font_size).val(component.options.day_name_font_size);

		$(this.event_color_picker).colorpicker('setColor',component.options.event_font_color);
		$(this.event_font_size).val(component.options.event_font_size);
		
		$(this.height).val(component.options.height);

		$(this.events).val(component.options.events);
		$(this.calendar_cell_heigth).val(component.options.calendar_cell_heigth);
		$(this.designer_mode).val(component.options.designer_mode);
		$(this.load_design).val(component.options.load_design);

		$(this.month).val(component.options.month);
		$(this.starting_date).val(component.options.starting_date);

		$(this.starting_month_datepicker).datepicker('setDate',new Date(component.options.starting_year,parseInt(component.options.starting_month),0));

		$(this.starting_year).val(component.options.starting_year);
		$(this.type).val(component.options.type);
		$(this.width).val(component.options.width);
		$(this.x).val(component.options.x);
		$(this.y).val(component.options.y);

		$(this.event_count).html(self.getCalendarEvent());

		if(component.options.designer_mode == false && 0){
			//Hide Header Font Size
			if(component.options.hide_header_font_size){
				$(this.header_font_size_label).hide();
				$(this.header_font_color).hide();
			}else{
				$(this.header_font_size_label).show();
				$(this.header_font_color).show();

			}

			if(component.options.hide_header_font_color){
				$(this.header_color_label).hide();
				$(this.header_color_picker).hide();
			}else{
				$(this.header_color_label).show();
				$(this.header_color_picker).show();

			}


			//Hide Day Date Font Size
			if(component.options.hide_day_date_font_size){
				$(this.day_date_font_size_label).hide();
				$(this.day_date_font_size).hide();
			}else{
				$(this.day_date_font_size_label).show();
				$(this.day_date_font_size).show();
			}

			//Hide Day Date Font color
			if(component.options.hide_day_date_font_color){
				$(this.day_date_color_picker).hide();
				$(this.day_date_color_label).hide();
			}else{
				$(this.day_date_color_picker).show();
				$(this.day_date_color_label).show();
			}

			//Hide Day Date Font Height
			if(component.options.hide_day_date_font_height){
				$(this.height_label).hide();
				$(this.cell_height).hide();
			}else{
				$(this.height_label).show();
				$(this.cell_height).show();
			}

			//Hide Day Name Font Size
			if(component.options.hide_day_name_font_size){
				$(this.day_name_font_size_label).hide();
				$(this.day_name_font_size).hide();
			}else{
				$(this.day_name_font_size_label).show();
				$(this.day_name_font_size).show();
			}

			//Hide Day Name Font Color
			if(component.options.hide_day_name_font_color){
				$(this.day_name_color_label).hide();
				$(this.day_name_color_picker).hide();
			}else{
				$(this.day_name_color_label).show();
				$(this.day_name_color_picker).show();
			}

			//Hide Day Name Font BG Color
			if(component.options.hide_day_name_font_bg_color){
				$(this.day_name_bg_color_label).hide();
				$(this.day_name_bg_color_picker).hide();
			}else{
				$(this.day_name_bg_color_label).show();
				$(this.day_name_bg_color_picker).show();
			}

			//Hide Event Font Size
			if(component.options.hide_event_font_size){
				$(this.event_font_size_label).hide();
				$(this.event_font_size).hide();
			}else{
				$(this.event_font_size_label).show();
				$(this.event_font_size).show();
			}

			//Hide Event Font Color
			if(component.options.hide_event_font_color){
				$(this.event_color_label).hide();
				$(this.event_color_picker).hide();
			}else{
				$(this.event_color_label).show();
				$(this.event_color_picker).show();
			}

			//Hide Month 
			if(component.options.hide_month){
				$(this.month_label).hide();
				$(this.month).hide();
			}else{
				$(this.month_label).show();
				$(this.month).show();
			}

			//Hide Starting Month
			if(component.options.hide_starting_month){
				$(this.starting_month_datepicker).hide();
				$(this.starting_month).hide();
			}else{
				$(this.starting_month_datepicker).show();
				$(this.starting_month).show();
			}
			
			//Hide Remove Button
			if(component.options.hide_remove_btn){
				$(this.calendar_remove).hide();
			}else{
				$(this.calendar_remove).show();
			}
		}

	}
}


Calendar_Component = function (params){
	this.parent=undefined;
	this.designer_tool= undefined;
	this.canvas= undefined;
	this.element = undefined;
	this.editor = undefined;
	this.options = {
		header_font_size:32,
		header_font_color:'#000000',
		header_font_family:'freemono',
		day_date_font_size:20,
		day_date_font_color:'#00000',
		day_date_font_family:'freemono',
		day_name_font_size:25,
		day_name_font_color:'#00000',
		day_name_font_family:'freemono',
		event_font_size:10,
		event_font_family:'freemono',
		event_font_size:'#00000',
		day_name_bg_color:'#FFFFFF',
		calendar_cell_heigth:20,
		alignment: "center",
		valignment:'middle',

		month:undefined,
		width:400,
		height:250,

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

		movable:false,
		hide_header_font_size:true,
		hide_header_font_color:true,

		hide_day_date_font_size:true,
		hide_day_date_font_color:true,
		hide_day_date_font_height:true,

		hide_day_name_font_size:true,
		hide_day_name_font_color:true,
		hide_day_name_font_bg_color:true,

		hide_event_font_size:true,
		hide_event_font_color:true,

		hide_month:false,
		hide_starting_month:false,
		hide_remove_btn:true
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
			self.designer_tool.options.calendar_starting_month = self.options.starting_date;
			self.options.load_design = "false";
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
					// alert(self.options.height);
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
					header_font_family:self.options.header_font_family,
					day_date_font_size:self.options.day_date_font_size,
					day_date_font_color:self.options.day_date_font_color,
					day_name_font_size:self.options.day_name_font_size,
					day_name_font_color:self.options.day_name_font_color,
					event_font_size:self.options.event_font_size,
					event_font_color:self.options.event_font_color,
					day_name_bg_color:self.options.day_name_bg_color,
					calendar_cell_heigth:self.options.calendar_cell_heigth,
					alignment:self.options.alignment,
					valignment:self.options.valignment,

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
					events:JSON.stringify(self.designer_tool.options.calendar_event),

					movable:self.options.movable,
					hide_header_font_size:self.options.hide_header_font_size,
					hide_header_font_color:self.options.hide_header_font_color,

					hide_day_date_font_size:self.options.hide_day_date_font_size,
					hide_day_date_font_color:self.options.hide_day_date_font_color,
					hide_day_date_font_height:self.options.hide_day_date_font_height,

					hide_day_name_font_size:self.options.hide_day_name_font_size,
					hide_day_name_font_color:self.options.hide_day_name_font_color,
					hide_day_name_font_bg_color:self.options.hide_day_name_font_bg_color,

					hide_event_font_size:self.options.hide_event_font_size,
					hide_event_font_color:self.options.hide_event_font_color,

					hide_month:self.options.hide_month,
					hide_starting_month:self.options.hide_starting_month,
					hide_remove_btn:self.options.hide_remove_btn
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