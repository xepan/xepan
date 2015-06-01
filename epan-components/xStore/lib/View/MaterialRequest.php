<?php
namespace xStore;
class View_MaterialRequest extends \CompleteLister{
	
	public $materialrequest;
	public $sno=1;
	
	function init(){
		parent::init();

		$sale_order = $this->materialrequest->ref('orderitem_id')->order();
		$self = $this;
		$this->vp = $this->add('VirtualPage')->set(function($p)use($self){
			$o = $p->add('xShop/Model_Order')->load($self->api->stickyGET('sales_order_clicked'));
			$order = $p->add('xShop/View_Order',array('show_price'=>false));
			$order->setModel($o);
		});

		// $this->add('View_Info')->set('Material Request Details Here');
		$this->template->setHtml('request_on',"Request On: <b>".$this->materialrequest['created_at']."</b>");
		$this->template->setHtml('status',"Status: <b>".ucwords($this->materialrequest['status'])."</b>");
		$this->template->setHtml('form_dept',"From Department: <b>".$this->materialrequest['from_department']."</b>");
		$this->template->setHtml('to_dept',"To Department: <b>".$this->materialrequest['to_department']."</b>");
		$this->template->setHtml('name',"Job Number: <b>".$this->materialrequest['name']."</b>");
		$this->template->setHtml('order',"Order Number: <b>".'<a href="#void" onclick="javascript:'.$this->js()->univ()->frameURL('Sale Order', $this->api->url($this->vp->getURL(),array('sales_order_clicked'=>$sale_order['id']))).'">'. $sale_order['name'] ."</a>");
		
		$this->setModel($this->materialrequest->itemrows());
	}

	function formatRow(){
		$this->current_row['sno']=$this->sno;
		$this->current_row_html['custom_field'] =  $this->add('xShop/Model_Item')->genericRedableCustomFieldAndValue($this->model['custom_fields']);
		$this->current_row['unit']=$this->model['unit'];
		$this->sno++;
	}

	function defaultTemplate(){
		$this->app->pathfinder->base_location->addRelativeLocation(
		    'epan-components/'.__NAMESPACE__, array(
		        'php'=>'lib',
		        'template'=>'templates',
		        'css'=>'templates/css',
		        'js'=>'templates/js',
		    )
		);
		return array('view/xStore-materialrequest');
	}
}