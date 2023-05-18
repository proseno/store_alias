<?php
declare(strict_types=1);

namespace Proseno\StoreAlias\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    private const IS_ENABLED_CONFIG_PATH = "proseno_store_alias/general/enable";

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig
    ) {
    }

    /**
     * @param $storeId
     * @return bool
     */
    public function isEnabled($storeId = null): bool
    {
        return (bool)$this->scopeConfig->getValue(self::IS_ENABLED_CONFIG_PATH, ScopeInterface::SCOPE_STORE, $storeId);
    }
}
