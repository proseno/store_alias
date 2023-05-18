<?php
declare(strict_types=1);

namespace Proseno\StoreAlias\Plugin;

use Proseno\StoreAlias\Model\StoreResolver;
use Magento\Store\App\Request\PathInfoProcessor;
use Magento\Store\Model\StoreManagerInterface;
use Proseno\StoreAlias\Model\Config;

readonly class RemoveStoreAliasFromPath
{
    /**
     * @param Config $configHelper
     * @param StoreResolver $storeHelper
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        private Config                $configHelper,
        private StoreResolver         $storeHelper,
        private StoreManagerInterface $storeManager
    ) {
    }

    /**
     * @param PathInfoProcessor $subject
     * @param string $result
     * @return string
     */
    public function afterProcess(PathInfoProcessor $subject, string $result): string
    {
        $alias = $this->getStoreAlias($result);
        if (!$alias) {
            return $result;
        }
        $store = $this->storeHelper->getStoreByAlias($alias);
        $this->storeManager->reinitStores();
        $this->storeManager->setCurrentStore($store);
        if (($store && $store->getId()) && $this->configHelper->isEnabled($store->getId())) {
            $result = $this->trimStoreAliasFromPathInfo($result, $alias);
        }
        return $result;
    }

    /**
     * @param string $pathInfo
     * @return string
     */
    private function getStoreAlias(string $pathInfo) : string
    {
        $pathParts = explode('/', ltrim($pathInfo, '/'), 2);
        return current($pathParts);
    }

    /**
     * @param string $pathInfo
     * @param string $alias
     * @return string|null
     */
    private function trimStoreAliasFromPathInfo(string $pathInfo, string $alias) : ?string
    {
        if (str_starts_with($pathInfo, '/' . $alias)) {
            $pathInfo = substr($pathInfo, strlen($alias)+1);
        }
        return empty($pathInfo) ? '/' : $pathInfo;
    }
}
