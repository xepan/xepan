<?php


class Menu extends Menu_Basic {

	function init(){
		parent::init();

		$this->addHook('formatRow',function($m){
				$m->current_row_html['label'] = $m->current_row['label'];
		});
	}

}