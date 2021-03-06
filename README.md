REST API
===============

Welcome to the REST API - a simple example REST API 
that you can use as the skeleton for your new REST project.

Installation
============
REST API work with PHP 5.6 or later and MySQL 5.4 or later (please check requirements)

### From repository

Get REST API source files from GitHub repository:
```````````````````````````````````````````````````````````
git clone https://github.com/Konstyantin/restProject %path%
```````````````````````````````````````````````````````````

Download `composer.phar` to the project folder:
```````````````````````````````````````````````
cd %path%
curl -s https://getcomposer.org/installer | php
```````````````````````````````````````````````

Install composer dependencies with the following command:
`````````````````````````
php composer.phar install
`````````````````````````

Build database connect
======================
Create file which store database connect parameters
 
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
touch app/config/db_params.php
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

After set params 

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
return [
    'host'      => 'host name',     // localhost
    'dbname'    => 'database name', // test
    'user'      => 'root_name',     // root
    'password'  => 'root_password', // 1
];
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


Test REST via CURL
======================
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$curl->getAction($id);          // get
$curl->postAction($data);       // post
$curl->putAction($id,$data);    // put
$curl->deleteAction($id);       // delete

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Run build Swagger API documentation
=======================================
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
./vendor/bin/swagger src/Controller/ -o swagger.json
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

REST API paths
=====================================
You can use REST API via the routes :

Get post via GET method
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
/post/{id} 
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
Create new post via POST method
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
/post
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
Update post via PUT method 
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
/post/{id}
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
Delete post via DELETE method
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
/post/{id}
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~