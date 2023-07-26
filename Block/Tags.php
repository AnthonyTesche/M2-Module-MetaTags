<?php

namespace Tesche\MetaTags\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\Cms\Model\Page;
use \Magento\Framework\Locale\ResolverInterface;
use \Magento\Store\Model\StoreManagerInterface;

class Tags extends Template
{
    /**
     * @var Page
     */
    public $page;

    /**
     * @var ResolverInterface
     */
    public $resolverInterface;

    public function __construct(
        Context $context,
        Page $page,
        ResolverInterface $resolverInterface,
        StoreManagerInterface $storeManager
    ) {
        $this->page = $page;
        $this->resolverInterface = $resolverInterface;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    public function showTags(): bool
    {
        if (is_array($this->page->getStoreId())) {
            if (
                $this->page->getStoreId()[0] == 0 ||
                count($this->page->getStoreId()) > 1
            ) {
                return true;
            }
        }
        return false;
    }

    public function getStoreLanguage()
    {
        return strtolower(
            str_replace('_', '-', $this->resolverInterface->getLocale())
        );
    }

    public function getTagHref()
    {
        return $this->storeManager->getStore()->getBaseUrl() . $this->page->getIdentifier();
    }
}
