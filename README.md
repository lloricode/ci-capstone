# [ci-capstone](http://ci-capstone.lloricmayugagarcia.com/)
## A Thesis project made by [CodeIgniter](http://codeigniter.com).

this project will be update inlcuding client side, after we propos a proposal project of our instructor.

## Frameworks used

* PHP Framework       : [CodeIgniter 3.1.2](http://codeigniter.com).
* Admin UI Framework  : [matrix-admin Bootstrap](http://matrixadmin.themedesigner.in/).
* Client UI Framework : soon


### Installation

* First ``clone`` this project on you ``htdocs`` folder, if you are using ``xampp``, ``www`` folder if ``wampp``
    ``cd /opt/lampp/htdocs`` then ``git clone https://github.com/lloricode/ci-capstone.git``

* Then create database ``ci_capstone`` in your local machine
    then import ``ci_capstone.sql`` from project you clone in root folder on you database that you created.


### Configurations

* base_url
    ``root/application/config/config.php`` 
    set ``$config['base_url'] = 'http://[::1]/ci-capstone/';``

* database
    ``root/application/config/database.php`` 
    set
    `` 'hostname' => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => 'ci_capstone',``
