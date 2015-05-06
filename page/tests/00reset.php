<?php

class page_tests_00reset extends Page_Tester {
	public $title = 'BASE ERP Testing';
    public $proper_responses=array(
        "Test_reset"=>array(
                        'default_departments'=>9,
                        'employee'=>0,
                        'employee_attandance'=>0,                        
                        'employee_leave'=>0,
                        'employee_setup'=>'ok',
                        
                        'leads_category'=>0,
                        'leads'=>0,
                        'newsletter_category',
                        'newsletter'=>0,
                        'social_content'=>0,
                        'data_grabber'=>0,
                        'campaigns'=>0,
                        'marketing_mail_configuration'=>'ok',
                        'marketing_social_configuration'=>'ok',

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
                        'xshop_configuration'=>1,

                        'outsource_parties'=>0,
                        'outsource_parties_department_association'=>0,
                        'production_phases'=>0,
                        'job_cards'=>0,
                        'task'=>0,
                        'team'=>0,
                        'employee_team_association'=>0,

                        'support_ticket'=>0,
                        'company_emails'=>0,
                        'emails'=>0,
                        'smses'=>0,
                        'document_activities'=>0,

                        'accounts'=>0,
                        'balance_sheet'=>10,
                        'group'=>7,
                        'transactions'=>0,
                        'ledgers'=>0,
                        'transaction_type'=>8,
                        
                        'purchase_invoice'=>0,
                        'purchase_invoice_item'=>0,
                        'purchase_order'=>0,
                        'purchase_order_item'=>0,
                        'suppliers'=>0,
                        
                        'dispatch_requests'=>0,
                        'dispatch_requests_item'=>0,
                        'delivery_notes'=>0,
                        'delivery_note_item'=>0,
                        
                        'warehouses'=>0,
                        'stocks'=>0,

                        'material_requests'=>0,
                        'material_request_items'=>0,
                        
                        'activities'=>0
                ),
    );

    function prepare_epanReset(){
        $this->add('Model_Epan')->each(function($epan){
            $epan->delete();
        });

        $this->api->db->dsql()->table('epan')->truncate()->execute();
        $this->api->db->dsql()->table('epan_page')->truncate()->execute();
        $this->api->db->dsql()->table('epan_templates')->truncate()->execute();

        $this->add('Model_Epan')
            ->set('name','web')
            ->set('email_id','email@example.com')
            ->set('password','xepan')
            ->set('branch_id',$this->add('Model_Branch')->tryLoadAny()->get('id'))
            ->save();

        $this->proper_responses['Test_epanReset']=array(
            'epans_count'=>1,
            'general_settings'=>array('TOCHECK'),
            'epan_pages_count'=>1,
            'epan_template_count'=>1,
            'epan_template_values'=>array('name'=>'default','content'=>'<div component_namespace="baseElements" component_type="TemplateContentRegion" class="epan-sortable-component epan-component  ui-sortable" style="" contenteditable="false">~~Content~~</div>','body_attributes'=>'','is_current'=>1,'css'=>''),
            'epan_values'=>array('name'=>'web','epan_id'=>1),
            'epan_defaultpage_values'=>array('name'=>'home','epan_id'=>1,'content'=>0,'body_attributes'=>'','template_id'=>1)
        );
    }

    function test_epanReset(){
        $epan = $this->add('Model_Epan')->tryLoadAny();
        $template = $epan->templates()->tryLoadAny();
        $page = $epan->pages()->tryLoadAny();

        return array(
                'epans_count' => $this->add('Model_Epan')->count()->getOne(),
                'general_settings' => array('TOCHECK'),
                'epan_pages_count'=>$epan->pages()->count()->getOne(),
                'epan_template_count'=>$epan->templates()->count()->getOne(),
                'epan_template_values'=>array('name'=>$template['name'],'content'=>$template['content'],'body_attributes'=>$template['body_attributes'],'is_current'=>$template['is_current'],'css'=>$template['css']),
                'epan_values'=>array('name'=>$epan['name'],'epan_id'=>$epan->id),
                'epan_defaultpage_values'=>array('name'=>$page['name'],'epan_id'=>$page['epan_id'],'content'=>$page['content'],'body_attributes'=>$page['body_attributes'],'template_id'=>$page['template_id'])
            );
    }

