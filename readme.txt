=== API Calling Test pllugin - ===
Plugin Name: API Calling - API Calling Plugin for WordPress
Contributors: Test Task
Requires at least: 4.6
Tested up to: 5.3.2
Requires PHP: 5.6

This is the test plugin for API. We will call API from our system and fetch data and show in table form.

== Description ==
= API Calling Plugin  =

We have covered following points in this plugin. 

1: API END : http://api.strategy11.com/wp-json/challenge/v1/1  
2: Calls the above endpoint to get the data and show in table form.
3: Data will get only 1 time in 1 hour. If user already fetch data from end point and again click on the get data button. then they get alert message.
4: User can get data from CLI as well. Required to install CLI on server. 

Follow the link that help to use and run CLI command - https://make.wordpress.org/cli/handbook/plugin-unit-tests/#running-tests-locally

5: Have created 3 test cases in this test plugin we are the commands. 

1: For add option : wp addAPICallingData --path=PATH_OF_WORDPRESS_FOLDER
2: For update option : wp updateApiCallingData --path=PATH_OF_WORDPRESS_FOLDER
3: For delete option : wp removeAPICallingData --path=PATH_OF_WORDPRESS_FOLDER

= Plugin Short Code =
= [APICalling] =

== Installation ==
1: Unzip apicalling plugin.
2: Copy plugin folder that is "apicalling" and paste on the wordpress plugin folder. (WPFOLDER/wp-content/plugins/)
3. Go to the Plugins -> 'Add New' page in your WP admin area 
4. Search API Calling plugin and Click the 'Active Now' link/button
5: After active api calling plugin you can see in sidebar menu of plugin that is "API Calling".

= NOTE =

Admin page CSS is based on formidable plugin. So please install formidable plugin too.

 
