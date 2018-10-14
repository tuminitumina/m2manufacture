<?php
namespace Ivanfabrynugraha\Manufacture\Plugin\Checkout\Model;
 
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Catalog\Model\ProductRepository as ProductRepository;
 
class DefaultConfigProviderPlugin extends \Magento\Framework\Model\AbstractModel
{
    protected $checkoutSession;
 
    protected $_productRepository;
 
    public function __construct(
        CheckoutSession $checkoutSession,
        ProductRepository $productRepository
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->_productRepository = $productRepository;
    }
 
    public function afterGetConfig(
        \Magento\Checkout\Model\DefaultConfigProvider $subject, 
        array $result
    ) {
        $items = $result['totalsData']['items'];
        foreach ($items as $index => $item) {
            $quoteItem = $this->checkoutSession->getQuote()->getItemById($item['item_id']);
            $product = $this->_productRepository->getById($quoteItem->getProduct()->getId());
            $result['quoteItemData'][$index]['manufacture'] = $product->getResource()->getAttribute('manufacture')->getFrontend()->getValue($product);
        }
        return $result;
    }
}