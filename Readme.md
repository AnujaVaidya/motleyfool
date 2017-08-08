The Objective:


For this exercise, build and deploy a simple PHP web application
which:
- Converts prices of financial ticker symbols from US Dollars ( USD ) to Singapore
Dollars ( SGD )
- Rounds the amounts to the nearest one-hundredth.
- You should use real market currency exchange rates from this date range: July
24, 2017 – July 25, 2017

Steps:
1. I have used local XAMPP Server for this application.
2. The zipped folder contains the entire folder at htdocs. Running the index.php should give the home page
3. The requirements:

    1. Import and persist provided data. 
    Currently, for simplicity purpose, I have made another output csv file to save all the conversion instead of calling the API for each and every request. This can be further saved into something more secure and with authentication.

    2. Develop a web interface to display the price of ticker symbols in USD and SGD
    given any combination of ticker symbol and date. Users may request all ticker symbols or all dates. 

4. The output csv file is created once only.
5. As per the instructions, the csv file is imported and all prices are checked according to the date and type sleected for it.
6. Fixer.io APIs have been called based on that particular date


Bonus Points:
1. The table braks after 5 rows as per the requirements 
2. We dont need to refresh the page every time to see the results.