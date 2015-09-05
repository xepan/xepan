<?php

class page_owner_searchdoc extends page_base_owner{
	
	function page_index(){

		$document = "Any || xShop/Customer";
		$document = "xShop/Model_Order";
		$document = "Any";
		$term = $_GET['term'];

		// sensitize term like add + befrore order, customer etc

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
				]
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
				]
			],

		//Activity
			'xCRM/Model_Activity'=>[
				'search_field'=>'search_string',
				'return_fields'=>[
					'name'=>'subject',
					'by' =>'action_from',
					'to' =>'action_to',
					'date' =>'created_at',
					'status' =>'action',
					'document_model' =>'xCRM/Model_Activity',
					'document' =>'Activity',
					'id' =>'id',
				]
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
				]
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
				]
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
				]
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
				]
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
				]
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
				]
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
				]
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
				]
			],

			'xShop/Model_Order'=>[
				'search_field'=>'search_string',
				'return_fields'=>[
					'name'=>'name',
					'by' =>'created_by',
					'to' =>'customer',
					'date' =>'created_at',
					'status' =>'status',
					'document_model' =>'xShop/Model_Order',
					'document' =>'Sale Order',
					'detail' =>'narration',
					'id' =>'id'
				]
			]
		];

		$data=[];
		foreach ($structure_array as $model=>$structure) {
			if($document!='Any' && $document !=$model) continue;
				$m=$this->add($model);
				$m->addExpression('relevance')
					->set('(MATCH('.$structure['search_field'].') AGAINST ("'.$term.'" IN NATURAL LANGUAGE MODE))');
				$m->addCondition('relevance','>',0);

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
		$this->add('View_Success')->set($_GET['key']);
	}
}