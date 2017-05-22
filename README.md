#  [ci-capstone](https://github.com/lloricode/ci-capstone)
### A Thesis project (Enrollment System) made by using [CodeIgniter](http://codeigniter.com).


### Demo 

- [demo1](http://ci-capstone.lloricmayugagarcia.com)
- [demo2](http://ci-capstone.sprikiwiki.club/)

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

- OR you can just import in databse a sample data from ``sample_data/ci_capstone.sql``.

## Default Login

Username | Password
-------- | -----------
administrator|mypasswordisadmin1

## Screencapture
-Updated overview over the Admin Panel
![screenshot at 2017-04-09 21-26-03](https://cloud.githubusercontent.com/assets/8251344/24837640/50a98c44-1d6b-11e7-95b8-11c754f8c81d.png)

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

  
### Thanks to our team.

- [Jink Po](https://github.com/shikai06)
- [Edzar Calibod](https://github.com/iEdzar)

### Specially of Senior Programmer's suggesting.

- [Marcelius Dagpin](https://github.com/mardagz)
- [Jicking Bebiro](https://github.com/jicking)

