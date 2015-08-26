<?php

class CRUD extends View_CRUD{
	public $form_class='Form_Stacked';
	public $add_form_beautifier = true;
	public $keep_open_on_submit= false;

	function setModel($model,$f=null,$f2=null){
		parent::setModel($model,$f,$f2);
		if($this->add_form_beautifier)
			$this->add('Controller_FormBeautifier');
	}

	function formSubmit($form){
		try {
			$hook_value = $this->hook('crud_form_submit',array($form));
			if($hook_value[0]){
	            $self = $this;
	            $this->api->addHook('pre-render', function () use ($self) {
	                $self->formSubmitSuccess()->execute();
	            });
				return parent::formSubmit($form);
				// return;	
			}else{
				return parent::formSubmit($form);
			}
        } catch (Exception_ValidityCheck $e) {
            $form->displayError($e->getField(), $e->getMessage());
        }
		return false;		
	}

	public function formSubmitSuccess()
    {
    	$close_js=null;

        if(!$this->keep_open_on_submit){
	        $close_js=$this->form->js()->univ()->closeDialog();
        }

        $js=$this->js(null,array($close_js, $this->form->js()->univ()->successMessage("Saved")))->trigger('reload');
        return $js;
    }

	function manageAction($action_name,$icon='target'){
		if(!$this->model)
			throw $this->exception('Must be called after setModel');

		$title = explode("_", $action_name);
		for($i=0;$i<count($title);$i++){
			if(in_array($title[$i],array('manage','see'))){
				unset($title[$i]);
			}
		}

		$title = implode(" ", $title);

		if($this->model->hasMethod($action_name.'_page')){
			$action_page_function = $action_name.'_page';
			if($this->isEditing($title)){
				$this->model->tryLoad($this->id);
				if($this->model->loaded()){
					try{
						$p=$this->virtual_page->getPage();
						$this->api->db->beginTransaction();
							$function_run = $this->model->$action_page_function($p);
						$this->api->db->commit();
						if($function_run ){
							$js=array();
							$js[] = $p->js()->univ()->closeDialog();
							$js[] = $this->js()->reload([$p->short_name=>'',$p->short_name.'_id'=>'']);
							$this->js(null,$js)->execute();
						}
					}
					catch(\Exception_StopInit $e){
						$this->api->db->commit();
						throw $e;
					}catch(\Exception $e){
						$this->api->db->rollback();
						if($this->api->getConfig('developer_mode',false)){
							throw $e;
						}else{
							$this->owner->js()->univ()->errorMessage($e->getMessage())->execute();
						}
					}
				}
			}elseif(!$this->isEditing()){
				$p = $this
		                ->virtual_page
		                ->addColumn($title, $title,  array('descr'=>$title,'icon'=>$icon), $this->grid);
			}
		}elseif($this->model->hasMethod($action_name)){
			try{
				$this->api->db->beginTransaction();
					$this->addAction($action_name,array('toolbar'=>false,'icon'=>$icon));		
				$this->api->db->commit();
			}
			catch(\Exception_StopInit $e){
					$this->api->db->commit();
					throw $e;
			}catch(\Exception $e){
				$this->api->db->rollback();
					throw $e;
				if($this->api->getConfig('developer_mode',false)){
					$this->owner->js()->univ()->errorMessage($e->getMessage())->execute();
				}else{
					throw $e;
				}
			}
		}
	}
}