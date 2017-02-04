# [ci-capstone](http://ci-capstone.lloricmayugagarcia.com/)
## A Thesis project made by using [CodeIgniter](http://codeigniter.com).

The project description will be updated including the client side after we proposed a project and gets approved by our instuctor.

## Frameworks used

* PHP Framework        : [CodeIgniter 3.1.3](http://codeigniter.com).
* Admin UI Framework   : [matrix-admin Bootstrap](http://matrixadmin.themedesigner.in/).
* Client UI Framework  : soon

## Library used

* Login Authentication  : [CodeIgniter-Ion-Auth](https://github.com/benedmunds/CodeIgniter-Ion-Auth).

## Installation

- For installation ``clone or download`` the project and put the files into your server. 

	If your using ``XAMPP`` put it in the ``htdocs`` folder and for ``WAMP`` server put it in the ``www`` folder.

- For Linux user ``cd /opt/lampp/htdocs`` then ``git clone https://github.com/lloricode/ci-capstone.git``

- Create a database ``ci_capstone`` in your local machine, 

	then import the ``ci_capstone.sql`` 

	from the project you cloned/downloaded into the created database.


## Configurations

- base_url

    Open the ``application/config/config.php`` file of the project
    then check if the base_url is set like this 
    
    ``$config['base_url'] = 'http://[::1]/ci-capstone/';``

- database

    Open the ``application/config/database.php`` file of the project
    then check if the database is configured like this
    
    ```java
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'ci_capstone',
```

## Default Login

- username: administrator
- password: mypasswordisadmin1

## Screencapture
-An overview over the Admin Panel
![home-cicapstone](https://cloud.githubusercontent.com/assets/24410101/21073805/dd95c010-bf23-11e6-9a97-511a0bb52439.jpg)


 

