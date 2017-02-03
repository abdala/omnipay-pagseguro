<?php

namespace Omnipay\PagSeguro\Message;

use Omnipay\PagSeguro\Item;
use Omnipay\PagSeguro\Support\Customer\Customer;
use Omnipay\Common\Exception\InvalidRequestException;

class PurchaseRequest extends AbstractRequest
{
    protected $resource = "checkout";

    protected $shippingType = "3";

    public function getShippingType()
    {
        return $this->getParameter('shippingType');
    }

    public function setShippingType($value)
    {
        return $this->setParameter('shippingType', $value);
    }

    public function getShippingCost()
    {
        return $this->getParameter('shippingCost');
    }

    public function setShippingCost($value)
    {
        return $this->setParameter('shippingCost', $value);
    }

    public function getCustomer()
    {
        return $this->getParameter('customer');
    }

    public function setCustomer(Customer $value)
    {
        return $this->setParameter('customer', $value);
    }

    public function getExtraAmount()
    {
        $extraAmount = $this->getParameter('extraAmount');

        if ($extraAmount !== null && $extraAmount != 0) {
            if ($this->getCurrencyDecimalPlaces() > 0) {
                if (is_int($extraAmount) || (is_string($extraAmount) && false === strpos((string) $extraAmount, '.'))) {
                    throw new InvalidRequestException(
                        'Please specify extra amount as a string or float, with decimal places.'
                    );
                };
            }

            $extraAmount = $this->toFloat($extraAmount);

            // Check for rounding that may occur if too many significant decimal digits are supplied.
            $decimal_count = strlen(substr(strrchr(sprintf('%.8g', $extraAmount), '.'), 1));
            if ($decimal_count > $this->getCurrencyDecimalPlaces()) {
                throw new InvalidRequestException('Amount precision is too high for currency.');
            }

            return $this->formatCurrency($extraAmount);
        }
    }

    public function setExtraAmount($value)
    {
        return $this->setParameter('extraAmount', $value);
    }

    public function setItems($items)
    {
        $serializedItems = [];

        foreach ($items as $item) {
            if ($item instanceof Item) {
                $serializedItems[] = $item;
            } else {
                if ($item instanceof \Omnipay\Common\Item) {
                    $serializedItems[] = new Item($item->getParameters());
                } else {
                    $serializedItems[] = new Item($item);
                }
            }
        }

        return $this->setParameter('items', $serializedItems);
    }

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

    protected function getCustomerData()
    {
        $data = [];
        $customer = $this->getCustomer();

        if ($customer) {
            $data['senderEmail'] = $customer->getEmail();
            $data['senderName'] = $customer->getName();
            $data['senderCPF'] = $customer->getCPF();
            $data['senderBornDate'] = $customer->getBornDate();

            $phone = $customer->getPhone();
            if ($phone->getParameters()) {
                $data['senderAreaCode'] = $phone->getAreaCode();
                $data['senderPhone'] = $phone->getPhone();
            }
        }

        return $data;
    }

    protected function getShippingData()
    {
        $data = [];

        $data['shippingType'] = !empty($this->getShippingType()) ? $this->getShippingType() : $this->shippingType;
        $data['shippingCost'] = !empty($this->getShippingCost()) ? $this->formatCurrency($this->getShippingCost()) : '0.00';

        $customer = $this->getCustomer();
        if ($customer) {
            $address = $customer->getAddress();

            if ($address->getParameters()) {
                $data['shippingAddressCountry'] = $address->getCountry();
                $data['shippingAddressState'] = $address->getState();
                $data['shippingAddressCity'] = $address->getCity();
                $data['shippingAddressPostalCode'] = $address->getPostalCode();
                $data['shippingAddressDistrict'] = $address->getDistrict();
                $data['shippingAddressStreet'] = $address->getStreet();
                $data['shippingAddressNumber'] = $address->getNumber();
                $data['shippingAddressComplement'] = $address->getComplement();
            }
        }

        return $data;
    }
    
    public function getData()
    {
        $this->validate('currency', 'transactionReference');

        $data = [
            'currency' => $this->getCurrency(),
            'extraAmount' => $this->getExtraAmount(),
            'reference' => $this->getTransactionReference(),
            'redirectURL' => $this->getReturnUrl(),
            'notificationURL' => $this->getNotifyUrl(),
        ];

        return array_merge(parent::getData(), $data, $this->getItemData(), $this->getCustomerData(), $this->getShippingData());
    }
    
    protected function createResponse($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }
}
