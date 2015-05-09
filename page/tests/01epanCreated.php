<?php

class page_tests_01epanCreated extends page_tests_base {
  public $title = 'Epans Created Testing';


    function prepare_newEpanCreated(){

        $new_epan_name = 'web'.rand(1,99999);
        $epan = $this->add('Model_Epan')
            ->set('name',$new_epan_name)
            ->set('email_id','web'.rand(1,99999).'@example.com')
            ->set('password','xepan')
            ->set('branch_id',$this->add('Model_Branch')->tryLoadAny()->get('id'))
            ->save();
        $this->api->current_website = $epan;

        $this->proper_responses['Test_newEpanCreated']=array(
            'epans_count'=>$this->api->db->dsql()->expr("select count(*) from epan")->getOne(),
            'general_settings'=>array('TOCHECK'),
            'currentepan_pages_count'=>1,
            'currentepan_template_count'=>1,
            'currentepan_template_values'=>array('name'=>'default','content'=>'<div component_namespace="baseElements" component_type="TemplateContentRegion" class="epan-sortable-component epan-component  ui-sortable" style="" contenteditable="false">~~Content~~</div>','body_attributes'=>'','is_current'=>1,'css'=>''),
            'currentepan_values'=>array('name'=>$new_epan_name,'epan_id'=>$epan->id),
            'currentepan_defaultpage_values'=>array('name'=>'home','epan_id'=>$epan->id,'content'=>0,'body_attributes'=>'','template_id'=>$this->add('Model_EpanTemplates')->tryLoadANy()->get('id')),
            'activities'=>0
            );
    }

    function Test_newEpanCreated(){
        $epan = $this->api->current_website;
        $template = $epan->templates()->tryLoadAny();
        $page = $epan->pages()->tryLoadAny();
        return array(
            'epans_count' => $this->add('Model_Epan')->count()->getOne(),
            'general_settings' => array('TOCHECK'),
            'currentepan_pages_count'=> $this->add('Model_EpanPage')->count()->getOne(),
            'currentepan_template_count'=>$this->add('Model_EpanTemplates')->count()->getOne(),
            'currentepan_template_values'=>array('name'=>$template['name'],'content'=>$template['content'],'body_attributes'=>$template['body_attributes'],'is_current'=>$template['is_current'],'css'=>$template['css']),
            'currentepan_values'=>array('name'=>$epan['name'],'epan_id'=>$epan->id),
            'currentepan_defaultpage_values'=>array('name'=>$page['name'],'epan_id'=>$page['epan_id'],'content'=>$page['content'],'body_attributes'=>$page['body_attributes'],'template_id'=>$page['template_id']),
            'activities'=>0

            );
    }

     function prepare_newEpanCreated_HR(){
            $this->proper_responses['Test_newEpanCreated_HR']=array(
                  'default_departments'=>9,
                  'employee'=>0,
                  'employee_attandance'=>0,                        
                  'employee_leave'=>0,
                  'employee_setup'=>'ok',
                  'documents_count'=>'156',
            );
     }

     function Test_newEpanCreated_HR(){

            return array(
                  'default_departments'=>$this->add('xHR/Model_Department')->count()->getOne(),
                  'employee'=>$this->add('xHR/Model_Employee')->count()->getOne(),
                  'employee_attandance'=>$this->add('xHR/Model_EmployeeAttendence')->count()->getOne(),                        
                  'employee_leave'=>$this->add('xHR/Model_EmployeeLeave')->count()->getOne(),
                  'employee_setup'=>'ok',
            );
     }


     function prepare_newEpanCreated_MarketingCampaign(){
            $this->proper_responses['Test_newEpanCreated_MarketingCampaign'] = array(
                  'leads_category'=>0,
                  'leads'=>0,
                  'newsletter_category'=>0,
                  'newsletter'=>0,
                  'social_content'=>0,
                  'data_grabber'=>3,
                  'campaigns'=>0,
                  'marketing_mail_configuration'=>'ok',
                  'marketing_social_configuration'=>'ok',
            );
     }

