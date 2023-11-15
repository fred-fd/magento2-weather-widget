<?php

namespace Freddev\WeatherWidget\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const XML_PATH_WEATHERWIDGET = 'weatherwidget/';

    /**
     * Logging instance
     * @var \YourNamespace\YourModule\Logger\Logger
     * $this->_logger->info('I did something');
     */
    protected $_logger;

    /**
     * Data constructor.
     *
     * @param Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Freddev\WeatherWidget\Logger\Logger $logger
    ) {
        $this->_logger = $logger;
        parent::__construct($context);
    }

    public function getConfigValue($field, $storeId = null)
	{
		return $this->scopeConfig->getValue(
			$field, ScopeInterface::SCOPE_STORE, $storeId
		);
	}

	public function getGeneralConfig($code, $storeId = null)
	{

		return $this->getConfigValue(self::XML_PATH_WEATHERWIDGET .'general/'. $code, $storeId);
	}

    public function isModuleEnable($storeId = null){

        return $this->getGeneralConfig('enable');
        
    }

    public function getCurrentWeather($location){

        try{

            $url = $this->getGeneralConfig('api_url');
            $apikey = $this->getGeneralConfig('api_key');

            $weatherData = $this->postCallApi($url, $location, $apikey);

            return $weatherData;

        }catch(\Exception $e){
            $this->_logger->info("API_response_error: " . $e->getMessage());
            return "Error";
        }

    }

    public function postCallApi($url, $location, $apikey){

        $curl = curl_init();
        $post = [
            'key' => $apikey,
            'q' => $location,
            'aqi'   => "no",
        ];

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_POSTFIELDS => $post,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        ));

        $response = json_decode(curl_exec($curl), 0);
        $this->_logger->info("API_response: " . print_r($response, true));
        if(!isset($response->error)){
            $weatherData = array(
                'location' => $response->location->name,
                'img_condition' => 'https:' . $response->current->condition->icon,
                'temp_c' => $response->current->temp_c,
                'temp_f' => $response->current->temp_f,
                'wind_s' => $response->current->wind_kph
            );
        }else{
            $weatherData = "empty";
        }
        
        curl_close($curl);
        $this->_logger->info("API_response: " . print_r($weatherData, true));

        return $weatherData;
    }
}