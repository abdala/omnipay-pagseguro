<?php
/**
 * PagSeguro Abstract Request
 */

namespace Omnipay\PagSeguro\Message;

class PurchaseRequest extends AbstractRequest
{
    protected $resource = "checkout";
    
    protected function getItemData()
    {
        $data = [];
        $items = $this->getItems();
        
        if ($items) {
            foreach ($items as $n => $item) {
                $i = $n + 1;
                $data["itemId$i"] = $item->getName();
                $data["itemDescription$i"] = $item->getDescription();
                $data["itemAmount$i"] = $this->formatCurrency($item->getPrice());
                $data["itemQuantity$i"] = $item->getQuantity();
                $data["itemWeight$i"] = $item->getWeight();
            }
        }

        return $data;
    }
    
    public function getData()
    {
        return array_merge(parent::getData(), $this->getItemData());
    }
    
    protected function createResponse($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }
}
