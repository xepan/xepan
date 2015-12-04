<?php

class Model_GenericDocument extends Model_Document {
	public $table='xepan_generic_documents';

	public $root_document_name = "\GenericDocument";
	public $status=array('public','departmental','shared','private');

	public $actions=array(
		'allow_add'=>array(),
		'allow_edit'=>array(),
		'allow_del'=>array(),
		'can_start_processing'=>array('caption'=>'Create New')
		);

	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		$this->hasOne('Model_GenericDocumentCategory','generic_doc_category_id')->mandatory(true);

		$this->addField('name')->mandatory(true);
		$this->addField('content')->type('text')->display(array('form'=>'RichText'));
		$this->addField('is_template')->type('boolean')->defaultValue(false);
		$this->addField('allow_edit_other')->type('boolean')->defaultValue(false)->system(true);
		$this->addField('share_till')->type('date')->system(true);

		$this->hasMany('GenericDocumentAttachment','related_document_id',null,'Attachments');
	
		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function attechmentImages(){
		return	$this->add('Model_GenericDocumentAttachment')->addCondition('related_document_id',$this->id);
	}

	function start_processing(){

	}

	function share_page($p){
		$vf = $p->add('Form_Stacked');
		$svf = $vf->addField('Select2','share_view_only')
			->setAttr('multiple','multiple')
			->setterGetter('group','A~12~View Only');
		$svf
			->setModel('xHR/Employee');
		
		$sef = $vf->addField('select2','share_with_edit_rights')
			->setAttr('multiple','multiple')
			->setterGetter('group','B~12~Editing Rights');
		$sef
			->setModel('xHR/Employee');

		$vf->addField('DatePicker','share_till','Share Till')
			->setterGetter('group','C~6')
			->set($this['share_till']);
		
		$vf->addSubmit("Share");

		if($vf->isSubmitted()){
			if(trim($vf['share_view_only'])){
				$sels = explode(",", $vf['share_view_only']);
				$this->add('Model_GenericDocumentShare')
					->addCondition('document_id',$this->id)
					// ->addCondition('employee_id',$epm_ids)
					->addCondition('share_mode','view-only')
					->deleteAll();
					

				foreach($sels as $epm_ids){
					$this->add('Model_GenericDocumentShare')
					->addCondition('document_id',$this->id)
					->addCondition('employee_id',$epm_ids)
					->tryLoadAny()
					->set('share_mode','view-only')
					->save();
				}
			}

			if(trim($vf['share_with_edit_rights'])){
				$sels = explode(",", $vf['share_with_edit_rights']);
				$this->add('Model_GenericDocumentShare')
					->addCondition('document_id',$this->id)
					// ->addCondition('employee_id',$epm_ids)
					->addCondition('share_mode','allow-edit')
					->deleteAll();
				
				foreach($sels as $epm_ids){
					$this->add('Model_GenericDocumentShare')
					->addCondition('document_id',$this->id)
					->addCondition('employee_id',$epm_ids)
					->tryLoadAny()
					->set('share_mode','allow-edit')
					->save();
					;	
				}
			}

			if($vf['share_till']){
				$this->set('share_till',$vf['share_till'])->save();
			}

			return true;
		}
		
		// Populate exisitng values in the field above

		$shared_with_to_view = $this->add('Model_GenericDocumentShare')
			->addCondition('share_mode','view-only')
			->addCondition('document_id',$this->id)
			->getRows();

		$ids=[];
		foreach ($shared_with_to_view as $r) {
			$ids[] = $r['employee_id'];
		}

		$svf->set(implode(",", $ids));	


		$shared_with_to_edit = $this->add('Model_GenericDocumentShare')
			->addCondition('share_mode','allow-edit')
			->addCondition('document_id',$this->id)
			->getRows();

		$ids=[];
		foreach ($shared_with_to_edit as $r) {
			$ids[] = $r['employee_id'];
		}

		$sef->set(implode(",", $ids));
		$vf->add('Controller_FormBeautifier');
	}
}