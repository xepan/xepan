<?php

class page_xShop_page_owner_dashboard extends page_xShop_page_owner_main{

	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Dashboard';

		$cols = $this->add('Columns');
		$col1 = $cols->addColumn(3);

		$html = '<div class="tile bg-cyan" style="background-color:{bgcolor};width:100%;height:150px;position:relative;">
                        <div class="brand">
                        	<h2 style="color:white;" class="text-center">New Order</h2>
                            <div style="bottom:0;display:block;position:relative;background-color:{bgcolor};position:absolute;" class="badge">
                            	<i class="icon-box">
                            	</i>
                            </div>
                            <div style="bottom:0;right:0;display:block;position:relative;background-color:{bgcolor};position:absolute;" class="badge">
                            	<i class="icon-money">
                            		2000
                            	</i>
                            </div>
                        </div>
                    </div>';


        $col1_html = str_replace('{bgcolor}', '#1ba1e2', $html);
		$col1->add('View')->setHtml($col1_html);
		
        $col2_html = str_replace('{bgcolor}', '#fa6800', $html);
		$col2 = $cols->addColumn(3);
		$col2->add('View')->setHtml($col2_html);
		
        $col3_html = str_replace('{bgcolor}', '#bf5a15', $html);
		$col3 = $cols->addColumn(3);
		$col3->add('View')->setHtml($col3_html);
		
        $col4_html = str_replace('{bgcolor}', '#9a1616', $html);
		$col4 = $cols->addColumn(3);
		$col4->add('View')->setHtml($col4_html);

		//Colors
		//#e3c800(yellow),#004050(darkteal),#825a2c(brown),#003e00(DarkEmerald)
		//#a4c400(lime),#6d8764(olive),#128023(drakGreen),#647687(steel),
		//#bf5a15(dark-orange),#1b6eae(darkblue)

		$html1='<div style="position:relative;">
				<div style="color:{color};background-color:{bgcolor};height:{height};" class="text-center">
                    <h1 style="font-size: 100px; line-height: 80px; margin-bottom: 30px;color:{color}">{count}</h1>
                    <p>Today Promised Order</p>
                </div>
                <span style="position:absolute;right:0;top:0;" class="caret"></span>
                </div>';

        $this->add('View')->setHtml('<br>');

        $cols2 = $this->add('Columns')->addClass('well');
        $grid_col4 = $cols2->addColumn(4);
        $grid_col8 = $cols2->addColumn(8);
        $g1_html = str_replace('{bgcolor}', '#6d8764', $html1);
        $g1_html = str_replace('{height}', '325px', $g1_html);
        $g1_html = str_replace('{count}', '99', $g1_html);
        $g1_html = str_replace('{color}', 'white', $g1_html);
        $grid_col4->add('View')->setHtml($g1_html)->addStyle('height','400px');
        
        $m = $this->add('xShop/Model_Order')->setLimit(5);
        $grid_col8->add('xShop/Grid_Order')->setModel($m);
	}
}		