     function Test_newEpanCreated_MarketingCampaign(){
            return array(
                  'leads_category'=>$this->add('xMarketingCampaign/Model_LeadCategory')->count()->getOne(),
                  'leads'=>$this->add('xMarketingCampaign/Model_Lead')->count()->getOne(),
                  'newsletter_category'=>$this->add('xEnquiryNSubscription/Model_NewsLetterCategory')->count()->getOne(),
                  'newsletter'=>$this->add('xEnquiryNSubscription/Model_NewsLetter')->count()->getOne(),
                  'social_content'=>$this->add('xMarketingCampaign/Model_SocialPost')->count()->getOne(),
                  'data_grabber'=>$this->add('xMarketingCampaign/Model_DataGrabber')->count()->getOne(),
                  'campaigns'=>$this->add('xMarketingCampaign/Model_Campaign')->count()->getOne(),
                  'marketing_mail_configuration'=>'ok',
                  'marketing_social_configuration'=>'ok',
            );
     }

      function prepare_newEpanCreated_xShop(){
            $this->proper_responses['Test_newEpanCreated_xShop'] = array(
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
                  'default_salesinvoice_layout'=>1,
                  'default_purchseinvoice_layout'=>1,
                  'default_quotation_layout'=>1,
                  'default_cashvoucher_layout'=>1,
                  'default_order_layout'=>1,
            );
     }

