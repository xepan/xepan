// xEpan Filter jQuery Widget for extended xShop elements 
;
jQuery.widget("ui.xepan_xshopfilter",{
	options:{
		filter_design:[],
		html_attributes:[],
		url:undefined,
		selected_filter_value:undefined,
	},
	filter_container:null,
	selected_value:[],


	_create: function(){
		this.setupLayout();
	},

	setupLayout: function(){
		var self = this;
		self.filter_container = $('<div class="xshop-filter-tool"></div>');
		self.filter_container.prependTo(self.element);
		if(self.options.filter_design.length === 0){
			$('<div class="xshop-filter-tool-notfound atk-swatch-red">Not Filter Found</div>');
			return;
		}

		$.each(self.options.filter_design, function(index,spec_values ) {
			var header = $('<ul class="list-group xshop-filter-ul" data-spec-name="'+spec_values['specification_name']+'"><li class="list-group-item"><h1 class="xshop-filter-tool-header">'+spec_values['specification_name']+'</h1></li></ul>').appendTo(self.filter_container);
			$.each(spec_values['unique_values'],function(spec_value_name,selected){
				var filter_checkbox = $('<li id="#'+index+'" class="list-group-item"><input data-spec-cat-name="'+spec_values['specification_name']+'" data-spec-cat-id="'+index+'" data-spec-value-name="'+spec_value_name+'" type="checkbox" class="xshop-filter-tool-checkbox"  '+selected+'> '+spec_value_name+' </li>').appendTo(header);
				
				if(selected === "checked"){
					self.selected_value.push({
						'key': index,
						'value': spec_value_name
					});	
				}

			});
		});

		$('.xshop-filter-tool-checkbox').click(function(event){
			if($(this).is(':Checked')){
				self.selected_value.push({
					'key': $(this).attr('data-spec-cat-id'),
					'value': $(this).attr('data-spec-value-name')
				});
			}

			if(!$(this).is(':Checked')){
				self.selected_value.pop({
					'key': $(this).attr('data-spec-cat-id'),
					'value': $(this).attr('data-spec-value-name')
				});
			}
			
			var str = "";
			$.each(self.selected_value,function(index,filterdata){
				str += filterdata['key']+":"+filterdata['value']+'|';
			});

			console.log(self.selected_value);
			url = '';
			if(self.options.url)
				url = self.options.url;

			$.univ.redirect(url+'&filter_data='+str);
			// console.log(window.location.href);
		});
	}

});
