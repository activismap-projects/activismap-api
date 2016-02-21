Base Rest API
=============

This project is to help developers to start a new Symfony RESTFull webservice with user management.

Here are the steps to start a new project:

1. Fork the repository from github.com (https://github.com/EntropyFactory/base-rest-api)
2. Execute `./setup.sh NameBundle` to change the Bundle namespace as you like.
3. Setup `app/config/parameters.yml` with your settings.
4. Create the required tables in database:

    `php bin/console doctrine:schema:update --force`
5. Clear the symfony cache  
    
    `php bin/console cache:clear`
    
6. Now you are ready to start coding, see `src/AppBundle/Controller/HelloController.php` to see how it works with
authenticated and unauthenticated routes.
