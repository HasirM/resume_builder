Website Setup Documentation
Project: Resume Builder Website with MySQL Database
This document provides a step-by-step guide to setting up the Resume Builder website, which includes a MySQL database. The website files are provided in a zip file named resume_builder.zip. Follow the instructions below to successfully deploy the website.
________________________________________
Prerequisites
Before proceeding, ensure the following are installed and configured on your system:
1.	Web Server: Apache, Nginx, or any other web server.
2.	PHP: PHP 7.x or higher.
3.	MySQL: MySQL or MariaDB.
4.	phpMyAdmin (optional but recommended for database management).
5.	File Archiver: To extract the zip file (e.g., WinRAR, 7-Zip, or built-in OS tools).
________________________________________
Step 1: Extract the Project Files
1.	Locate the resume_builder.zip file on your system.
2.	Extract the contents of the zip file to your web server's root directory. For example:
o	Apache: htdocs or www directory.
3.	After extraction, you should see a folder named resume_builder containing the website files.
________________________________________
Step 2: Create a MySQL Database
1.	Open phpMyAdmin in your browser (usually accessible at  http://localhost/phpmyadmin).
2.	Log in using your MySQL credentials.
3.	Create a new database:
o	Click on the Databases tab.
o	Enter the database name as resume_builder.
o	Click Create.
4.	Import the SQL file:
o	Select the newly created resume_builder database from the left sidebar.
o	Click on the Import tab.
o	Click Choose File and select the resume_builder.sql file from the extracted project folder.
o	Click Go to import the SQL file.
________________________________________
Step 3: Update Database Credentials
1.	Navigate to the resume_builder folder in your web server directory.
2.	Locate the db.php file and open it in a text editor (e.g., Notepad++, VS Code, or any IDE).
3.	Update the database connection details with your system's MySQL credentials. For example:
Replace the values of $host, $database, $username, and $password with your actual database credentials.
4.	Save and close the db.php file.
________________________________________
Step 4: Serve the Website
1.	Start your web server (e.g., Apache or Nginx).
2.	Open a browser and navigate to the project directory. For example:
o	If the project is in the htdocs folder, visit http://localhost/resume_builder.
o	If the project is in the root directory, visit http://localhost.
3.	The index.php file will be served automatically, and the website should be up and running.
________________________________________
Step 5: Verify the Setup
1.	Browse through the website to ensure all pages are loading correctly.
2.	Test any forms or functionalities that interact with the database to confirm the database connection is working.
3.	If you encounter any errors, check the following:
o	Database credentials in db.php.
o	MySQL server status.
o	File permissions in the project directory.
________________________________________
Troubleshooting
Common Issues and Solutions
1.	Database Connection Error:
o	Ensure the database credentials in db.php are correct.
o	Verify that the MySQL server is running.
2.	File Not Found Error:
o	Ensure the project files are placed in the correct web server directory.
o	Check the URL path in the browser.
3.	SQL Import Error:
o	Ensure the resume_builder.sql file is not corrupted.
o	Verify that the database name matches in both the SQL file and phpMyAdmin.
________________________________________
Congratulations! You have successfully set up the Resume Builder website with a MySQL database. The website should now be fully functional and ready for use. If you encounter any further issues, refer to the troubleshooting section or consult your system administrator.