    function prepare_usersReset(){
        $this->add('Model_Users')->each(function($user){
            if(!$user->isDefaultSuperUser()) {
                    $user->delete();
                }
        });
        $this->proper_responses['Test_usersReset']=array(
                'users_count'=>1,
                'user_type'=>100,
                'user_active'=>1,
                'user_permissions'=>array('user_management'=>1,'general_settings'=>1,'application_management'=>1,'website_designing'=>1),
                'user_app_access'=>$this->add('Model_MarketPlace')->count()->getOne() - 1, //  leaving baseElements
            );

    }

    function test_usersReset(){
        $user = $this->add('Model_Users')->tryLoadAny();

        return array(
                'users_count' => $user->count()->getOne(),
                'user_type'=>$user['type'],
                'user_active'=>$user['is_active'],
                'user_permissions'=>array('user_management'=>$user->isUserManagementAllowed(),
                                         'general_settings'=>$user->isGeneralSettingsAllowed(),
                                         'application_management'=>$user->isApplicationManagementAllowed(),
                                         'website_designing'=>$user->isWebDesigningAllowed()
                                         ),
                'user_app_access'=> $user->ref('UserAppAccess')->count()->getOne(),
            );
    }


    // function prepare_reset(){
    //     $this->add('Model_Users')->addCondition('id','<>','1')->delete();
    //     $this->api->db->dsql()->table('users')->where('id','<>','1')->delete()->execute();
    //     $this->api->db->dsql()->table('user_custom_fields')->delete()->execute();
    //     //Todo general settings
    //     //TODO Employee Setup
        
    //     $this->api->db->dsql()->table('xmarketingcampaign_lead_categories')->delete()->execute();
    //     $this->api->db->dsql()->table('xenquirynsubscription_subscription')->delete()->execute();
    //     $this->api->db->dsql()->table('xenquirynsubscription_newslettercategory')->delete()->execute();
    //     $this->api->db->dsql()->table('xenquirynsubscription_newsletter')->delete()->execute();
    //     $this->api->db->dsql()->table('xmarketingcampaign_socialpost_categories')->delete()->execute();
    //     $this->api->db->dsql()->table('xmarketingcampaign_socialposts')->delete()->execute();
    //     $this->api->db->dsql()->table('xmarketingcampaign_data_grabber')->delete()->execute();
    //     $this->api->db->dsql()->table('xmarketingcampaign_campaigns')->delete()->execute();
    //     $this->api->db->dsql()->table('xenquirynsubscription_massemailconfiguration')->delete()->execute();
    //     $this->api->db->dsql()->table('xmarketingcampaign_socialconfig')->delete()->execute();

             
    //     $this->api->db->dsql()->table('xshop_opportunity')->delete()->execute();
    //     $this->api->db->dsql()->table('xshop_quotation')->delete()->execute();
    //     $this->api->db->dsql()->table('xshop_categories')->delete()->execute();
    //     $this->api->db->dsql()->table('xshop_affiliate')->delete()->execute();
    //     $this->api->db->dsql()->table('xshop_affiliatetype')->delete()->execute();
    //     $this->api->db->dsql()->table('xshop_discount_vouchers')->delete()->execute();
    //     $this->api->db->dsql()->table('xshop_discount_vouchers_used')->delete()->execute();
    //     // $this->api->db->dsql()->table('xshop_memberdetails')->where('type','50')->delete()->execute();
    //     $this->api->db->dsql()->table('xshop_payment_gateways')->delete()->execute();
    //     $this->api->db->dsql()->table('xshop_custom_fields')->delete()->execute();
    //     $this->api->db->dsql()->table('xshop_custom_fields_value')->delete()->execute();
    //     $this->api->db->dsql()->table('xshop_item_customfields_assos')->delete()->execute();
    //     $this->api->db->dsql()->table('xshop_customfiledvalue_filter_ass')->delete()->execute();
    //     $this->api->db->dsql()->table('xshop_customrate_custome_value_conditions')->delete()->execute();
    //     $this->api->db->dsql()->table('xshop_specifications')->delete()->execute();
    //     $this->api->db->dsql()->table('xshop_item_spec_ass')->delete()->execute();
    //     $this->api->db->dsql()->table('xshop_itemoffers')->delete()->execute();
    //     $this->api->db->dsql()->table('xshop_configuration')->where('id','<>','1')->delete()->execute();
        
