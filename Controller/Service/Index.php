<?php

namespace Freddev\WeatherWidget\Controller\Service;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;

class Index extends Action
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
	 */

	public function __construct(
		Context $context,
        \Freddev\WeatherWidget\Helper\Data $helper,
        \Freddev\WeatherWidget\Logger\Logger $logger
	) {
		parent::__construct($context);
        $this->_logger = $logger;
        $this->_helper = $helper;
	}

	/**
	 * Prints the information
	 * @return json
	 */
	public function execute() {
		$post = $this->getRequest()->getPost();
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        if($post){
            
            $data = [];
            $data['response'] = $this->_helper->getCurrentWeather($post['location']);
            $data['status'] = 'done';
            
            $resultJson->setData($data);
        }else{
            $resultJson->setData($data);
        }
        return $resultJson;
    }
}