Steps to install Sample_Devices

1) Extract the zip file and place into htdocs or www folder as blow

	htdocs/sample_devices or www/sample_devices

2) Create database 'rconfig_api' and Run the rconfig_api.sql file in phpmyadmin database

3) If you have set mysql root password set the password in config.inc.php as below

	Open sample_devices/config/config.inc.php
	goto line 19 change the settings accordingly

	/* DATABASE DEFINES */
	define('DB_HOST', 'localhost');
	define('DB_PORT', '3306');
	define('DB_NAME', 'rconfig_api');
	define('DB_USER', 'root');
	define('DB_PASSWORD', 'yourpassword');

4) Open the broswer and access the url

	http://localhost/sample_devices/login.php

	sample username/password:
 
 username: johnse
 password: pass

 5) Open login.php file and goto line number 43

 		if you want to choose the city location as dropdown from the right-hand box top corner
 		change the form action parameter value into 'MyDashboardList.php'

		Ex: <form action="MyDashboardList.php" method="post">

 		if you want to choose the city accordian to view the switches list 
 		change the form action parameter value into 'MyDashboard.php'

 		ex: <form action="MyDashboard.php" method="post">
