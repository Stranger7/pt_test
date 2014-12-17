pt_test
=======
Тестовое задание

Requirements
------------ 
- PHP 5.5
- MySQL

Installation
------------
- Скачать и распаковать.
- Создать БД:
  ```
  php console/crystal.php app\cli\db_create 
  ```
- Применить фикстуры:
  ```
  php console/crystal.php app\cli\fixtures apply 
  ```
- Создать админа:
  ```
  php console/crystal.php app\cli\admin create username=email password=****
  ```
- Настроить веб-сервер на папку
  ```
  site/
  ```
