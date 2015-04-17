<?php

class page_owner_activitydocument extends page_base_owner{
	
	function page_index(){
		parent::init();

		$view_array = array(
						'xPurchase\PurchaseOrder'=>array(
							'view'=>'xPurchase\View_PurchaseOrder',
							'model'=>'xPurchase\Model_PurchaseOrder',
							'model_variable'=>'purchaseorder'
							),
						'xShop\Order'=>array(
							'view'=>'xShop\View_Order',
							'model'=>'xShop\Model_Order',
							'model_variable'=>'order'
							),
						'xProduction\JobCard'=>array(
							'view'=>'xProduction\View_Jobcard',
							'model'=>'xProduction\Model_JobCard',
							'model_variable'=>'jobcard'
							),
						'xStore\StockMovement'=>array(
							'view'=>'xStore\View_StockMovement',
							'model'=>'xStore\Model_StockMovement',
							'model_variable'=>'stockmovement'
							),
						'xDispatch\DispatchRequest'=>array(
							'view'=>'xDispatch\View_DispatchRequest',
							'model'=>'xDispatch\Model_DispatchRequest',
							'model_variable'=>'dispatchrequest'
							),
						'xShop\SalesInvoice'=>array(
							'view'=>'xShop\View_SalesInvoice',
							'model'=>'xShop\Model_SalesInvoice',
							'model_variable'=>'invoice'
							),
						'xPurchase\PurchaseInvoice'=>array(
							'view'=>'xPurchase\View_PurchaseInvoice',
							'model'=>'xPurchase\Model_PurchaseInvoice',
							'model_variable'=>'invoice'
							)
					);

		if($_GET['activity_id']){
			
			$activity = $this->add('xCRM/Model_Activity')->load($_GET['activity_id']);
			
			if(!$view_array[$activity['related_root_document_name']]){
				$this->add('View_Warning')->set('No View Found, Contact to Xavoc Technocrats');
				return;
			}

			$selected_view_array = $view_array[$activity['related_root_document_name']];
			$selected_view = $selected_view_array['view'];
			$selected_model = $selected_view_array['model'];
			$this->add($selected_view,array($selected_view_array['model_variable']=>$this->add($selected_model)->load($activity['related_document_id'])));
			// $this->add();

		}

		
	}
}