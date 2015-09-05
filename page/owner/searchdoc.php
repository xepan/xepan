<?php

class page_owner_searchdoc extends page_base_owner{
	
	function page_index(){

		$structure_array =[
		//Accounts
			'xAccount/Model_Account'=>[
				'search_field'=>'search_string',
				'return_fields'=>[
					'name'=>'name',
					'by' =>'created_by',
					'to' =>'',
					'date' =>'created_at',
					'status' =>'account_type',
					'document_model' =>'xAccount/Model_Account',
					'document' =>'Account',
					'id' =>'id',
				],
				'keyword'=>['account','ledger']
			],

			'xAccount/Model_Transaction'=>[
				'search_field'=>'search_string',
				'return_fields'=>[
					'name'=>'name',
					'by' =>'created_by',
					'to' =>'',
					'date' =>'created_at',
					'status' =>'transaction_type',
					'document_model' =>'xAccount/Model_Transaction',
					'document' =>'Voucher Number',
					'id' =>'id',
				],
				'keyword'=>['transaction','account']
			],

		//Activity
			'xCRM/Model_Activity'=>[
				'search_field'=>'search_string',
				'return_fields'=>[
					'name'=>'what',
					'by' =>'action_from',
					'to' =>'action_to',
					'date' =>'created_at',
					'status' =>'action',
					'document_model' =>'xCRM/Model_Activity',
					'document' =>'Activity',
					'id' =>'id',
				],
				'keyword'=>['activity','action','comment','call','sms','personal','draft','submitted','approved','rejected','cancelled','canceled','assigned']
			],

			'xCRM/Model_Email'=>[
				'search_field'=>'search_string',
				'return_fields'=>[
					'name'=>'subject',
					'by' =>'from_email',
					'to' =>'to_email',
					'date' =>'created_at',
					'status' =>'direction',
					'document_model' =>'xCRM/Model_Email',
					'document' =>'Email',
					'id' =>'id',
				],
				'keyword'=>['email']
			],

			'xCRM/Model_Ticket'=>[
				'search_field'=>'search_string',
				'return_fields'=>[
					'name'=>'name',
					'by' =>'from_email',
					'to' =>'to_email',
					'date' =>'created_at',
					'status' =>'subject',
					'document_model' =>'xCRM/Model_Ticket',
					'document' =>'Ticket',
					'id' =>'id',
				],
				'keyword'=>['ticket','task','support','complaints','bug']
			],

		//Dispatch
			'xDispatch/Model_DispatchRequest'=>[
				'search_field'=>'search_string',
				'return_fields'=>[
					'name'=>'name',
					'by' =>'',
					'to' =>'order_no',
					'date' =>'created_at', 
					'status' =>'status', 
					'document_model' =>'xDispatch/Model_DispatchRequest',
					'document' =>'Dispatch',
					'id' =>'id'
				],
				'keyword'=>['dispatch','delivery','complete']
			],

		//xProduction
			'xProduction/Model_JobCard'=>[
				'search_field'=>'search_string',
				'return_fields'=>[
					'name'=>'name',
					'by' =>'from_department',
					'to' =>'to_department',
					'date' =>'created_at', 
					'status' =>'status', 
					'document_model' =>'xProduction/Model_JobCard',
					'document' =>'Jobcard',
					'id' =>'id'
				],
				'keyword'=>['jobcard','job']
			],

			'xProduction/Model_Task'=>[
				'search_field'=>'search_string',
				'return_fields'=>[
					'name'=>'name',
					'by' =>'created_by',
					'to' =>'employee_id',
					'date' =>'expected_start_date',
					'status' =>'status',
					'document_model' =>'xProduction/Model_Task',
					'document' =>'Task',
					'detail' =>'subject',
					'id' =>'id'
				],
				'keyword'=>['task']
			],
		
		//Purchase
			'xPurchase/Model_PurchaseInvoice'=>[
				'search_field'=>'search_string',
				'return_fields'=>[
					'name'=>'name',
					'by' =>'created_by',
					'to' =>'supplier',
					'date' =>'created_at',
					'status' =>'status',
					'document_model' =>'xPurchase/Model_PurchaseInvoice',
					'document' =>'Purchase Invoice',
					'detail' =>'narration',
					'id' =>'id'
				],
				'keyword'=>['invoice','purchaseinvoice','p invoice','pinvoice','purchase','purchase invoice']
			],

			'xPurchase/Model_PurchaseOrder'=>[
				'search_field'=>'search_string',
				'return_fields'=>[
					'name'=>'name',
					'by' =>'created_by',
					'to' =>'supplier',
					'date' =>'created_at',
					'status' =>'status',
					'document_model' =>'xPurchase/Model_PurchaseOrder',
					'document' =>'Purchase Order',
					'detail' =>'order_summary',
					'id' =>'id'
				],
				'keyword'=>['order','purchaseorder','p order','porder','purchase']
			],

		//xShop
			'xShop/Model_Invoice'=>[
				'search_field'=>'search_string',
				'return_fields'=>[
					'name'=>'name',
					'by' =>'created_by',
					'to' =>'customer',
					'date' =>'created_at',
					'status' =>'status',
					'document_model' =>'xShop/Model_Invoice',
					'document' =>'Sale Order',
					'detail' =>'narration',
					'id' =>'id'
				],
				'keyword'=>['invoice','salesinvoice','sales invoice','sinvoice','sales','sale',]
			],

			'xShop/Model_Order'=>[
				'search_field'=>'search_string',
				'return_fields'=>[
					'name'=>'name',
					'by' =>'created_by',
					'to' =>'member',
					'date' =>'created_at',
					'status' =>'status',
					'document_model' =>'xShop/Model_Order',
					'document' =>'Sale Order',
					'detail' =>'narration',
					'id' =>'id'
				],
				'keyword'=>['order','sale order','proforma invoice']
			],
			'xShop/Model_Quotation'=>[
				'search_field'=>'search_string',
				'return_fields'=>[
					'name'=>'name',
					'by' =>'created_by',
					'to' =>'customer',
					'date' =>'created_at',
					'status' =>'status',
					'document_model' =>'xShop/Model_Quotation',
					'document' =>'Quotation',
					'detail' =>'narration',
					'id' =>'id'
				],
				'keyword'=>['quotation']
			]
		];

		$document = "Any || xShop/Customer";
		// $document = "xShop/Model_Order";
		$document = "Any";
		$term = strtolower($_GET['term']);

		// sensitize term like add + befrore order, customer etc
		if($document == 'Any'){
			foreach ($structure_array as $model=>$structure) {
				$keyword = $structure['keyword'];
				$term = preg_replace('!\s+!', ' ', $term);
				foreach ($keyword as $kw) {
					if(strpos($term, $kw.":")===0){
						if($document=='Any') $document ="";
						$document .= ($model." ");
						$term = str_replace($model.":", "", $term);
					}
				}
			}
		}

		// var_dump($document);

		$data=[];
		foreach ($structure_array as $model=>$structure) {
			if($document!='Any' && strpos($document,$model) === false){
				// echo $model." continuing <br/> " . strpos($document,$model);
				continue;	
			} 
				$m=$this->add($model);
				$m->addExpression('relevance')
					->set('(MATCH('.$structure['search_field'].') AGAINST ("'.$term.'" IN NATURAL LANGUAGE MODE))');
				$m->addCondition('relevance','>',0);

				if($m->hasElement('action'))
					$m->addCondition('action','<>',['email']);

				$m->setOrder($m->dsql()->expr('[0]',[$m->getElement('relevance')]),'DESC');
				if($document =='Any')
					$m->setLimit(5);
				else
					$m->setLimit(15);

				$fields=['relevance'];
				foreach ($structure['return_fields'] as $standard => $model_field) {
					$fields[] = $model_field;
				}


				// $m->getRows();
				foreach ($m->getRows($fields) as $tm) {
					$m_data=[];
					$m_data['relevance'] = $tm['relevance'];
					foreach ($structure['return_fields'] as $standard => $model_field) {
						$m_data[$standard] = $tm[$model_field]?:$model_field;
					}
					$data[] = $m_data;
				}

		}

		usort($data, function($a,$b){
			return $a['relevance'] < $b['relevance'];
		});
		
		// Sort this $data array by its all relevance
		// take first 15 records
		// json echo ..
		// baat khatam
		// $data= array_slice($data, 0, 15);
		
        echo json_encode($data);
        exit;

	}

