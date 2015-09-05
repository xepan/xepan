<?php

class page_owner_searchdoc extends page_base_owner{
	
	function page_index(){

		$document = "Any || xShop/Customer";
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
					'id' =>'id'
				]
			],

		//xProduction
			'xProduction/Model_Jobcard'=>[
				'search_field'=>'search_string',
				'return_fields'=>[
					'name'=>'name',
					'by' =>'from_department',
					'to' =>'to_department',
					'date' =>'created_at', 
					'status' =>'status', 
					'document_model' =>'xProduction/Model_Jobcard',
					'id' =>'id'
				]
			],
			


			'xShop/Model_Customer'=>[
				'search_field'=>'search_string',
				'return_fields'=>[
					'name'=>'name',
					'by' =>'customer/supplier/employee', /*will get name in by of producer of document*/
					'to' =>'customer/supplier/employee', /*will get name in by of producer of document*/
					'date' =>'created_at', /*will get name in by of producer of document*/
					'status' =>'status', /*will get name in by of producer of document*/
					'document_model' =>'xShop/Model_Customer', /*will get name in by of producer of document*/
					'id' =>'id', /*will get name in by of producer of document*/
				]
			],



			'xShop/Model_Order'=>[
				'search_field'=>'search_string',
				'return_fields'=>[
					'name'=>'name',
					'by' =>'member', /*will get name in by of producer of document*/
					'to' =>'created_by', /*will get name in by of producer of document*/
					'date' =>'created_at', /*will get name in by of producer of document*/
					'status' =>'status', /*will get name in by of producer of document*/
					'document_model' =>'xShop/Model_Order', /*will get name in by of producer of document*/
					'id' =>'id', /*will get name in by of producer of document*/
				]
			]
		];

		$data=[];
		foreach ($structure_array as $model=>$structure) {
			if($document!='Any' && $document !=$model) continue;
				$m=$this->add($model);
				$m->addExpression('relevance')->set('(MATCH('.$structure['search_field'].') AGAINST ("'.$term.'"))');
				$m->setOrder($m->dsql()->expr('[0]',[$m->getElement('relevance')]),'DESC');
				if($document =='Any')
					$m->setLimit(5);
				else
					$m->setLimit(15);

				// $m->getRows();
				$m_data=[];
				foreach ($m as $tm) {
					$m_data['relevance'] = $m['relevance'];
					foreach ($structure['return_fields'] as $standard => $model_field) {
						$m_data[$standard] = $m[$model_field]?:$model_field;
					}
				}

				$data[] = $m_data;
		}

		usort($data, function($a,$b){
			return $a['relevance'] > $b['relevance'];
		});
		
		// Sort this $data array by its all relevance
		// take first 15 records
		// json echo ..
		// baat khatam

        echo json_encode($data);
        exit;

	}

	function page_display(){
		$this->add('View_Success')->set($_GET['key']);
	}
}