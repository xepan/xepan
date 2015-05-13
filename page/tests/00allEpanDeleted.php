<?php

class page_tests_00allEpanDeleted extends page_tests_base {
	public $title = 'All Epans Deleted Testing';

    function prepare_allEpansDeleted(){
        $this->add('Model_Epan')->each(function($epan){
            $epan->forceDelete();
        });

        // $this->api->db->dsql()->table('epan')->truncate()->execute();
        // $this->api->db->dsql()->table('epan_page')->truncate()->execute();
        // $this->api->db->dsql()->table('epan_templates')->truncate()->execute();

        $this->proper_responses['Test_allEpansDeleted']=array(
            'epans_count'=>0,
            'general_settings'=>array('TOCHECK'),
            'epan_pages_count'=>0,
            'epan_template_count'=>0,
            'activities'=>0,
            'epan_folders'=>0,
            'users_count'=>0,
            'snapshots_count'=>0,
            'file_store_entries'=>0,
        );
    }

    function test_allEpansDeleted(){
        $q=$this->api->db->dsql();

        return array(
                'epans_count' => $q->table('epan')->field('count(*)')->getOne(),
                'general_settings' => array('TOCHECK'),
                'epan_pages_count'=>$q->table('epan_page')->field('count(*)')->getOne(),
                'epan_template_count'=>$q->table('epan_templates')->field('count(*)')->getOne(),
                'activities'=>0,
                'epan_folders'=>count(scandir(getcwd().'/epans'))-3,
                'users_count'=>$q->table('users')->field('count(*)')->getOne(),
                'snapshots_count'=>$q->table('epan_page_snapshots')->field('count(*)')->getOne(),
                'file_store_entries'=>$q->table('filestore_file')->field('count(*)')->getOne(),
            );
    }

    function prepare_allEpansDeleted_HR(){
        $this->proper_responses['Test_allEpansDeleted_HR']=array(
                'default_departments'=>0,
                'employee'=>0,
                'employee_attandance'=>0,                        
                'employee_leave'=>0,
                'employee_setup'=>'ok',
            );
    }

    function Test_allEpansDeleted_HR(){
        return array(
                'default_departments'=>$this->add('xHR/Model_Department')->count()->getOne(),
                'employee'=>$this->add('xHR/Model_Employee')->count()->getOne(),
                'employee_attandance'=>$this->add('xHR/Model_EmployeeAttendence')->count()->getOne(),                        
                'employee_leave'=>$this->add('xHR/Model_EmployeeLeave')->count()->getOne(),
                'employee_setup'=>'ok',
            );
    }

    function prepare_allEpansDeleted_SlideShows(){
        $this->proper_responses['Test_allEpansDeleted_SlideShows'] = array(
                'Awesome'=>array('Gallery'=>0,'Images'=>0),
                'ThumbnailSlider'=>array('Gallery'=>0,'Images'=>0),
                'TransformGallery'=>array('Gallery'=>0,'Images'=>0),
                'WaterWheel'=>array('Gallery'=>0,'Images'=>0)
            );
    }

    function Test_allEpansDeleted_SlideShows(){
        $awesome = $this->add('slideShows/Model_AwesomeGallery')->count()->getOne();
        $awesome_img = $this->add('slideShows/Model_AwesomeImages')->count()->getOne();
        $thumb = $this->add('slideShows/Model_ThumbnailSliderGallery')->count()->getOne();
        $thumb_img = $this->add('slideShows/Model_ThumbnailSliderImages')->count()->getOne();
        $transform = $this->add('slideShows/Model_TransformGallery')->count()->getOne();
        $transform_img = $this->add('slideShows/Model_TransformGalleryImages')->count()->getOne();
        $water = $this->add('slideShows/Model_WaterWheelGallery')->count()->getOne();
        $water_img = $this->add('slideShows/Model_WaterWheelImages')->count()->getOne();

        return array(
                'Awesome'=>array('Gallery'=>$awesome,'Images'=>$awesome_img),
                'ThumbnailSlider'=>array('Gallery'=>$thumb,'Images'=>$thumb_img),
                'TransformGallery'=>array('Gallery'=>$transform,'Images'=>$transform_img),
                'WaterWheel'=>array('Gallery'=>$water,'Images'=>$water_img)
            );
    }