    //     $this->api->db->dsql()->table('xproduction_out_source_parties')->delete()->execute();
    //     $this->api->db->dsql()->table('xproduction_tasks')->delete()->execute();
    //     $this->api->db->dsql()->table('xproduction_teams')->delete()->execute();
        
    //     $this->api->db->dsql()->table('xcrm_tickets')->delete()->execute();
    //     $this->api->db->dsql()->table('xhr_official_emails')->delete()->execute();
    //     $this->api->db->dsql()->table('xcrm_emails')->delete()->execute();
    //     $this->api->db->dsql()->table('xcrm_document_activities')->delete()->execute();
    //     $this->api->db->dsql()->table('xcrm_smses')->delete()->execute();
        
    //     $this->api->db->dsql()->table('xaccount_balance_sheet')->where('name','<>',array(
    //                                                         'Deposits - Liabilities',
    //                                                         'Current Assets',
    //                                                         'Capital Account',
    //                                                         'Expenses',
    //                                                         'Income',
    //                                                         'Suspence Account',
    //                                                         'Fixed Assets',
    //                                                         'Branch/Divisions',
    //                                                         'Current Liabilities',
    //                                                         'Duties & Taxes'
    //                                                         ))->delete()->execute();
        
    //     $this->api->db->dsql()->table('xaccount_group')->where('name','<>',array(
    //                                             'Duties & Taxes',
    //                                             'Sundry Creditor',
    //                                             'Bank Accounts',
    //                                             'Direct Expenses',
    //                                             'Sundry Debtor',
    //                                             'Cash Account',
    //                                             'Direct Income'
    //                                             ))->delete()->execute();

    //     $this->api->db->dsql()->table('xaccount_transaction')->delete()->execute();
    //     $this->api->db->dsql()->table('xaccount_transaction_row')->delete()->execute();
    //     $this->api->db->dsql()->table('xaccount_transaction_types')->where('name','<>',array(
    //                                         'PURCHASE ORDER ADVANCE BANK PAYMENT GIVEN',
    //                                         'PURCHASE INVOICE',
    //                                         'ORDER ADVANCE CASH PAYMENT RECEIVED',
    //                                         'SALES INVOICE',
    //                                         'INVOICE CASH PAYMENT RECEIVED',
    //                                         'PURCHASE ORDER ADVANCE CASH PAYMENT GIVEN',
    //                                         'PURCHASE INVOICE CASH PAYMENT',
    //                                         'PURCHASE INVOICE BANK PAYMENT'
    //                                         ))->delete()->execute();

        
    //     $this->api->db->dsql()->table('xpurchase_supplier')->delete()->execute();

    //     $this->api->db->dsql()->table('xdispatch_delivery_note_items')->delete()->execute();
    //     $this->api->db->dsql()->table('xdispatch_delivery_note')->delete()->execute();
    //     $this->api->db->dsql()->table('xdispatch_dispatch_request')->delete()->execute();
        
    //     $this->api->db->dsql()->table('xstore_warehouse')->delete()->execute();
    //     $this->api->db->dsql()->table('xstore_stock')->delete()->execute();
    //     $this->api->db->dsql()->table('xstore_material_request_items')->delete()->execute();
    //     $this->api->db->dsql()->table('xstore_stock_movement_master')->delete()->execute();

        
    //     $this->api->db->dsql()->table('xproduction_jobcard')->delete()->execute();
    //     $this->api->db->dsql()->table('xhr_departments')->where('id',"<>",array('1','2','3','4','5','6','7','8','9'))->delete()->execute();
    //     $this->api->db->dsql()->table('xshop_taxs')->delete()->execute();
    //     $this->api->db->dsql()->table('xshop_itemtaxasso')->delete()->execute();
    //     // $this->api->db->dsql()->table('xshop_invoice_item')->delete()->execute();
    //     $this->api->db->dsql()->table('xshop_invoice_item')->delete()->execute();
    //     $this->api->db->dsql()->table('xshop_invoices')->where('type','salesInvoice')->delete()->execute();
    //     $this->api->db->dsql()->table('xshop_invoices')->where('type','purchaseInvoice')->delete()->execute();
    //     $this->api->db->dsql()->table('xshop_items')->delete()->execute();
    //     $this->api->db->dsql()->table('xpurchase_purchase_order')->delete()->execute();


