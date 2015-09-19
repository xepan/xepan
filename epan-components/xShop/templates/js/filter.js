// xEpan Filter jQuery Widget for extended xShop elements 
;
jQuery.widget("ui.xepan_xshopfilter",{
	options:{
		filter_design:[],
		html_attributes:[],
		url:undefined,
		selected_filter_value:undefined,
		category_id:undefined,
		min_price:undefined,
		max_price:undefined
	},
	filter_container:null,
	selected_value:{},


	_create: function(){
		this.setupLayout();
	},

	setupLayout: function(){
		var self = this;

		url = '';
		if(self.options.url)
			url = self.options.url;
		
		self.filter_container = $('<div id="accordion" class="xshop-filter-tool"></div>');
		self.filter_container.prependTo(self.element);

		if(self.options.filter_design.length === 0){
			$('<div class="xshop-filter-tool-notfound atk-swatch-red">Not Filter Found</div>');
			return;
		}

		//Add price Filter
		html_attr = self.options.html_attributes;

		if(html_attr['show-price-filter'] == "1"){
			var header = $('<ul class="list-group xshop-xfilter-ul" ><li class="list-group-item xshop-xfilter-list-group-header"><h1 class="xshop-filter-tool-header xfilter-price-header">'+(html_attr['xfilter-price-label']?html_attr['xfilter-price-label']:'Price')+'</h1></li></ul>').appendTo(self.filter_container);
			slider_div = $('<li class="list-group-item xshop-xfilter-list-group-item "></li>').appendTo(header);

			range_slider = $('<div class="xshop-xfilter-price-range"></div>').appendTo(slider_div);
			min_max = $('<div class="atk-row"><div class="atk-col-4"><span class="pull-left">'+html_attr['xshop-filter-start-price']+'</span></div><div class="atk-col-4 atk-align-center "><span class="current_value"></span></div><div class="atk-col-4"><span class="pull-right">'+html_attr['xshop-filter-end-price']+'</span></div></div>').appendTo(slider_div);

			selected_min_price = parseInt(html_attr['xshop-filter-start-price']);
			selected_max_price = parseInt(html_attr['xshop-filter-end-price']);


			if(parseInt(self.options.min_price) != undefined && parseInt(self.options.min_price) >= 0){
				selected_min_price = parseInt(self.options.min_price);
			}

			if(parseInt(self.options.max_price) != undefined && parseInt(self.options.max_price) >= 0){
				selected_max_price = parseInt(self.options.max_price);
			}

			$( ".xshop-xfilter-price-range" ).slider({
					range: true,
					min:  parseInt(html_attr['xshop-filter-start-price']),
					max: parseInt(html_attr['xshop-filter-end-price']),
					values: [selected_min_price , selected_max_price],
					create:function(){

						$('.current_value').text(selected_min_price+' - '+selected_max_price);
					},
					slide: function( event, ui ) {
						$('.current_value').text(ui.values[0]+' - '+ui.values[1]);
						},
					change: function(event, ui){
						$.univ.redirect(url+'&xmip='+ui.values[0]+'&xmap='+ui.values[1]);
					}
			});
		}
		

		//Add Specification Filter
		$.each(self.options.filter_design, function(index,spec_values ) {
			var header = $('<ul class="list-group xshop-xfilter-ul" data-spec-name="'+spec_values['specification_name']+'"><li class="list-group-item xshop-xfilter-list-group-header"><h1 class="xshop-filter-tool-header">'+spec_values['specification_name']+'</h1></li></ul>').appendTo(self.filter_container);
			$.each(spec_values['unique_values'],function(spec_value_name,selected){
				var filter_checkbox = $('<li id="#'+index+'" class="list-group-item xshop-xfilter-list-group-item "><label><input data-spec-cat-name="'+spec_values['specification_name']+'" data-spec-cat-id="'+index+'" data-spec-value-name="'+spec_value_name+'" type="checkbox" class="xshop-filter-tool-checkbox"  '+selected+'/> '+spec_value_name+' </label></li>').appendTo(header);
				if(selected === "checked"){
					self.selected_value[index+'-'+spec_value_name] = spec_value_name;
				}

			});
		});

		//Reloading the Page and Passing the Selected Value
		$('.xshop-filter-tool-checkbox').click(function(event){
			if($(this).is(':Checked'))
				self.selected_value[$(this).attr('data-spec-cat-id')+'-'+$(this).attr('data-spec-value-name')] = $(this).attr('data-spec-value-name');

			if(!$(this).is(':Checked')){
				var selected_spec_id = $(this).attr('data-spec-cat-id');
				var selected_spec_value = $(this).attr('data-spec-value-name');
				
				$.each(self.selected_value,function(index,value){
					if(index === selected_spec_id+'-'+selected_spec_value && value === selected_spec_value ){
						delete self.selected_value[index];
					}
				});
			}
			
			var str = "";
			$.each(self.selected_value,function(key,value){
				str += key.split('-')[0]+":"+value+'|';
				// console.log("R"+str);
			});


			$.univ.redirect(url+'&filter_data='+str);
		});
	}

});
