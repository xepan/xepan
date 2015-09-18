var shortcut_menu_pages = [];
var opened_pages = [];
var right_shortcut_on=false;
var up_shortcut_on=false;
var down_shortcut_on=false;

$.each({
	setUpShortMenus: function(menus,called_from){
		shortcut_menu_pages = menus;
		opened_pages.push(called_from);
		console.log(opened_pages);
	}
}, $.univ._import);

$.atk4(function(){

	shortcut.add("Ctrl+Alt+m", function(event) {
		
		if(up_shortcut_on) return;
		up_shortcut_on=true;

		var fuse = new Fuse(shortcut_menu_pages, {
			caseSensitive: false,
			shouldSort: true,
			threshold: 0.6,
			location: 0,
			distance: 100,
			maxPatternLength: 32,
			keys: ["page",'keys']
		});

		var inp = $('<input type="text"/>');
		var outer = $('<div>');
		$(outer)
			.append($('<div><i class="glyphicon glyphicon-leaf"> xEpan </i> Quick Menu </div>').addClass('label label-success'))
			.append(inp)
			.addClass('text-center');


		var d = $(outer).dialog({
			modal: true,
			open: function (event,ui){
				$(inp).focus();
			},
			close : function (event,ui){
				up_shortcut_on = false;
			}
		});

		$(inp).css({
			width: '100%'
		});

		$(inp).autocomplete({
				delay: 0,
				source: function(req, callback) {
					var options=[];
					$.each(fuse.search(req.term), function(index, obj) {
						options.push({value: obj.url, label: obj.page});
					});
					callback(options);
				},
				select: function(event, ui){
					$(outer).dialog('close');
					// console.log(opened_pages);
					// console.log($.inArray(ui.item.value.replace(/[_]/g,'/'),opened_pages));
					if($.inArray(ui.item.value.replace(/[_]/g,'/'),opened_pages) != -1){
						$.univ.errorMessage('Already Opened, Cannot ReOpen');
						return;
					}
					opened_pages.push(ui.item.value)
					$.univ.frameURL(ui.item.label,ui.item.value,{
						close: function(){
							opened_pages.splice( opened_pages.indexOf(ui.item.value), 1 );
							$(this).find('*').remove();
						}
					});	
				}
			}).on('blur', function(event) {
				event.target.value = event.target.value.replace(/[,]/, '.');
			});
		event.stopPropagation();
	});

	shortcut.add("Ctrl+Alt+d", function(event) {

		if(down_shortcut_on) return;
		down_shortcut_on=true;

		var row = $('<div class="atk-row">');
		var col_left = $('<div class="atk-col-12">').appendTo(row);
        var select = $('<select name="Document"><option value="Any">Any</option><option value="xShop/Customer">Customer</option></select>').appendTo(col_left);
		var col_right = $('<div class="atk-col-12">').appendTo(row);

		var inp = $('<input type="text"/>').appendTo(row);
		$(inp).appendTo(col_right);

		var outer = $('<div>');
		$(outer)
			.append($('<div class="atk-box"><i class="glyphicon glyphicon-leaf"> xEpan </i> Document Search </div>'))
			// .append(inp)
			.append(row)
			.addClass('text-center');


		var dd = $(outer).dialog({
			modal: true,
			width:600,
			height:450,
			open: function (event,ui){
				$(inp).focus();
			},
			close: function(event,ui){
				down_shortcut_on=false;
			}
		});

		$(inp).css({
			width: '100%'
		});

		$(inp).autocomplete({
				delay: 750,
				minLength: 3,
				source: function(request, response) {
	                var other_fields_to_send = {};
	                $.getJSON("index.php?page=owner_searchdoc",
	                    $.extend(other_fields_to_send, {
	                        term: request.term
	                    }), response);
	            },
	            focus: function(event, ui) {
	                // Imants: fix for item selecting with mouse click
	                var e = event;
	                while (e.originalEvent !== undefined) e = e.originalEvent;
	                if (e.type != 'focus') $(this).val(ui.item['name']);

	                return false;
	            },
	            select: function(event, ui) {
	                $(this).val(ui.item['name']);
	                dd.dialog('close');
	                $.univ.frameURL(ui.item['name'],'index.php?page=owner_searchdoc_display&key='+ui.item.id+'&document_model='+ui.item['document_model']);
	                return false;
	            },
			}).data("ui-autocomplete")._renderItem = function(ul, item) {
                return $("<li></li>")
                    .data("ui-autocomplete-item", item)
                    .append('<div class="atk-box-small"> <a>'+ item.document_model +"::" + item.name +"</a>"+'<span class="atk-move-right atk-label atk-effect-info">'+ item.status +"</span>"+"<span>  By: " + item.by +"</span>"+"<span> To: " + item.to +"</span>"+"<div> Date: " + item.date +"</div>"+"<span>" + item.id +"</span>")
                    .appendTo(ul);
                }

		event.stopPropagation();
	});

	shortcut.add("Ctrl+Alt+t", function(event) {
		$.univ().frameURL('xEpan To Do/ Task','index.php?page=xProduction_page_owner_task_shortmenu');

		return;
		
		if(right_shortcut_on) return;
		right_shortcut_on=true;
		var inp = $('<input type="text"/>');

		var outer = $('<div class="xepan-shortmenu-outer-div">');
		$(outer)
			.append($('<div><i class="glyphicon glyphicon-leaf"> xEpan </i> TO DO / Note </div>').addClass('label label-warning'))
			.append(inp)
			.addClass('text-center');


		var dd = $(outer).dialog({
			modal: true,
			open: function (event,ui){
				$(inp).focus();
			},
			close : function(event,ui){
				right_shortcut_on =false;
			}
		});

		$(inp).css({
			width: '100%'
		});

		event.stopPropagation();
	});

});