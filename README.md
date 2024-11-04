# Simple Todo List Application

This is a simple todo list application built with Laravel and Tailwind CSS. It uses SQLite for the database.

## Features

- Add new todo items with due dates.
- Mark todo items as complete or incomplete.
- Delete todo items.
- Edit existing todo items.
- User authentication (login/registration).

## Technologies Used

- Laravel
- Tailwind CSS
- SQLite
- PHP
- Git

## Prerequisites

- **PHP (version compatible with Laravel - check Laravel's requirements):** Download the appropriate version of PHP from [https://www.php.net/downloads.php](https://www.php.net/downloads.php). Follow the installation instructions for your operating system. After installation, ensure PHP is added to your system's PATH environment variable. You can verify the installation by opening your terminal and running `php -v`.

- **Composer:** Download the Composer installer from [https://getcomposer.org/download/](https://getcomposer.org/download/). Follow the instructions on the Composer website to install it. After installation, ensure Composer is added to your system's PATH environment variable. You can verify the installation by opening your terminal and running `composer -v`.

- **Git:** Download and install Git from [https://git-scm.com/downloads](https://git-scm.com/downloads). Follow the installation instructions for your operating system. After installation, you can verify the installation by opening your terminal and running `git --version`.


## Setup

1. **Clone the repository:**
   ```bash
   git clone [repository_url]
   ```

2. **Navigate to the project directory:**
   ```bash
   cd todo-list-laravel-with-auth
   ```

3. **Create a .env file:** Copy the `.env.example` file to `.env`:
   ```bash
   cp .env.example .env
   ```
   Then, update the `.env` file with your database credentials and other necessary configurations.

4. **Install project dependencies:**
   ```bash
   composer install
   ```

5. **Generate an application key:**
    ```bash
    php artisan key:generate
    ```

6. **Run database migrations:**
    ```bash
    php artisan migrate
    ```

7. **Start the development server:**
    ```bash
    php artisan serve
    ```

## Usage

1. Access the application in your browser at `http://127.0.0.1:8000`.
2. Log in or register an account.
3. Add, edit, complete, or delete todo items.