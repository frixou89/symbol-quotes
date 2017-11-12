# Symbol quotes

Get symbol quotes within a date range

DIRECTORY STRUCTURE
-------------------

      classes/			contains project classes
      functions/			contains project scripts
      public/			public folder. App should run from this directory
      vendor/			contains dependent 3rd-party packages
      views/			contains view files for the application


Installation
-------------------
1. Install dependencies with composer. From inside your project's root directory run:
	~~~
    composer install
    ~~~
2. Copy `.env.example` to `.env` and set variables according to you setup. Example:
	 ~~~
    #API url
    SYMBOLS_CSV_URL = http://www.nasdaq.com/screening/companies-by-name.aspx?&render=download

    #Database
    DB_NAME = daname
    DB_USER = root
    DB_PASS = 

    #Swiftmailer
    MAILER_HOST = localhost
    MAILER_USER = 
    MAILER_PASSWORD = 
    MAILER_EMAIL = test@localhost
    MAILER_NAME = "Symbols"
  	~~~

3. Create a database. Make sure the database name is identical to your `.env` file. `DB_NAME = daname`

4. There are two console commands the get you started. See `createdb` and `getSymbols` scripts inside the root directory.

    - `createdb` will create the database structure.
      ~~~
      php createdb
      ~~~
    
    - `getSymbols` will download the .csv file and save it to database. We need this for dynamically searching for symbols instead of loading the all at once and overloading DOM.
      ~~~
      php getSymbols
      ~~~
      
 5. Serve the application from inside the `/public` directory
     ~~~
     cd public/
     php -S localhost:8000
     ~~~
    
 6. The site can be now accessed at [localhost:8000](localhost:8000/)