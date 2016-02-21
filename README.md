Base Rest API
=============

This project is to help developers to start a new Symfony RESTFull webservice with user management.

Here are the steps to start a new project:

1. Fork the repository from github.com (https://github.com/EntropyFactory/base-rest-api)
2. Execute `./setup.sh NameBundle` to change the Bundle namespace as you like.
3. Point your vhost to the `web` folder.
4. Setup `app/config/parameters.yml` with your settings.
5. Create the required tables in database:

    `php bin/console doctrine:schema:update --force`
6. Clear the symfony cache  
    
    `php bin/console cache:clear`
    
7. Now you are ready to start coding, see `src/AppBundle/Controller/HelloController.php` to see how it works with
authenticated and unauthenticated routes.


# Useful tricks

* Vhost example (to allow user to code as himself and not root)

    ```
    <VirtualHost *:80>
    
      ServerAdmin admin@localhost
      ServerName api.my-awesome-domain.com
      DocumentRoot /home/myuser/rest-projects/name-project/web/
    
      <Directory   /home/myuser/rest-projects/name-project/web/>
        AllowOverride All
        Require all Granted
        Options -Indexes
      </Directory>
    
      CustomLog /home/myuser/logs/name-project-access.log combined
      ErrorLog /home/myuser/logs/name-project-error.log
    
    </VirtualHost>
    ```
* Fixing permissions problems with `var` directory because apache2 runs with different user than shell commands.

    As `root` execute the following, this will give permissions to `myuser` and `www-data` to write in the `var` folder

    ```
    setfacl -dR -m u:www-data:rwX -m u:myuser:rwX var
    setfacl -R -m u:www-data:rwX -m u:myuser:rwX var
    
    ```

* Postman base api (http://www.getpostman.com/)
 
    https://www.getpostman.com/collections/91023b35e9d2386fc921
    

* Create `client_id` and `client_secret`
    
    `php bin/console oauth2:client:create --grant-type="password" --grant-type="client_credentials" --grant-type="refresh_token"`
    
* Create user

    `php bin/console fos:user:create`
    
* Promote user

    `php bin/console fos:user:promote myuser ROLE_ADMIN`