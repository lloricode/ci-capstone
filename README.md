# [ci-capstone](http://ci-capstone.lloricmayugagarcia.com/)
## A Thesis project made by using [CodeIgniter](http://codeigniter.com).



## Frameworks used
Platform|Framework
--------------------- | ----------------------------
 PHP Framework        | [CodeIgniter 3.1.4](http://codeigniter.com).
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
- then just run/execute the website, ``tables`` in ``database`` will automatically migrate.

## Default Login

Username | Password
-------- | -----------
administrator|mypasswordisadmin1

## Screencapture
-Updated overview over the Admin Panel
![screenshot at 2017-03-25 10-53-25](https://cloud.githubusercontent.com/assets/8251344/24318920/75f18732-1149-11e7-9279-397a8405fa23.png)

-Database Relation,(result after migration)
![screenshot at 2017-04-02 13-04-48](https://cloud.githubusercontent.com/assets/8251344/24584608/3e2cb008-17a5-11e7-8e48-a1bdeadcd2b0.png)

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

  