    function prepare_allEpansDeleted_MarketingCampaign(){
        $this->proper_responses['Test_allEpansDeleted_MarketingCampaign'] = 
            array(
                'leads_category'=>0,
                'leads'=>0,
                'newsletter_category'=>0,
                'newsletter'=>0,
                'social_content'=>0,
                'data_grabber'=>0,
                'campaigns'=>0,
                'mass_emails_config'=>0,
                'marketing_mail_configuration'=>'ok',
                'marketing_social_configuration'=>'ok',
            );
    }

    function Test_allEpansDeleted_MarketingCampaign(){
        $q=$this->api->db->dsql();
        return array(
                'leads_category'=>$this->add('xMarketingCampaign/Model_LeadCategory')->count()->getOne(),
                'leads'=>$this->add('xMarketingCampaign/Model_Lead')->count()->getOne(),
                'newsletter_category'=>$this->add('xEnquiryNSubscription/Model_NewsLetterCategory')->count()->getOne(),
                'newsletter'=>$this->add('xEnquiryNSubscription/Model_NewsLetter')->count()->getOne(),
                'social_content'=>$this->add('xMarketingCampaign/Model_SocialPost')->count()->getOne(),
                'data_grabber'=>$this->add('xMarketingCampaign/Model_DataGrabber')->count()->getOne(),
                'campaigns'=>$this->add('xMarketingCampaign/Model_Campaign')->count()->getOne(),
                'mass_emails_config'=>$q->table('xmarketingcampaign_config')->field('count(*)')->getOne(),
                'marketing_mail_configuration'=>'ok',
                'marketing_social_configuration'=>'ok',
            );
    }

    function prepare_allEpansDeleted_xAccount(){
        $this->proper_responses['Test_allEpansDeleted_xAccount'] = array(
                'accounts'=>0,
                'balance_sheet'=>0,
                'group'=>0,
                'transactions'=>0,
                'ledgers'=>0,
                'transaction_type'=>0,
            );

    }

    function Test_allEpansDeleted_xAccount(){
        return array(
                'accounts'=>$this->add('xAccount/Model_Account')->count()->getOne(),
                'balance_sheet'=>$this->add('xAccount/Model_BalanceSheet')->count()->getOne(),
                'group'=>$this->add('xAccount/Model_Group')->count()->getOne(),
                'transactions'=>$this->add('xAccount/Model_Transaction')->count()->getOne(),
                'ledgers'=>$this->add('xAccount/Model_Account')->count()->getOne(),
                'transaction_type'=>$this->add('xAccount/Model_TransactionType')->count()->getOne(),
            );
    }

    function prepare_allEpansDeleted_xCRM(){
        $this->proper_responses['Test_allEpansDeleted_xCRM'] = array(
                'support_ticket'=>0,
                'department_official_emails'=>0,
                'emails'=>0,
                'smses'=>0,
                'document_activities'=>0,
                'last_seen_record_count'=>0,
            );

    }

    function Test_allEpansDeleted_xCRM(){
        $q=$this->api->db->dsql();
        return array(
                'support_ticket'=>$this->add('xCRM/Model_Ticket')->count()->getOne(),
                'department_official_emails'=>$this->add('xHR/Model_OfficialEmail')->count()->getOne(),
                'emails'=>$this->add('xCRM/Model_Email')->count()->getOne(),
                'smses'=>$this->add('xCRM/Model_SMS')->count()->getOne(),
                'document_activities'=>$this->add('xCRM/Model_Activity')->count()->getOne(),
                'last_seen_record_count'=>$q->table('last_seen_updates')->field('count(*)')->getOne(),
            );
    }

    function prepare_allEpansDeleted_xDispatch(){
        $this->proper_responses['Test_allEpansDeleted_xDispatch'] = array(
                'dispatch_requests'=>0,
                'dispatch_requests_item'=>0,
                'delivery_notes'=>0,
                'delivery_note_item'=>0,
            );

    }

    function Test_allEpansDeleted_xDispatch(){
        return array(
                'dispatch_requests'=>$this->add('xDispatch/Model_DispatchRequest')->count()->getOne(),
                'dispatch_requests_item'=>$this->add('xDispatch/Model_DispatchRequestItem')->count()->getOne(),
                'delivery_notes'=>$this->add('xDispatch/Model_DeliveryNote')->count()->getOne(),
                'delivery_note_item'=>$this->add('xDispatch/Model_DeliveryNoteItem')->count()->getOne(),
            );
    }

