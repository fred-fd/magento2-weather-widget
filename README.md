
## Freddev Weather Widget Info

**Weather Widget** for Magento 2 show weather wiget by navigator geolocation 

## Highlight Features

- Customers can see weather in header of store

## How to use Weather Widget extension
Before you continue, ensure you meet the following requirements:

  * You have installed magento2
  
### Install Weather Widget extension:

### Step 1 : Download Freddev Weather Widget Extension

#### Install via app/code 
Extract the extension from freddev_weatherwidget.tar.gz

Create Dir vendor Freddev in app/code/

Put the WeatherWidget in Freddev directory, and run the next commands:
```
php bin/magento module:enable Freddev_WeatherWidget
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy -f
php bin/magento cache:clean
```

### Step 2: User guide
  #### Key features of Weather Widget Extension:
  * Enable and disable the feature from store > configuration

  ### 2.1. General configuration

  `Login to Magento admin > Stores > Configuration > FMAH EXTENSIONS > Weather Widget > General > Choose Yes to enable the module.`


  
  
  