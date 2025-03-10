# Reverse 1.0

## Project Overview
Reverse 1.0 is a Symfony-based example demonstrating how to generate entities from an existing database and recreate relationships using Doctrine ORM.

## Features
- Entity generation from an existing database
- Automatic recreation of relationships and foreign key constraints
- Database migrations with Doctrine

## Installation

### Prerequisites
Ensure you have the following installed on your system:
- PHP 8.1+
- Composer
- Symfony CLI
- MySQL or any Doctrine-supported database

### Clone the Repository
```sh
 git clone https://github.com/LindaOuer/reverse1.0.git
 cd reverse1.0
```

### Install Dependencies
```sh
composer install
```

### Configure Environment Variables
Open `.env` and update the database configuration:
```sh
DATABASE_URL="mysql://username:password@127.0.0.1:3306/db_name"
```

## Recreating Entities from an Existing Database
To generate entities and recreate relationships, follow these steps:

1. Create a custom Symfony command:
   ```sh
   symfony console make:command app:generate:entities
   ```
2. Implement the logic to scan the database schema and generate Doctrine entities.
3. Run the command to generate the entities:
   ```sh
   symfony console app:generate:entities
   ```

### Database Setup
Run the following commands to set up the database:
```sh
symfony console doctrine:database:create
symfony console doctrine:migrations:migrate
```

## Usage
### Run the Symfony Server
```sh
symfony server:start
```
The application should be accessible at `http://127.0.0.1:8000`

## Dropping Foreign Keys Before Migration
To avoid migration errors due to foreign key constraints, run:
```sh
symfony console app:drop-foreign-keys
```
Then generate and apply migrations:
```sh
symfony console doctrine:migrations:diff
symfony console doctrine:migrations:migrate
```


## Contributing
1. Fork the repository
2. Create a feature branch (`git checkout -b feature-xyz`)
3. Commit your changes (`git commit -m 'Add feature XYZ'`)
4. Push to the branch (`git push origin feature-xyz`)
5. Open a pull request