    //     $this->api->db->dsql()->table('xshop_orders')->delete()->execute();
    //     $this->api->db->dsql()->table('xshop_termsandcondition')->delete()->execute();
    //     $this->api->db->dsql()->table('xaccount_account')->delete()->execute();
    //     $this->api->db->dsql()->table('xstore_material_request')->delete()->execute();
    //     $this->api->db->dsql()->table('xhr_employees')->delete()->execute();
    //     $this->api->db->dsql()->table('xhr_employee_attendence')->delete()->execute();
    //     $this->api->db->dsql()->table('xhr_employee_leave')->delete()->execute();

    //     return null;
    // }

    // function test_reset(){
    //     return array('epans'=>$this->add('Model_Epan')->count()->getOne(),
    //                     'user'=>$this->add('Model_Users')->count()->getOne(),
    //                     'user_custom_field'=>$this->add('Model_UserCustomFields')->count()->getOne(),
    //                     'general_setting'=>'ok',
    //                     'default_departments'=>$this->add('xHR/Model_Department')->count()->getOne(),
    //                     'employee'=>$this->add('xHR/Model_Employee')->count()->getOne(),
    //                     'employee_attandance'=>$this->add('xHR/Model_EmployeeAttendence')->count()->getOne(),                        
    //                     'employee_leave'=>$this->add('xHR/Model_EmployeeLeave')->count()->getOne(),
    //                     'employee_setup'=>'ok',
                        
    //                     'leads_category'=>$this->add('xMarketingCampaign/Model_LeadCategory')->count()->getOne(),
    //                     'leads'=>$this->add('xMarketingCampaign/Model_Lead')->count()->getOne(),
    //                     'newsletter_category'=>$this->add('xEnquiryNSubscription/Model_NewsLetterCategory')->count()->getOne(),
    //                     'newsletter'=>$this->add('xEnquiryNSubscription/Model_NewsLetter')->count()->getOne(),
    //                     'social_content'=>$this->add('xMarketingCampaign/Model_SocialPost')->count()->getOne(),
    //                     'data_grabber'=>$this->add('xMarketingCampaign/Model_DataGrabber')->count()->getOne(),
    //                     'campaigns'=>$this->add('xMarketingCampaign/Model_Campaign')->count()->getOne(),
    //                     'marketing_mail_configuration'=>'ok',
    //                     'marketing_social_configuration'=>'ok',

    //                     'opportunity'=>$this->add('xShop/Model_Opportunity')->count()->getOne(),
    //                     'quotations'=>$this->add('xShop/Model_Quotation')->count()->getOne(),
    //                     'items_category'=>$this->add('xShop/Model_Category')->count()->getOne(),
    //                     'items'=>$this->add('xShop/Model_Item')->count()->getOne(),
    //                     'affiliate_type'=>$this->add('xShop/Model_AffiliateType')->count()->getOne(),
    //                     'affiliate'=>$this->add('xShop/Model_Affiliate')->count()->getOne(),
    //                     'discount_vouchers'=>$this->add('xShop/Model_DiscountVoucher')->count()->getOne(),
    //                     'discount_vouchers_used'=>$this->add('xShop/Model_DiscountVoucherUsed')->count()->getOne(),
    //                     'customers'=>$this->add('xShop/Model_Customer')->count()->getOne(),
    //                     'sales_orders'=>$this->add('xShop/Model_Order')->count()->getOne(),
    //                     'sales_invoices'=>$this->add('xShop/Model_SalesInvoice')->count()->getOne(),
    //                     'sales_invoices_item'=>$this->add('xShop/Model_InvoiceItem')->count()->getOne(),
    //                     'payment_gateway_config'=>$this->add('xShop/Model_PaymentGateway')->count()->getOne(),
    //                     'term_and_condition'=>$this->add('xShop/Model_TermsAndCondition')->count()->getOne(),
    //                     'xshop_custom_fields'=>$this->add('xShop/Model_CustomFields')->count()->getOne(),
    //                     'xshop_custom_field_value'=>$this->add('xShop/Model_CustomFieldValue')->count()->getOne(),
    //                     'xshop_custom_field_association'=>$this->add('xShop/Model_ItemCustomFieldAssos')->count()->getOne(),
    //                     'xshop_custom_field_filter_association'=>$this->add('xShop/Model_CustomFieldValueFilterAssociation')->count()->getOne(),
    //                     'xshop_custom_rate_condition'=>$this->add('xShop/Model_CustomRateCustomeValueCondition')->count()->getOne(),
    //                     'specification'=>$this->add('xShop/Model_Specification')->count()->getOne(),
    //                     'specification_association'=>$this->add('xShop/Model_ItemSpecificationAssociation')->count()->getOne(),
    //                     'item_offers'=>$this->add('xShop/Model_ItemOffer')->count()->getOne(),
    //                     'xshop_configuration'=>$this->add('xShop/Model_Configuration')->count()->getOne(),