	function page_display(){
		if(!$_GET['key'] and !$_GET['document_model'])
			return;
		$view_array = array(
					'xPurchase/Model_PurchaseOrder'=>array(
						'view'=>'xPurchase/View_PurchaseOrder',
						'model_variable'=>'purchaseorder'
						),
					'xShop/Model_Order'=>array(
						'view'=>'xShop/View_Order',
						'model_variable'=>'order'
						),
					'xProduction/Model_JobCard'=>array(
						'view'=>'xProduction/View_Jobcard',
						'model_variable'=>'jobcard'
						),
					'xStore/Model_StockMovement'=>array(
						'view'=>'xStore/View_StockMovement',
						'model_variable'=>'stockmovement'
						),
					'xDispatch/Model_DispatchRequest'=>array(
						'view'=>'xDispatch/View_DispatchRequest',
						'model_variable'=>'dispatchrequest'
						),
					'xShop/Model_SalesInvoice'=>array(
						'view'=>'xShop/View_SalesInvoice',
						'model_variable'=>'invoice'
						),
					'xPurchase/Model_PurchaseInvoice'=>array(
						'view'=>'xPurchase/View_PurchaseInvoice',
						'model_variable'=>'invoice'
						),
					'xCRM/Model_Email'=>[
						'view'=>'xHR/View_Email',
						'model_variable'=>'email'
						],
					'xCRM/Model_Ticket'=>[
						'view'=>'xCRM/View_Ticket',
						'model_variable'=>'model'
						],
					'xCRM/Model_Activity'=>[
						'view'=>'View_Activity',
						'model_variable'=>'activity'
						]
				);

				
		if(!$view_array[$_GET['document_model']]){			
			$this->add('View_Warning')->set('No View ('+$_GET['document_model']+') Found, Contact to Xavoc Technocrats Pvt. Ltd.');
			return;
		}

		$related_model = $this->add($_GET['document_model'])->load($_GET['key']);
		$selected_view_array = $view_array[$_GET['document_model']];
		$selected_view = $selected_view_array['view'];

		$this->add($selected_view,array($selected_view_array['model_variable']=>$related_model));
	}
}