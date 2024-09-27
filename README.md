
## Installation
👉 To install this application first of all you need to have PHP 8.0.0 or higher installed on your machine. You can download the latest version of PHP from the official PHP resource: https://www.php.net/downloads.php . <br>
👉 And MySQL 8.0.33 or higher installed on your machine. You can download the latest version of MySQL from the official MySQL resource: https://dev.mysql.com/downloads/mysql/ .

- First of all you need to clone this repository to your local machine:
  ```git clone```
- Then you need to create a database and a user for this application. You can do this by running the following commands:
```shell
mysql -u root -p
CREATE DATABASE short_url;
CREATE USER 'short_url'@'localhost' IDENTIFIED BY 'short_url';
GRANT ALL PRIVILEGES ON notes.* TO 'short_url'@'localhost';
FLUSH PRIVILEGES;
```

Or you can do this using the PHPMyAdmin interface like xamp or wamp or other local server.:

- Then you need to create a .env file in the root directory of the application and copy the contents of the .env.example file into it. Then you need to change the following lines in the .env file:
```dotenv
DB_DATABASE=short_url
DB_USERNAME=short_url
DB_PASSWORD=password
```

To install necessary dependencies, run the following command:
```shell
composer install
npm install
npm run dev
npm run build
```


By default, the application will be available at http://localhost:8000/ .

After this you can use the application 😁 .