     function Test_newEpanCreated_xShop(){
            $current_xshopconfig = $this->add('xShop/Model_Configuration')->tryLoadAny();
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
                  'default_salesinvoice_layout'=>$current_xshopconfig['invoice_email_body']?1:0,
                  'default_purchseinvoice_layout'=>$current_xshopconfig['purchase_invoice_email_body']?1:0,
                  'default_quotation_layout'=>$current_xshopconfig['quotation_email_body']?1:0,
                  'default_cashvoucher_layout'=>$current_xshopconfig['cash_voucher_email_body']?1:0,
                  'default_order_layout'=>$current_xshopconfig['purchase_order_detail_email_body']?1:0,
            );
     }

      function prepare_newEpanCreated_xProduction(){
            $this->proper_responses['Test_newEpanCreated_xProduction'] = array(
                  'outsource_parties'=>0,
                  'outsource_parties_department_association'=>0,
                  'production_phases'=>3,
                  'job_cards'=>0,
                  'task'=>0,
                  'team'=>0,
                  'employee_team_association'=>0,
            );
     }

     function Test_newEpanCreated_xProduction(){
            return array(
                  'outsource_parties'=>$this->add('xProduction/Model_OutSourceParty')->count()->getOne(),
                  'outsource_parties_department_association'=>$this->add('xProduction/Model_OutSourcePartyDeptAssociation')->count()->getOne(),
                  'production_phases'=>$this->add('xProduction/Model_Phase')->count()->getOne(),
                  'job_cards'=>$this->add('xProduction/Model_JobCard')->count()->getOne(),
                  'task'=>$this->add('xProduction/Model_Task')->count()->getOne(),
                  'team'=>$this->add('xProduction/Model_Team')->count()->getOne(),
                  'employee_team_association'=>$this->add('xProduction/Model_EmployeeTeamAssociation')->count()->getOne(),
            );
     }

      function prepare_newEpanCreated_xCRM(){
            $this->proper_responses['Test_newEpanCreated_xCRM'] = array(
                  'support_ticket'=>0,
                  'company_emails'=>0,
                  'emails'=>0,
                  'smses'=>0,
                  'document_activities'=>0,
            );
     }

     function Test_newEpanCreated_xCRM(){
            return array(
                  'support_ticket'=>$this->add('xCRM/Model_Ticket')->count()->getOne(),
                  'company_emails'=>$this->add('xHR/Model_OfficialEmail')->count()->getOne(),
                  'emails'=>$this->add('xCRM/Model_Email')->count()->getOne(),
                  'smses'=>$this->add('xCRM/Model_SMS')->count()->getOne(),
                  'document_activities'=>$this->add('xCRM/Model_Activity')->count()->getOne(),
            );
     }

      function prepare_newEpanCreated_xAccount(){
            $this->proper_responses['Test_newEpanCreated_xAccount'] = array(
                  'accounts'=>0,
                  'balance_sheet'=>10,
                  'group'=>0,
                  'transactions'=>0,
                  'ledgers'=>0,
                  'transaction_type'=>0,
            );
     }

     function Test_newEpanCreated_xAccount(){
            return array(
                  'accounts'=>$this->add('xAccount/Model_Account')->count()->getOne(),
                  'balance_sheet'=>$this->add('xAccount/Model_BalanceSheet')->count()->getOne(),
                  'group'=>$this->add('xAccount/Model_Group')->count()->getOne(),
                  'transactions'=>$this->add('xAccount/Model_Transaction')->count()->getOne(),
                  'ledgers'=>$this->add('xAccount/Model_Account')->count()->getOne(),
                  'transaction_type'=>$this->add('xAccount/Model_TransactionType')->count()->getOne(),
            );
     }

      function prepare_newEpanCreated_xPurchase(){
            $this->proper_responses['Test_newEpanCreated_xPurchase'] = array(
                  'purchase_invoice'=>0,
                  'purchase_invoice_item'=>0,
                  'purchase_order'=>0,
                  'purchase_order_item'=>0,
                  'suppliers'=>0,            
            );
      }

      function Test_newEpanCreated_xPurchase(){
            return array(
                  'purchase_invoice'=>$this->add('xPurchase/Model_PurchaseInvoice')->count()->getOne(),
                  'purchase_invoice_item'=>$this->add('xShop/Model_InvoiceItem')->count()->getOne(),
                  'purchase_order'=>$this->add('xPurchase/Model_PurchaseOrder')->count()->getOne(),
                  'purchase_order_item'=>$this->add('xPurchase/Model_PurchaseOrderItem')->count()->getOne(),
                  'suppliers'=>$this->add('xPurchase/Model_Supplier')->count()->getOne(),
            );
      }
      
      function prepare_newEpanCreated_xDispatch(){
            $this->proper_responses['Test_newEpanCreated_xDispatch'] = array(
                  'dispatch_requests'=>0,
                  'dispatch_requests_item'=>0,
                  'delivery_notes'=>0,
                  'delivery_note_item'=>0,    
            );
     }

     function Test_newEpanCreated_xDispatch(){
            return array(
                  'dispatch_requests'=>$this->add('xDispatch/Model_DispatchRequest')->count()->getOne(),
                  'dispatch_requests_item'=>$this->add('xDispatch/Model_DispatchRequestItem')->count()->getOne(),
                  'delivery_notes'=>$this->add('xDispatch/Model_DeliveryNote')->count()->getOne(),
                  'delivery_note_item'=>$this->add('xDispatch/Model_DeliveryNoteItem')->count()->getOne(),
            );
     }
      
      function prepare_newEpanCreated_xStock(){
            $this->proper_responses['Test_newEpanCreated_xStock'] = array(
                  'warehouses'=>$this->add('xHR/Model_Department')->count()->getOne(),
                  'stocks'=>0,
                  'material_requests'=>0,
                  'material_request_items'=>0,
            );
      }

      function Test_newEpanCreated_xStock(){
            return array(
                  'warehouses'=>$this->add('xStore/Model_Warehouse')->count()->getOne(),
                  'stocks'=>$this->add('xStore/Model_Stock')->count()->getOne(),
                  'material_requests'=>$this->add('xStore/Model_MaterialRequest')->count()->getOne(),
                  'material_request_items'=>$this->add('xStore/Model_MaterialRequestItem')->count()->getOne(),
            );
      }

}