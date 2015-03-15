var shortcut_menu_pages = [];

$.each({
	setUpShortMenus: function(menus){
		shortcut_menu_pages = menus;
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
					$.univ.frameURL(ui.item.label,ui.item.value);	
				}
			}).on('blur', function(event) {
				event.target.value = event.target.value.replace(/[,]/, '.');
			});
		event.stopPropagation();
	});
});