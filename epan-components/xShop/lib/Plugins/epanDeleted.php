<?php

namespace xShop;


class Plugins_epanDeleted extends \componentBase\Plugin {

	function init(){
		parent::init();
		$this->addHook('epan_before_delete',array($this,'Plugins_epanDeleted'));
	}

	function Plugins_epanDeleted($obj, $epan){		
		$models=array('Model_Opportunity',
						'Model_Application',
						'Model_Configuration',
						'Model_AddBlock',
						'Model_Affiliate',
						'Model_Category',
						'Model_CategoryItem',
						'Model_CustomRate',
						'Model_DiscountVoucher',
						'Model_SalesInvoice',
						'Model_Item',
						'Model_ItemComposition',
						'Model_ItemEnquiry',
						'Model_ItemImages',
						'Model_ItemMemberDesign',
						'Model_ItemOffer',
						'Model_ItemReview',
						'Model_MemberDetails',
						'Model_MemberImages',
						'Model_Order',
						'Model_PaymentGateway',
						'Model_Priority',
						'Model_QuantitySet',
						'Model_Quotation',
						'Model_Specification',
						'Model_Tax',
						'Model_TermsAndCondition',
					);
		
		foreach ($models as $m) {
			$this->add("xShop\\".$m)->each(function($model){
				$model->forceDelete();
			});
		}

	}
}
