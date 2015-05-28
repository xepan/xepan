<?php

namespace xShop;

class Model_CustomerForEmail extends Model_Customer{
	function init(){
		parent::init();

		
		$dept_id = $this->api->stickyGET('department_id');
		$dept = $this->add('xHR/Model_Department')->tryLoad($dept_id);
		$official_email_array = $dept->getOfficialEmails();

		$this->addExpression('unread')->set(function($m,$q)use($official_email_array){
			// $dept_id = $m->api->stickyGET('department_id');
			// $dept = $m->add('xHR/Model_Department')->load($dept_id);
			// $official_email_array = $dept->getOfficialEmails();

			$to_search_cond = $q->orExpr();

			foreach ($official_email_array as $oe) {
				$to_search_cond->where('cc','like','%'.$oe.'%');
			}

			$to_search_cond->where('to_email',$official_email_array);

			return $m->add('xCRM/Model_Email')
				->addCondition(
						$q->orExpr()
							->where(
									$q->andExpr()
									->where('from','Customer')
									->where('from_id',$q->getField('id'))
								)
							->where(
									$q->andExpr()
										->where('to','Customer')
										->where('to_id',$q->getField('id'))
								)
					)
				->addCondition('read_by_employee_id',null)
				->addCondition($to_search_cond)
				->count();
		});


		$this->addExpression('total_email')->set(function($m,$q)use($official_email_array){
			$to_search_cond = $q->orExpr();

			foreach ($official_email_array as $oe) {
				$to_search_cond->where('cc','like','%'.$oe.'%');
			}

			$to_search_cond->where('to_email',$official_email_array);

			return $m->add('xCRM/Model_Email')
				->addCondition(
						$q->orExpr()
							->where(
									$q->andExpr()
									->where('from','Customer')
									->where('from_id',$q->getField('id'))
								)
							->where(
									$q->andExpr()
										->where('to','Customer')
										->where('to_id',$q->getField('id'))
								)
					)
				// ->addCondition('read_by_employee_id',null)
				->addCondition($to_search_cond)
				->count();
		});

		$this->addExpression('last_email_on')->set(function($m,$q)use($official_email_array){
			$to_search_cond = $q->orExpr();

			foreach ($official_email_array as $oe) {
				$to_search_cond->where('cc','like','%'.$oe.'%');
			}

			$to_search_cond->where('to_email',$official_email_array);

			return $m->add('xCRM/Model_Email')
				->addCondition(
						$q->orExpr()
							->where(
									$q->andExpr()
									->where('from','Customer')
									->where('from_id',$q->getField('id'))
								)
							->where(
									$q->andExpr()
										->where('to','Customer')
										->where('to_id',$q->getField('id'))
								)
					)
				// ->addCondition('read_by_employee_id',null)
				->addCondition($to_search_cond)
				->setOrder('created_at','desc')
				->setLimit(1)
				->fieldQuery('created_at');
		});		
	}

}