# IT490-Frontend

To deploy the website to your machine, clone the repository into /var/www/frontend/

Copy the contents of sites-available/ to /etc/apache2/sites-available/

Navigate to /etc/apachee2/sites-enabled/

Create a symbolic link: "ln -s ../sites-available/001-stocks.conf ."

Open /etc/hosts in your favorite text editor

Add a new entry at the top: "127.0.0.1 www.stocks.am"

Restart the apache2 service
