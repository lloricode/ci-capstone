# [ci-capstone](http://ci-capstone.lloricmayugagarcia.com/)
## A Thesis project made by using [CodeIgniter](http://codeigniter.com).



## Frameworks used
Platform|Framework
--------------------- | ----------------------------
 PHP Framework        | [CodeIgniter 3.1.3](http://codeigniter.com).
 Admin UI Framework   | [matrix-admin Bootstrap](http://matrixadmin.themedesigner.in/).


## Library used


 Name | Repository
-------------------------- | ----------------------
 Login Authentication      | [CodeIgniter-Ion-Auth](https://github.com/benedmunds/CodeIgniter-Ion-Auth).
 Migration Authentication  | [codeigniter-ion-auth-migration](https://github.com/iamfiscus/codeigniter-ion-auth-migration).
 Error Log                 | [CodeIgniter-Log-Library](https://github.com/appleboy/CodeIgniter-Log-Library).
 Excel Export              | [Codeigniter-Excel-Export](https://github.com/jiji262/Codeigniter-Excel-Export).
 Core My_Model             | [CodeIgniter-MY_Model](https://github.com/avenirer/CodeIgniter-MY_Model).
 Translator                | [codeigniter3-translations](https://github.com/bcit-ci/codeigniter3-translations).

## Installation

- Create first a databse named ``ci_capstone`` .
- execute the code for saving session in databse. 
```
         CREATE TABLE IF NOT EXISTS `ci_capstone_session` (
                 `id` varchar(128) NOT NULL,
                 `ip_address` varchar(45) NOT NULL,
                 `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
                 `data` blob NOT NULL,
                 KEY `ci_sessions_timestamp` (`timestamp`)
         );
```
- then just run/execute the website, ``tables`` in ``database`` will automatically migrate.

## Default Login

Username | Password
-------- | -----------
administrator|mypasswordisadmin1

## Screencapture
-Updated overview over the Admin Panel
![untitled](https://cloud.githubusercontent.com/assets/24410101/22813114/06677688-ef84-11e6-9cd2-4fdd96529b05.jpg)

 -Database Relation
![screenshot at 2017-02-10 11-01-24](https://cloud.githubusercontent.com/assets/8251344/22812863/2f71f5e6-ef82-11e6-9f11-916d854dc67f.png)

## Note:
### production ENVIRONMENT 
- compress html, for fast renderring page in live server 
- csrf_protection is enabled (set to TRUE), for prevent malicious/unnecessary behavior in submitting forms
- errors log save to database,then not directly seen in browsers,

### developing ENVIRONMENT
- compress html disabled, for easy monitoring html output (easy debugging)
- csrf_protection is disabled (set to FALSE), for easy submitting forms, for testing in big forms
- errors log disabled, directly promt in browser,
- database set to localhost 

### ..
- all is this set up in application/config/{ENVIRONMENT_FOLDER_NAMES}/config.php

  
