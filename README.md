CROUS Installation
===================

System requirement
------------------
- PHP needs to be a minimum version of PHP 5.3.9
- JSON needs to be enabled
- ctype needs to be enabled
- Your php.ini needs to have the date.timezone setting

For the first installation
--------------------------
1 - At the web root run this in your terminal to get the latest Composer version

    curl -sS https://getcomposer.org/installer | php

2 - Updating vendor & generate autoload file by this command 

    php composer.phar update

3 - Create and writable permission for for folders app/cache and app/logs

    sudo chmod -R 755 app/cache
    sudo chmod -R 755 app/logs

Setup Database
--------------
4 - Update the database connection info in app/config/parameters.yml 

    database_host: 10.0.0.3
    database_port: null
    database_name: vbs_crous
    database_user: root
    database_password: root

5 - Run this command to create tables

    php app/console doctrine:schema:update --force

6 - Initialize basic data by this command

    php app/console crous:populate:data
    
Clear cache
-----------
7 - Clear cache production and develop environment

    php app/console cache:clear --env=prod
    php app/console cache:clear --env=dev

Please clear cache when update source code from svn

Setup Virtual Host
------------------
8 - Set the DocumentRoot to [WEB_ROOT]/web

    For example:
    <VirtualHost *:80>
        ServerAdmin webmaster@vbs-crous.dev.com    
        ServerName vbs-crous.dev.com
   
        DocumentRoot /media/projects/dev/vbs-crous.dev.com/web
        <Directory /media/projects/dev/vbs-crous.dev.com/web>
           Options Indexes FollowSymLinks
           AllowOverride All 
           Require all granted
        </Directory>
    </VirtualHost>

9 - Run website
    
    http://yourdomain/admin

    Account: admin@crous.com/admin

Push Notification API
---------------------
1 - Setting API information in app/config/parameters.yml
    
    push_url: 'http://ynp.sophiacom.fr/ynp/sandbox/sendNotification'
    push_api_key: 'api_key'
    push_shared_secret: 'secret'
    push_appname: 'com.youandpush.myapp'
    push_project: 'projectkey'

2 - Code Implemented
    
    $apiUrl = $this->container->getParameter('push_url');
    $apiKey = $this->container->getParameter('push_api_key');
    $apiSecret = $this->container->getParameter('push_shared_secret');
    $apiAppName = $this->container->getParameter('push_appname');
    $apiProject = $this->container->getParameter('push_project');
    
    $requestVars = array();
    $requestVars['project'] = $apiProject;
    $requestVars['message'] = $data['message'];
    $requestVars['dkGroup'] = 'general';
    $requestVars['dks'] = $data['region']->getName();
    $requestVars['title'] = $data['title'];
                
    $arg = $apiSecret;
    foreach ($requestVars as $key=>$value) {
        $arg = $arg.$key.$value;   
    }
    
    $apiSig = md5($arg);
    $requestVars['api_sig'] = urlencode($apiSig);
    $requestVars['api_key'] = urlencode($apiKey);
    $result = $this->callApi('GET', $apiUrl, $requestVars);
    $xmlResult = simplexml_load_string($result);
    if (isset($xmlResult->error->message)) {
        $this->addFlash('error', $xmlResult->error->message);
    } else {
        $this->addFlash('success', $this->get('translator')->trans('Send successful'));
    }

