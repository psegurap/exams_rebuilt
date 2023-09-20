# Exams

### Description

Welcome! ***Exams*** is a tool that gives you the ability to create a test/exam from scratch. The user has the opportunity to select which kind of topics/questions will be part of the test. 

In addition, an authentication process has been incorporated.

### Required dependencies

- [PHP >= 8.1](https://www.php.net/downloads.php)
- [Composer](https://getcomposer.org/download)
- [Node.js](https://nodejs.org/en/download)


### Install and run the project

- Fork this repository
- Clone your forked repository
- Navigate to the cloned repository and open your terminal
- Run the following commands:
    
    ```bash
    - composer install #install laravel dependencies
    - cp .env.example .env #create a new environment file (edit the created file with your database information)
    - php artisan key:generate #generate a new key
    - php artisan migrate #create all the necessaries tables in our database
    - php artisan db:seed #create a user 
    - npm install #install dependencies for authentication
    - npm run build #build assets and create the manifest file
    - php artisan serve #start our project in a local/development server

    ``` 
- Use the following credentials to authenticate:

    ```
    email: testuser@exams.com
    password: password
    ```