    function prepare_allEpansDeleted_xEnquiryNSubscription(){
        $this->proper_responses['Test_allEpansDeleted_xEnquiryNSubscription'] = array(
                'Custom_Forms'=>0,        
                'Custom_Fields'=>0,
                'Custom_Form_Entry'=>0,
                'Email_Jobs'=>0,
                'Email_Queue'=>0,
                'Host_Touched'=>0,
                'Mass_Email_Configuration'=>0,
                'NewsLetter_Category'=>0,
                'NewsLetter'=>0,
                'Subscription_Category'=>0,
                'Subscription'=>0,
                'Subscription_Category_Association'=>0,
                'Subscription_Config'=>0,
            );

    }

    function Test_allEpansDeleted_xEnquiryNSubscription(){
        return array(
                'Custom_Forms'=>$this->add('xEnquiryNSubscription/Model_Forms')->count()->getOne(),
                'Custom_Fields'=>$this->add('xEnquiryNSubscription/Model_CustomFields')->count()->getOne(),
                'Custom_Form_Entry'=>$this->add('xEnquiryNSubscription/Model_CustomFormEntry')->count()->getOne(),
                'Email_Jobs'=>$this->add('xEnquiryNSubscription/Model_EmailJobs')->count()->getOne(),
                'Email_Queue'=>$this->add('xEnquiryNSubscription/Model_EmailQueue')->count()->getOne(),
                'Host_Touched'=>$this->add('xEnquiryNSubscription/Model_HostsTouched')->count()->getOne(),
                'Mass_Email_Configuration'=>$this->add('xEnquiryNSubscription/Model_MassEmailConfiguration')->count()->getOne(),
                'NewsLetter_Category'=>$this->add('xEnquiryNSubscription/Model_NewsLetterCategory')->count()->getOne(),
                'NewsLetter'=>$this->add('xEnquiryNSubscription/Model_NewsLetter')->count()->getOne(),
                'Subscription_Category'=>$this->add('xEnquiryNSubscription/Model_SubscriptionCategories')->count()->getOne(),
                'Subscription'=>$this->add('xEnquiryNSubscription/Model_Subscription')->count()->getOne(),
                'Subscription_Category_Association'=>$this->add('xEnquiryNSubscription/Model_SubscriptionCategoryAssociation')->count()->getOne(),
                'Subscription_Config'=>$this->add('xEnquiryNSubscription/Model_SubscriptionConfig')->count()->getOne(),
            );
    }

    function prepare_allEpansDeleted_xImageGallery(){
        $this->proper_responses['Test_allEpansDeleted_xImageGallery'] = array(
                'gallery'=>0,
                'Images'=>0
            );

    }

    function Test_allEpansDeleted_xImageGallery(){
        $gallery = $this->add('xImageGallery/Model_Gallery')->count()->getOne();
        $images = $this->add('xImageGallery/Model_Images')->count()->getOne();
        return array(
                'gallery'=>$gallery,
                'Images'=>$images,
            );
    }

    function prepare_allEpansDeleted_xProduction(){
        $this->proper_responses['Test_allEpansDeleted_xProduction'] = array(
                'outsource_parties'=>0,
            'outsource_parties_department_association'=>0,
            'production_phases'=>0,
            'job_cards'=>0,
            'task'=>0,
            'team'=>0,
            'employee_team_association'=>0,
            );

    }

    function Test_allEpansDeleted_xProduction(){
        return array(
                'outsource_parties'=>$this->add('xProduction/Model_OutSourceParty')->count()->getOne(),
                'outsource_parties_department_association'=>$this->add('xProduction/Model_OutSourcePartyDeptAssociation')->count()->getOne(),
                'production_phases'=>$this->add('xProduction/Model_Phase')->addCondition('id','>',9)->count()->getOne(),
                'job_cards'=>$this->add('xProduction/Model_JobCard')->count()->getOne(),
                'task'=>$this->add('xProduction/Model_Task')->count()->getOne(),
                'team'=>$this->add('xProduction/Model_Team')->count()->getOne(),
                'employee_team_association'=>$this->add('xProduction/Model_EmployeeTeamAssociation')->count()->getOne(),
            );
    }

    function prepare_allEpansDeleted_xPurchase(){
        $this->proper_responses['Test_allEpansDeleted_xPurchase'] = array(
            'purchase_invoice'=>0,
            'purchase_invoice_item'=>0,
            'purchase_order'=>0,
            'purchase_order_item'=>0,
            'suppliers'=>0,
            );

    }

