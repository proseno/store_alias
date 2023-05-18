<?php
declare(strict_types=1);

namespace Proseno\StoreAlias\Plugin;

use Magento\Backend\Block\System\Store\Edit\Form\Store;
use Magento\Framework\Data\Form;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

class AddAliasFieldPlugin
{
    /**
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        private readonly StoreManagerInterface $storeManager
    )
    {}

    /**
     * @param Store $subject
     * @param Form $result
     * @return Form
     */
    public function afterGetForm(Store $subject, Form $result): Form
    {
        if (!$result->getElement('store_alias')
            and $fieldset = $result->getElement('store_fieldset')
        ) {
            $storeId = $subject->getRequest()->getParam('store_id');
            try {
                $store = $this->storeManager->getStore($storeId);
            } catch (NoSuchEntityException $e) {
                return $result;
            }
            $fieldset->addField(
                'store_alias',
                'text',
                [
                    'name' => 'store[alias]',
                    'label' => __('Alias'),
                    'value' => $store->getData('alias'),
                    'required' => false,
                    'disabled' => false
                ]
            );
        }
        return $result;
    }
}
