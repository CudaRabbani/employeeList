# Employee List

## About Employee List
- Simple RESTApi for CRUD operation
- No local database is used
- All the employees are stored in the `employees.json` file located in `storage/app/public` directory
- The `employee.json` is generated at once with 20 employees
- Faker is used for the generating employees


### Future Work

- Move the data storage from file system to actual database
- Seed the database from our current employee list resided in the `employee.json` file
- There are many ways to switch the storage system:
    - We can create a service that will read the existing employee list and write them into the database table
    - We can also use mysql dump to read the data from the file and write them into database table (formatting on the existing file may require some changes)

- Add user input validation
- Add user authentication to perform certain task
- Add testing

### How to Run
- From terminal enter the following commands:
    - `git clone git@github.com:CudaRabbani/employeeList.git`
    - `cd employeeList`
    - `composer install`
    - `php artisan serve`
* Please note the url of the laravel server started
  
### End points
- To list all the employees: (GET request)
```http://<your_url>/api/employee```
- To see specific Employee: (GET request)
  ```http://<your_url>/api/employee/{employeeId}```
- To create any new employee: (POST request)
  ```http://<your_url>/api/employee/```
- To update any existing employee: (PUT request)
  ```http://<your_url>/api/employee/{employeeId}```
- To delete any existing employee: (DELETE request)
  ```http://<your_url>/api/employee/{employeeId}```
  
** Please update <your_url> with the url that you will be receiving from the terminal while running `php artisan serve`
