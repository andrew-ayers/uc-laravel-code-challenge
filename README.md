## Setup

- Clone repository (do not fork).
- Copy .env.example to .env and configure database settings.
- Note: The default database name is "laravel". Verify that the database name is not already in use on your system before continuing. If it is being used, use a different name, and create a new database with that name.
- Download and install composer for the project (see https://getcomposer.org/download/)
- Then run the following command (see https://getcomposer.org/doc/01-basic-usage.md):
  ```
  php composer.phar update
  ```
- Run the following commands to get a functional and seeded application:
  ```
  php artisan key:generate
  php artisan migrate:fresh
  php artisan db:seed
  npm install
  npm run dev
  php artisan serve
  ```
- I found that during development, updates to the code wouldn't automagically be available. In that case, "CTRL-C" in the terminal running the server, then run the following string of commands instead:
  
  ```
  npm run dev; php artisan cache:clear; php artisan config:clear; php artisan view:clear; php artisan serve
  ```
- This clears out all the artisan caching then restarts the server. If you find that you need to reset or refresh the database tables, simply run:
  
  ```
  php artisan migrate:fresh; php artisan db:seed
  ```
- And the tables will be re-migrated and seeded with a new set of random data...

## Code Challenges

The objectives outlined below should be completed and any resulting code should follow the code style of the project and have doc-blocks where applicable.

- ~~Modify Owners table to include columns for number of addresses and cars associated with each owner.~~
- ~~Modify Addresses table to include concatenated owner name and number of cars associated with each address.~~
- ~~Modify Cars table to include concatenated owner name and address associated with each car.~~
- ~~Build simple and reusable view/edit Vue.js components for owners, addresses, and cars and link them to the action buttons in each table. The displayed data should include associated entities. (Addresses and cars for the owner. Owner and cars for the address. Owner and address for the car.)~~
- ~~Build a simple and reusable delete Vue.js component for owners, addresses, and cars. This should include a confirmation prompt.~~
- ~~Create a route for owners that uses the DB facade (not Eloquent) to return the average number of addresses and cars, respectively, per user and add a component that displays the information above the table on the owners page.~~
- ~~Create a route for addresses that uses the DB facade (not Eloquent) to return the average number of cars per address and add a component that displays the information above the table on the addresses page.~~

## Share Your Solution

-  Upon completion please create and share a git repository on a platform of your choice.