    function Test_allEpansDeleted_xPurchase(){
        return array(
                'purchase_invoice'=>$this->add('xPurchase/Model_PurchaseInvoice')->count()->getOne(),
                'purchase_invoice_item'=>$this->add('xShop/Model_InvoiceItem')->count()->getOne(),
                'purchase_order'=>$this->add('xPurchase/Model_PurchaseOrder')->count()->getOne(),
                'purchase_order_item'=>$this->add('xPurchase/Model_PurchaseOrderItem')->count()->getOne(),
                'suppliers'=>$this->add('xPurchase/Model_Supplier')->count()->getOne(),
            );
    }

    function prepare_allEpansDeleted_xShop(){
        $this->proper_responses['Test_allEpansDeleted_xShop'] = array(
            'opportunity'=>0,
            'quotations'=>0,
            'items_category'=>0,
            'items'=>0,
            'affiliate_type'=>0,
            'affiliate'=>0,
            'discount_vouchers'=>0,
            'discount_vouchers_used'=>0,
            'customers'=>0,
            'sales_orders'=>0,
            'sales_invoices'=>0,
            'sales_invoices_item'=>0,
            'payment_gateway_config'=>0,
            'term_and_condition'=>0,
            'xshop_custom_fields'=>0,
            'xshop_custom_field_value'=>0,
            'xshop_custom_field_association'=>0,
            'xshop_custom_field_filter_association'=>0,
            'xshop_custom_rate_condition'=>0,
            'specification'=>0,
            'specification_association'=>0,
            'item_offers'=>0,
            'xshop_configuration'=>0,
            );

    }

    function Test_allEpansDeleted_xShop(){
        return array(
                'opportunity'=>$this->add('xShop/Model_Opportunity')->count()->getOne(),
                'quotations'=>$this->add('xShop/Model_Quotation')->count()->getOne(),
                'items_category'=>$this->add('xShop/Model_Category')->count()->getOne(),
                'items'=>$this->add('xShop/Model_Item')->count()->getOne(),
                'affiliate_type'=>$this->add('xShop/Model_AffiliateType')->count()->getOne(),
                'affiliate'=>$this->add('xShop/Model_Affiliate')->count()->getOne(),
                'discount_vouchers'=>$this->add('xShop/Model_DiscountVoucher')->count()->getOne(),
                'discount_vouchers_used'=>$this->add('xShop/Model_DiscountVoucherUsed')->count()->getOne(),
                'customers'=>$this->add('xShop/Model_Customer')->count()->getOne(),
                'sales_orders'=>$this->add('xShop/Model_Order')->count()->getOne(),
                'sales_invoices'=>$this->add('xShop/Model_SalesInvoice')->count()->getOne(),
                'sales_invoices_item'=>$this->add('xShop/Model_InvoiceItem')->count()->getOne(),
                'payment_gateway_config'=>$this->add('xShop/Model_PaymentGateway')->count()->getOne(),
                'term_and_condition'=>$this->add('xShop/Model_TermsAndCondition')->count()->getOne(),
                'xshop_custom_fields'=>$this->add('xShop/Model_CustomFields')->count()->getOne(),
                'xshop_custom_field_value'=>$this->add('xShop/Model_CustomFieldValue')->count()->getOne(),
                'xshop_custom_field_association'=>$this->add('xShop/Model_ItemCustomFieldAssos')->count()->getOne(),
                'xshop_custom_field_filter_association'=>$this->add('xShop/Model_CustomFieldValueFilterAssociation')->count()->getOne(),
                'xshop_custom_rate_condition'=>$this->add('xShop/Model_CustomRateCustomeValueCondition')->count()->getOne(),
                'specification'=>$this->add('xShop/Model_Specification')->count()->getOne(),
                'specification_association'=>$this->add('xShop/Model_ItemSpecificationAssociation')->count()->getOne(),
                'item_offers'=>$this->add('xShop/Model_ItemOffer')->count()->getOne(),
                'xshop_configuration'=>$this->add('xShop/Model_Configuration')->count()->getOne(),
            );
    }

    function prepare_allEpansDeleted_xStore(){
        $this->proper_responses['Test_allEpansDeleted_xStore'] = array(
                'warehouses'=>0,
                'stocks'=>0,

                'material_requests'=>0,
                'material_request_items'=>0,
            );

    }

    function Test_allEpansDeleted_xStore(){
        return array(
                'warehouses'=>$this->add('xStore/Model_Warehouse')->count()->getOne(),
                'stocks'=>$this->add('xStore/Model_Stock')->count()->getOne(),

                'material_requests'=>$this->add('xStore/Model_MaterialRequest')->count()->getOne(),
                'material_request_items'=>$this->add('xStore/Model_MaterialRequestItem')->count()->getOne(),
                
            );
    }

    
}