# PHP Authentication Tutorial
This code goes with the PHP authentication lessons at Treehouse.  It is used
to go over how to build authentication inside of your PHP application. We 
will be building a fully functioning book voting list with administrator 
roles and validation checks to make sure you own a book before edit.

## Install
To install this book project locally on your system, you will first need to 
have a valid web server that can run PHP 5.6+.  I suggest using Laravel 
Valet to host your applications as it makes the process an easy one. 
 
Once you have your local environment set up to host the site, follow the steps below.

> I am using `php-auth.dev` as the url I go to for viewing the site.  You will 
have to have a fully qualified domain name to make cookies work which we use 
for authentication purposes.

1. Clone this repository to your code folder.
2. Copy `.env.sample` to `.env`
3. Set up a mysql database for the project
4. Fill out the database information inside of the `.env` file
5. Set `COOKIE_DOMAIN` to the domain you use to access the site.
6. Generate a random 64 char string as your `SECRET_KEY`

    > Your `.env` file show now look something like this.
    ```
    DB_HOST=127.0.0.1
    DB_NAME=phpauth
    DB_USER=root
    DB_PASS=
    COOKIE_DOMAIN=php-auth.dev
    SECRET_KEY=PAeqWH4MCb7GLzuVGGB4K7ndbDm14992RdaMK5rBqLh6MWZlQDnJmlKyT14Ab4R
    ```

7. Save and close the `.env` file
8. Visit the url you chose with `/setup.php` at the end to build your database
9. Visit the url of your site and register


### Promote your initial user to Admin
You may want to promote your initial user to an administrator of the site. To
do this, open your database and visit the `users` table.  Once there, change
the `role_id` column of the user you just created to 1 and save the change.

From this point on, you can do all administrator changes from the web application.


## Working Example

I have set up a domain for a working example of this.  It can be viewed at 
[http://treehousephpauth.brianretterer.com/](http://treehousephpauth.brianretterer.com/)

Please feel free to register and create books.


