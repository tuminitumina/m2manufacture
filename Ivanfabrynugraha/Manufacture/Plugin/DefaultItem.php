<?php

namespace Ivanfabrynugraha\Manufacture\Plugin;

use Magento\Quote\Model\Quote\Item;

class DefaultItem
{
    public function aroundGetItemData($subject, \Closure $proceed, Item $item)
    {
        $data = $proceed($item);
        $product = $item->getProduct();

        $atts = [
            "product_manufacture" => $product->getAttributeText('manufacture'),
        ];

        return array_merge($data, $atts);
    }
}