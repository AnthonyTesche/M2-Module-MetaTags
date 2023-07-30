<?php

namespace Tesche\MetaTags\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\Framework\App\Config\ScopeConfigInterface;
use \Magento\Store\Model\ScopeInterface;
use \Magento\Cms\Model\Page;
use \Magento\Store\Model\StoreManagerInterface;

class Tags extends Template
{
    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        Page $page
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->page = $page;

        parent::__construct($context);
    }

    public function getStoreViewData()
    {
        $response = [];
        $currentStore = $this->storeManager->getStore();

        if (is_array($this->page->getStoreId()) && $this->page->getStoreId()[0] == 0) {
            // This lines where added because if the store is the DefaultStoreView(1)
            // If the store is configured "right" this code turns to be probably useless
            if ($currentStore->getId() == 1) {
                $currentStore->setId(0);
            }
            // End

            $response = $this->getAllStores($currentStore);
        } else {
            foreach ($this->page->getStoreId() as $key => $storeId) {
                if ($currentStore->getId() != $storeId) {
                    $store = $this->storeManager->getStore($storeId);
                    $response[$key]['language'] = $language = $this->getStoreLanguage($store->getStoreId());
                    $response[$key]['href'] = $store->getBaseUrl() . $language;
                }
            }
        }

        return $response;
    }

    public function getAllStores($currentStore): array
    {
        $response = [];
        foreach ($this->storeManager->getStores(true) as $key => $store) {
            if ($currentStore->getId() != $store->getId()) {
                $store = $this->storeManager->getStore($store->getId());
                $response[$key]['language'] = $language = $this->getStoreLanguage($store->getStoreId());
                $response[$key]['href'] = $store->getBaseUrl() . $language;
            }
        }

        return $response;
    }

    public function getStoreLanguage(int $storeId)
    {
        return strtolower(
            str_replace('_', '-', $this->scopeConfig->getValue(
                'general/locale/code',
                ScopeInterface::SCOPE_STORE,
                $storeId
            ))
        );
    }

    public function getSecureBaseUrl(int $storeId)
    {
        return $this->scopeConfig->getValue(
            'web/secure_base/url',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
