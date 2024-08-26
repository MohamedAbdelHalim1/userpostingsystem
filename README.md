User Posting System:
Very quick overview about what i did
The User Posting System is a Laravel blog application that allows users to register, log in, create posts, and add comments. The application also includes email notifications for post authors when new comments are made on their posts. API endpoints are available for advanced testing, and unit testing has been implemented using a separate MySQL database.

Features i have been used:
User Authentication: Registration, login, and route protection using Laravel Breeze.
CRUD Operations: Users can create, read, update, and delete their own posts and comments.
Email Notifications: Post authors receive email notifications when a new comment is added using MailGun.
API Documentation: API endpoints for posts and comments are documented using apidoc.
Unit Testing: Unit tests are written for main functionalities, using a separate MySQL testing database.

Setup Instructions:
1. Clone the Repository
   open Your Terminal and write following:
     git clone git@github.com:yourusername/userpostingsystem.git
     cd userpostingsystem
2. Install Dependencies
   composer install (for vendor)
   npm install (for node_modules)
   npm run build
3. Generate Application Key
    php artisan key:generate
4.Run Migrations
    php artisan migrate
5.php artisan serve
-----------------------------------------------------------
Access Features
1.The API documentation is generated using apidoc. To view the documentation:
**npm run apidoc
then write this url 
http://127.0.0.1:8000/docs/index.html
2.Unit Testing
Unit tests are set up using PHPUnit with a separate MySQL testing database.
**php artisan test
  "You should see -> Tests:    36 passed (96 assertions)"
   


   
