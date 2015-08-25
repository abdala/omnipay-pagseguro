<?php

namespace Omnipay\PagSeguro;

use Omnipay\Common\Item as BaseItem;

class Item extends BaseItem
{
    public function getWeight()
    {
        return $this->getParameter('weight');
    }

    public function setWeight($value)
    {
        return $this->setParameter('weight', $value);
    }
}