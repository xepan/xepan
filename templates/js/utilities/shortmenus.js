var shortcut_menu_pages = [];
var opened_pages = [];

$.each({
	setUpShortMenus: function(menus,called_from){
		shortcut_menu_pages = menus;
		opened_pages.push(called_from);
		console.log(opened_pages);
	}
}, $.univ._import);

$.atk4(function(){
	shortcut.add("Ctrl+up", function(event) {

		var fuse = new Fuse(shortcut_menu_pages, {
			caseSensitive: false,
			shouldSort: true,
			threshold: 0.6,
			location: 0,
			distance: 100,
			maxPatternLength: 32,
			keys: ["page"]
		});

		var inp = $('<input type="text"/>');

		var d = $(inp).dialog({
			open: function (event,ui){
				$(inp).focus();
			}
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
					$(inp).dialog('close');
					if($.inArray(ui.item.value,opened_pages) != -1){
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

	shortcut.add("Ctrl+down", function(event) {

		var inp = $('<input type="text"/>');

		var d = $(inp).dialog({
			open: function (event,ui){
				$(inp).focus();
			}
		});

		$(inp).autocomplete({
				delay: 0
			});
		event.stopPropagation();
	});

});