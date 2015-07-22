<?php

namespace Omnipay\CCAvenue\Message;

/**
 * CCAvenue Purchase Request
 */
class PurchaseRequest extends AuthorizeRequest
{
  public function getTransactionType()
  {
    return 'sale';
  }

  public function send()
    {	
        $data = $this->getData();
        return $this->sendData($data);
    }

}
