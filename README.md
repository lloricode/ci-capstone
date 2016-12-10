# [ci-capstone](http://ci-capstone.lloricmayugagarcia.com/)
## A Thesis project made by [CodeIgniter](http://codeigniter.com).

This project will be updated including the client side after our proposed project gets approved by our instructor. 

## Frameworks used

* PHP Framework       : [CodeIgniter 3.1.2](http://codeigniter.com).
* Admin UI Framework  : [matrix-admin Bootstrap](http://matrixadmin.themedesigner.in/).
* Client UI Framework : soon


### Installation

* First ``clone or download`` this project on your ``htdocs`` folder if you are using ``XAMPP`` as a server or ``www`` folder if ``WAMP`` server.
    ``cd /opt/lampp/htdocs`` then ``git clone https://github.com/lloricode/ci-capstone.git``

* Create a database ``ci_capstone`` in your local machine
    then import the ``ci_capstone.sql`` from the project you clone/downloaded in root folder.


### Configurations

* base_url
    Open the ``application/config/config.php`` files of the project
    then check if the base_url is set like this ``$config['base_url'] = 'http://[::1]/ci-capstone/';``

* database
    Open the ``application/config/database.php`` files of the project
    then check if the database is configured like this
    `` 'hostname' => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => 'ci_capstone',``
