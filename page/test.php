<?php

class page_test extends Page {
	function init(){
		parent::init();
		
		$this->add('Model_EpanTemplates')->_dsql()->truncate();


		$epans = $this->add('Model_Epan');
		foreach ($epans as $e) {
			$epan_template= $this->add('Model_EpanTemplates');
			$epan_template['is_current']=true;
			$epan_template['epan_id']=$epans->id;

			$epan_template->save();
			
			$pages = $epans->ref('EpanPage');

			foreach ($pages as $junk) {
				$pages['template_id'] = $epan_template->id;
				$pages->save();
			}

			$epan_template->destroy();
		}
	}
}