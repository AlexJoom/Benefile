# Benefile project

### Starting the project

For installing Laravel, please refer to [Official Laravel installation
guide](http://laravel.com/docs/5.1).

### Installing dependencies (assuming apache as web server and mysql as db):

In a nutchell (assuming debian-based OS), first install the dependencies needed:

Note: php5 package installs apache2 as a dependency so we have no need to add
it manually.

`% sudo aptitude install php5 php5-cli mcrypt php5-mcrypt mysql-server php5-mysql`

Install composer according to official instructions (link above) and move binary to ~/bin:

`% curl -sS https://getcomposer.org/installer | php5 && mv composer.phar ~/bin`

And add ~/.composer/vendor/bin to your $PATH. Example:

```
% cat ~/.profile
[..snip..]
LARAVEL=/home/username/.composer/vendor
PATH=$PATH:$LARAVEL/bin
```

And source your .profile with `% source ~/.profile`

After cloning the project with a simple `git clone https://github.com/scify/Benefile.git`, type `cd Benefile && composer install` to install all dependencies.

### Apache configuration:

```
% cat /etc/apache2/sites-available/mysite.conf
<VirtualHost *:80>
	ServerName myapp.example.com
	DocumentRoot "/path/to/Benefile/public"
	<Directory "/path/to/Benefile/public">
		AllowOverride all
	</Directory>
</VirtualHost>
```

Make the symbolic link:

`% cd /etc/apache2/sites-enabled && sudo ln -s ../sites-available/mysite.conf`

Enable mod_rewrite and restart apache:

`% sudo a2enmod rewrite && sudo service apache2 restart`

Fix permissions for storage directory:

`% chown -R www-data /path/to/Benefile/storage && chown -R www-data /path/to/Benefile/public`

or

`% find . type -d -exec chmod 775 {} \; && find . -type f -exec chmod 664 {} \; && chown -R :www-data /path/to/Benefile/Storage && chown -R :www-data /path/to/Benefile/public`

The above, changes the group ownership of public and storage directories to www-data, and `find` command changes permissions from 755 to 775 for directories and from 644 to 664 for files. This way, your web server user should be able to have write access with some sane security.

Test your setup with:

`% php artisan serve`

and navigate to localhost:8000.


### Nginx configuration:

Add additional the additional dependencies needed:

`% sudo aptitude install nginx php5-fpm`

Disable cgi.fix_pathinfo at /etc/php5/fpm/php.ini: `cgi.fix_pathinfo=0`

`% sudo php5enmod mcrypt && sudo service php5-fpm restart`

Nginx server block:

```
server {
    listen 80 default_server;
    listen [::]:80 default_server ipv6only=on;

    root /path/to/Benefile/public;
    index index.php index.html index.htm;

    server_name server_domain_or_IP;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        try_files $uri /index.php =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php5-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

`% sudo service nginx restart`

For persmissions, you may look above.

And finally, set the user appropriately:

`% sudo chown -R www-data storage`

*database instructions placeholder*

Initialize the database with `php artisan migrate` and test the installation with `php artisan serve` and hit `localhost:8000/auth/register` at your browser of choice.

Staging environment could be found here: http://benefile-project.scify.org/
