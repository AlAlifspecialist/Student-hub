# Student Course Hub MVC

A full custom PHP MVC version of the Student Course Hub assignment.

## MVC structure
- `app/Controllers` → request handling
- `app/Models` → database logic
- `app/Views` → HTML rendering
- `config/routes.php` → route definitions
- `index.php` → front controller
- `.htaccess` → sends all routes to the front controller

## Features included
- Public programme listing with search and level filter
- Programme details page
- Modules grouped by year
- Programme leader and module leader display
- Register interest
- Manage/withdraw interest by email
- Admin login/logout
- Role-based access: `super_admin`, `editor`, `mailer`
- Manage programmes
- Manage modules
- Assign modules to programmes
- Publish/unpublish programmes
- View mailing list
- Export mailing list as CSV
- Prepared statements, CSRF protection, output escaping

## Default admin logins
- `admin` / `Admin123!`
- `editor` / `Editor123!`
- `mailer` / `Mailer123!`

## How to run in XAMPP
1. Put the folder in `C:\xampp\htdocs\student_course_hub_mvc`
2. Start Apache and MySQL
3. Import `sql/student_course_hub.sql` in phpMyAdmin
4. Open `config/config.php` and confirm DB settings
5. Visit `http://localhost/student_course_hub_mvc/`

## Important
This version uses Apache `.htaccess` routing. If URL rewriting is disabled on your setup, open the project through the folder root in XAMPP with Apache enabled.
