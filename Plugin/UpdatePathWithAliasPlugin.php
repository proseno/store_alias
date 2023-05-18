<?php
declare(strict_types=1);

namespace Proseno\StoreAlias\Plugin;

use Magento\Framework\UrlInterface;
use Magento\Store\Model\Store;
use Proseno\StoreAlias\Model\Config;

class UpdatePathWithAliasPlugin
{
    /**
     * @param Config $config
     */
    public function __construct(
        readonly private Config $config
    ) {
    }

    /**
     * @param Store $subject
     * @param string $result
     * @param string $type
     * @return string
     */
    public function afterGetBaseUrl(Store $subject, string $result, $type = UrlInterface::URL_TYPE_LINK): string
    {
        if ($type == UrlInterface::URL_TYPE_LINK) {
            if ($subject->isUseStoreInUrl()) {
                if ($this->config->isEnabled($subject->getId())) {
                    $alias = $subject->getAlias();
                    $codeToRemove = $subject->getCode() . '/';
                    if (str_ends_with($result, $codeToRemove)) {
                        $result = substr($result, 0, -strlen($codeToRemove));
                    }
                    $result .= $alias . '/';
                }
            }
        }
        return $result;
    }
}
