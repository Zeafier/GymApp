# Welcome to Gym App

This application has been designed for school assignment purpose. It was one of the first project for web application development and website is not fully responsive. As it was my first school project, I was more focus onto learning of PHP and dynamic websites; thus, website might be lucking clean coding and proper management.

# Usage:

1. Prepare XAMPP (or WAMP)
2. Clone repository into xampp/htdocs folder
3. Run Apache and mySQL in Xampp console
4. Type in your browser localhost and select phpMyAdmin
5. Create new database called "_wellness_4_all_"
6. Add user in Privileges with access to this database called "HealthyStyle" with password "bkrPX66h9T73sFLi"
7. Lastly, open new tab and type localhost\(your folder name with cloned website)

When steps done correctly, website should work properly. Please see login detail below:

# User account details:

- User:
  - testuser@test.com
  - Test123!
- Admin:
  - adminuser@admin.com
  - Admin923@

Registering new users is working properly and new users can be added (not admins).

# Web elements and description:

- admin - pages for administrators to manage users and their's requests:
  - assests - styling and js folder for admin site pages
  - functions - PHP function called by admin website:
    - get-details.php - getting information about selected user through checking if id in HTML link is numeric in order to avoid any potential security risks. Then rendering information onto page which calling this function
    - manage-function.php - search for information about provided user in database and render it into page which calling this function
    - XSS.php - basic cleaning function which trims all input and strip any HTML tags
  - add-user - Page to add new users (either admin or user account)
  - change-password.php - page to change administrator password
  - checklogin.php - function checking if session for user already exists before accessing administrator pages
  - dbconnection.php - file which connecting all pages with database
  - logout.php - logout function which unsettling user's session and redirecting them to home page
  - make-booking.php - administrator booking page for existing users
  - manage-address.php - page to manage type in database postcode addresses
  - manage-bookings.php - manage user's bookings by finding them using manage-function.php file
  - manage-users.php - manage users page which allows to manage user information or remove them from database (including all information about bookings)
  - update-profile.php - update selected user's profile getting information from database using assigned id
  - user-booking.php - manage selected user's bookings
- checker: folder including login session and database connection functions (similar working as in admin folder)
- css - main styling folder
- fonts - fonts folder
- images - folder with web images
- js - main javascript folder
- _wellness_4_all_.sql - sql database which can be uploaded onto server (including basic account information and all of the tables with set relationships)
- action_page.php - email function for contact page (not working on localhost)
- Book.php - booking class/Trainer page for users
- Basic html pages (classes.html, contact.html, gym.html, home page: index.html)
- findavailable.php = page to search if selected class of trainer is still available for booking
- getValues.php - get information about selected booking and manage them (update or delete)
- manage.php - page for users to manage their's booking which using getValues.php file
- service.php - login page which include php functions for login, register and forger password
- update-password.php - page to update user's password
- welcome.php - home page for users