    //                     'outsource_parties'=>$this->add('xProduction/Model_OutSourceParty')->count()->getOne(),
    //                     'outsource_parties_department_association'=>$this->add('xProduction/Model_OutSourcePartyDeptAssociation')->count()->getOne(),
    //                     'production_phases'=>$this->add('xProduction/Model_Phase')->addCondition('id','>',9)->count()->getOne(),
    //                     'job_cards'=>$this->add('xProduction/Model_JobCard')->count()->getOne(),
    //                     'task'=>$this->add('xProduction/Model_Task')->count()->getOne(),
    //                     'team'=>$this->add('xProduction/Model_Team')->count()->getOne(),
    //                     'employee_team_association'=>$this->add('xProduction/Model_EmployeeTeamAssociation')->count()->getOne(),

    //                     'support_ticket'=>$this->add('xCRM/Model_Ticket')->count()->getOne(),
    //                     'company_emails'=>$this->add('xHR/Model_OfficialEmail')->count()->getOne(),
    //                     'emails'=>$this->add('xCRM/Model_Email')->count()->getOne(),
    //                     'smses'=>$this->add('xCRM/Model_SMS')->count()->getOne(),
    //                     'document_activities'=>$this->add('xCRM/Model_Activity')->count()->getOne(),

    //                     'accounts'=>$this->add('xAccount/Model_Account')->count()->getOne(),
    //                     'balance_sheet'=>$this->add('xAccount/Model_BalanceSheet')->count()->getOne(),
    //                     'group'=>$this->add('xAccount/Model_Group')->count()->getOne(),
    //                     'transactions'=>$this->add('xAccount/Model_Transaction')->count()->getOne(),
    //                     'ledgers'=>$this->add('xAccount/Model_Account')->count()->getOne(),
    //                     'transaction_type'=>$this->add('xAccount/Model_TransactionType')->count()->getOne(),
                        
    //                     'purchase_invoice'=>$this->add('xPurchase/Model_PurchaseInvoice')->count()->getOne(),
    //                     'purchase_invoice_item'=>$this->add('xShop/Model_InvoiceItem')->count()->getOne(),
    //                     'purchase_order'=>$this->add('xPurchase/Model_PurchaseOrder')->count()->getOne(),
    //                     'purchase_order_item'=>$this->add('xPurchase/Model_PurchaseOrderItem')->count()->getOne(),
    //                     'suppliers'=>$this->add('xPurchase/Model_Supplier')->count()->getOne(),
                        
    //                     'dispatch_requests'=>$this->add('xDispatch/Model_DispatchRequest')->count()->getOne(),
    //                     'dispatch_requests_item'=>$this->add('xDispatch/Model_DispatchRequestItem')->count()->getOne(),
    //                     'delivery_notes'=>$this->add('xDispatch/Model_DeliveryNote')->count()->getOne(),
    //                     'delivery_note_item'=>$this->add('xDispatch/Model_DeliveryNoteItem')->count()->getOne(),
                        
    //                     'warehouses'=>$this->add('xStore/Model_Warehouse')->count()->getOne(),
    //                     'stocks'=>$this->add('xStore/Model_Stock')->count()->getOne(),

    //                     'material_requests'=>$this->add('xStore/Model_MaterialRequest')->count()->getOne(),
    //                     'material_request_items'=>$this->add('xStore/Model_MaterialRequestItem')->count()->getOne(),
                        
    //                     'activities'=>0
    //             );
    // }

}