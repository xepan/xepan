<?php
namespace xHR;

class Model_Post extends \Model_Table{
	
	public $table="xhr_posts";
	
	function init(){
		parent::init();
		
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->hasOne('xHR/Department','department_id')->sortable(true)->display(array('form'=>'autocomplete/Basic'));
		
		$this->hasOne('xHR/ParentPost','parent_post_id')->sortable(true)->display(array('form'=>'autocomplete/Basic'));

		$this->addField('name')->caption('Post')->sortable(true)->sortable(true);
		$this->addField('is_active')->type('boolean')->defaultValue(true)->sortable(true);
		$this->addField('can_create_team')->type('boolean')->defaultValue(false);
		
		$this->hasMany('xHR/Post','parent_post_id');
		$this->hasMany('xHR/SalaryTemplate','post_id');
		$this->hasMany('xHR/DocumentAcl','post_id');
		$this->hasMany('xHR/Employee','post_id');
		
		$this->addHook('beforeSave',$this);
		$this->addHook('beforeDelete',$this);
		
		$this->add('Controller_Validator');
		$this->is(array(
							'name|to_trim|required',
							'parent_post_id|to_trim|required',
							)
					);
		// //$this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeSave(){
		// todo checking SKU value must be unique
		$post_old=$this->add('xHR/Model_Post');
		if($this->loaded())
			$post_old->addCondition('id','<>',$this->id);
		$post_old->tryLoadAny();

		if($post_old['name'] == $this['name'])
			throw $this->exception('Post is Allready Exist','Growl')->setField('name');
	}

	function beforeDelete(){
		$emp_count = $this->ref('xHR/Employee')->count()->getOne();
		$post_count=$this->ref('xHR/Post')->count()->getOne();
		$salary_count=$this->ref('xHR/SalaryTemplate')->count()->getOne();
		
		if($emp_count or $post_count or $salary_count){
			$this->api->js(true)->univ()->errorMessage('Cannot Delete,first delete Employees  & Salary Templates / Dependent Posts')->execute();	
		}

		$this->ref('xHR/DocumentAcl')->deleteAll();
		$this->ref('xHR/SalaryTemplate')->deleteAll();
	}
	
	function getSiblings(){
		$posts_ids= $this->add('xHR/Model_Post')->addCondition('parent_post_id',$this['parent_post_id'])->_dsql()->del('fields')->field('id')->getAll();
		return iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($posts_ids)),false);
	}

	function getDescendants($ids=null){
		if($ids==null) $ids=array($this->id);
		$posts_ids = $this->add('xHR/Model_Post')->addCondition('parent_post_id',$ids)->_dsql()->del('fields')->field('id')->getAll();
		$posts_ids = iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($posts_ids)),false);
		if(count($posts_ids))
			return array_merge($posts_ids,$this->getDescendants($posts_ids));
		else
			return count($posts_ids)?$posts_ids:array(0);
	}

	function documentAcls(){
		return $this->ref('xHR/DocumentAcl');
	}

}