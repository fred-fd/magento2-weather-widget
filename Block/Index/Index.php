<?php

namespace Freddev\WeatherWidget\Block\Index;

class Index extends \Magento\Framework\View\Element\Template
{

    /**
     * Helper instance
     * @var \Freddev\WeatherWidget\Helper\Data
     */
    protected $_helper;

    /**
     * Logging instance
     * @var \Freddev\WeatherWidget\Logger\Logger
     */
    protected $_logger;

    /**      
    * @param Context $context
    * @param Data $helper   
    * @param Logger $logger   
    */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Freddev\WeatherWidget\Helper\Data $helper,
        \Freddev\WeatherWidget\Logger\Logger $logger,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_logger = $logger;
        $this->_helper = $helper;
    }

    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function isModuleEnable(){

        return $this->_helper->isModuleEnable();

    }
}