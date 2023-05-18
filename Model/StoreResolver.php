<?php
declare(strict_types=1);

namespace Proseno\StoreAlias\Model;

use Magento\Framework\App\RequestInterface;
use Magento\Store\Model\ResourceModel\Store\CollectionFactory;
use Magento\Store\Model\Store;

class StoreResolver
{
    const ALIAS_COLUMN = "alias";

    /**
     * @param RequestInterface $request
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        private readonly RequestInterface $request,
        private readonly CollectionFactory $collectionFactory
    ) {
    }

    /**
     * @param string $alias
     * @return Store|null
     */
    public function getStoreByAlias(string $alias): ?Store
    {
        $serverName = $this->request->getServer('SERVER_NAME');

        $collection = $this->collectionFactory->create();
        /** @var Store[] $items */
        $items = $collection->addFieldToFilter(self::ALIAS_COLUMN, ['eq' => $alias])->getItems();
        $store = null;

        foreach($items as $item) {
            $domain = parse_url($item->getBaseUrl())['host'];
            if ($domain != $serverName) {
                continue;
            }
            $store = $item;
            break;
        }

        return $store;
    }
}
