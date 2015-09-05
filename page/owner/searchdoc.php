<?php

class page_owner_searchdoc extends page_base_owner{
	
	function page_index(){

		$document = "Any || xShop/Customer";
		$document = "Any";
		$term = $_GET['term'];

		// sensitize term like add + befrore order, customer etc

		$structure_array =[
			// 'xShop/Model_Customer'=>[
			// 	'search_field'=>'search_string',
			// 	'return_fields'=>[
			// 		'name'=>'name',
			// 		'by' =>'customer/supplier/employee', /*will get name in by of producer of document*/
			// 		'to' =>'customer/supplier/employee', /*will get name in by of producer of document*/
			// 		'date' =>'created_at', /*will get name in by of producer of document*/
			// 		'status' =>'status', /*will get name in by of producer of document*/
			// 		'document_model' =>'xShop/Model_Customer', /*will get name in by of producer of document*/
			// 		'id' =>'id', /*will get name in by of producer of document*/
			// 	]
			// ],
			'xShop/Model_Order'=>[
				'search_field'=>'search_string',
				'return_fields'=>[
					'name'=>'member',
					'by' =>'member', /*will get name in by of producer of document*/
					'to' =>'employee', /*will get name in by of producer of document*/
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
						$m_data[$standard] = $m[$model_field];
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