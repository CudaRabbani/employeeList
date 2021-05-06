# Employee List

## About Employee List
- Simple RESTApi for CRUD operation
- No local database is used
- All the employees are stored in the `employees.json` file located in `storage/app/public` directory
- The `employee.json` is generated at once with 20 employees
- Faker is used for the generating employees


### Future Work

- Move the data storage from file system to actual database
- We can also seed the database from our current employee list resided in the `employee.json` file
    - There are many ways to switch the storage system:
        - We can create a service that will read the existing employee list and write them into the database table
        - We can also use mysql dump to read the data from the file and write them into database table (formatting on the existing file may require some changes)

- Add user input validation
- Add user authentication to perform certain task
- Add testing

### How to Run
- From terminal enter the following commands:
``
