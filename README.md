## About Project
A simple project to deal with csv data and reformating them to another format using Laravel 12 that contain following features:

- upload csv file for students scores details
- process student data and return more clear data format
- download csv sample to be used later when uplaod step.
- seed subjects ranking method to be used when process data
- add form to add new subjects and its score,sort
- retrieve all active subjects in home page

## Requirements
- php ^8.2

## Install dependencies

To serve the project locally, you should follow below steps:

```bash
    1.  git clone https://github.com/magdasaif/student_scores.git
    2.  cd student_scores/
    3.  make sure that you are on league branch  
    4.  composer install
    5.  cp .env.example .env
    6.  php artisan key:generate
    7.  Creat db and add its credinational in the .env file
    8.  php artisan migrate
    9.  php artisan db:seed
    10. php artisan serve 
``` 

## Used Packages

For Csv reformating use 
```bash
league/csv 
```
make sure that ext-filter exentsion was enabled