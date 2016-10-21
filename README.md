# SweetTime!
A Web-Based Time Tracking System

Welcome to SweetTime! a web-based time tracking system especially tailored for tax preparation firms. This README provides essential information about using the system to manage Employee profiles, Time Cards, and the reports available to SweetTime! administrators.

See SweetTime! in action at [troyhscott.com](http://www.troyhscott.com/SweetTime/login.php). 

## Time Tracking Essentials

Employees use SweetTime! to track the time spent on a work task:

* Time Record Keeping - You can track time spent each day of the pay period on tax preparation (Tax) or education (Edu) tasks. Time In/Out events are constrained to 15 minute increments.

* Time Card View - Time Cards provide a summary of the total working hours with subtotals for Tax and Edu tasks. Regular and overtime hours are automatically accumulated for each Tax or Edu task. Time Cards are organized as two week pay periods with 14 days of Time Records. The system automatically prevents creation of Time Cards that have overlapping pay periods.

## Administration Essentials

SweetTime! provides the following major features for administration of the time tracking system:

* Secure Access - Employees and administrators access the system using email and password credentials.

* Employee Management - You can add, edit, or delete employee profiles. Each profile includes essential information like name and e-mail address as well as an optional administration flag that gives an employee more control over the SweetTime! system.

* Time Card Management - You can add, edit, or delete Time Cards. Time Cards provide a summary of the working hours of each employee and what tasks they performed. Time Cards are organized as two week pay periods with 14 days of Time Records.

* Time Record Management - You can add, edit, or delete the individual Time Records that are associated with a Time Card. This is an advanced management feature that is rarely used.
SweetTime! is written with the MySQL and PHP for easy deployment to in-house or cloud servers.

## Quick Start

| **Step** | **Description** |
|----------|-----------------|
|  1.  | Clone the sweettime repository |
|  2.  | Create a MySQL database user with the following privileges: DELETE, INSERT, SELECT, and UPDATE |
|  3.  | Create a MySQL database using the sweettime.sql file as a guideline. Two default Employee profiles with log in credentials to get you started. See the log in / password details in login.php. |
|  4.  | Place the PHP sweettime files in your server directory (usually /var/www/html/SweetTime on a local LAMP server or public_html/SweetTime of a remote server). Place db_connect.php file two directories above the public directory (usually /var/www/ on a local LAMP server or /home/user of a remote server).  |
|  5.  | Modify db_connect.php to use the database user credentials required for your web server |
|  6.  | Open login.php with your web browser |

## Compatibility
* PHP - 5.5
* MySQL - 5.5.52-MariaDB

## File Organization
### Time Cards
1. timecard_delete.php - Remove the specified Time Card and related Time Records
2. timecard_insert_process.php - Add a Time Card for a new pay period
3. timecard_update.php - UI to edit the Time Records of a specific Time Card
4. timecard_update_process.php - Update the Time Records
5. timecard_view.php - UI view lists Time Cards related to a specific Employee. Default page after log in.
6. timerec_view.php - UI view of a Time Card and related Time Records for a specific pay period

### Employee Administration
1. emp_delete.php - Deletes an Employee profile
2. emp_insert_process.php - Inserts a new Employee profile
3. emp_update.php - UI view to edit the Employee profile
4. emp_update_process.php - Update an Employee profile
5. emp_view.php - UI view list of Employee profiles

### Time Card Administration
1. report_payperiod.php - UI view list of all Time Cards for a particular pay period
2. report_payperiod_csv.php - Generate a CSV export file of the pay period report
3. report_timecards.php - UI view list of all Time Cards
4. report_timecard_delete.php - Delete a Time Card

### Time Record Administration
1. report_timerecs.php - UI view list of all Time Records
2. report_timerec_delete_range.php - Delete all Time Records related to a particular pay period start date

### Utility
1. db_connect.php - database access
2. home.php - landing page for the Administration area
3. login.php - log in page
4. logincheck.php - confirm that log in credentials are satisfied
5. login_process.php - validate log in credentials
6. logout_process.php - log out process
7. mobile_navbar.js - JS for a responsive nav bar
8. prog_scroll.js - JS for progressive scroll
9. sweettime.css - a few styles 
10. sweettime.sql - MySQL tables with default Employee profiles and sample data
