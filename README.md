Base Rest API
=============

This project is to help developers to start a new Symfony RESTFull webservice with user management.

Here are the steps to start a new project:

1. Fork the repository from github.com (https://github.com/EntropyFactory/base-rest-api)
2. Execute `./setup.sh NameBundle` to change the Bundle namespace as you like.
3. Create the database for the project
4. Install composer dependences with `composer install` and fill the database settings.
5. Create the required tables in database:

    `php bin/console doctrine:schema:update --force`
6. Clear the symfony cache  
    
    `php bin/console cache:clear`
    
7. Now you are ready to start coding, see `src/AppBundle/Controller/HelloController.php` to see how it works with
authenticated and unauthenticated routes.


# Useful tricks

* Start the server with php5.4+ web server feature

    `php bin/console server:run`

* Base api collection for Postman (http://www.getpostman.com/).
 
    https://www.getpostman.com/collections/91023b35e9d2386fc921

* Create `client_id` and `client_secret`.
    
    `php bin/console oauth2:client:create --grant-type="password" --grant-type="client_credentials" --grant-type="refresh_token"`
    
* Create user.

    `php bin/console fos:user:create`
    
* Promote user.

    `php bin/console fos:user:promote myuser ROLE_ADMIN`
