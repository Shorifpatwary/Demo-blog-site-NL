# Demo Blog Site - Readme

This repository contains the source code for a Laravel-based demo blog site. Follow the instructions below to set up and run the website locally.

## Prerequisites

-   PHP (>= 7.4)
-   Composer
-   Node.js (>= 12.x)
-   NPM
-   MySQL (or any other supported database)

## Installation

1.  Clone the repository:

shellCopy code

`git clone <repository_url>`

Save to grepper

2.  Navigate to the project directory:

shellCopy code

`cd Demo-blog-site-NL/`

Save to grepper

3.  Create a new MySQL database for the application and update the `.env` file with your database credentials.
4.  Install the required PHP dependencies:

shellCopy code

`composer install`

Save to grepper

5.  Install the required NPM packages:

shellCopy code

`npm install`

Save to grepper

6.  Generate an application key:

shellCopy code

`php artisan key:generate`

Save to grepper

7.  Run the database migrations and seed the database:

shellCopy code

`php artisan migrate --seed`

Save to grepper

8.  Build the frontend assets using one of the following commands:

-   For production build:

shellCopy code

`npm run build`

Save to grepper

-   For development build:

shellCopy code

`npm run dev`

Save to grepper

9.  Start the Laravel development server:

shellCopy code

`php artisan serve`

Save to grepper

10. Create a Filament user (optional):

shellCopy code

`php artisan make:filament-user`

Save to grepper

Alternatively, you can create a user by visiting the `/register` URL of the site.

11. Access the login page:

-   Admin login: [http://127.0.0.1:8000/admin/login](http://127.0.0.1:8000/admin/login)
-   User login: [http://127.0.0.1:8000/login](http://127.0.0.1:8000/login)

If you encounter any issues during the installation process, please refer to the Laravel documentation or seek assistance from the Laravel community.

## Additional Instructions for Geeky Next.js Integration

If you wish to integrate the Geeky Next.js project with this Laravel site, follow the steps below:

1.  Navigate to the Next.js project directory:

shellCopy code

`cd geeky-nextjs-main/`

Save to grepper

2.  Install the required NPM packages:

shellCopy code

`npm install`

Save to grepper

3.  Run the Next.js development server:

shellCopy code

`npm run dev`

Save to grepper

Now you should have the Next.js site running alongside your Laravel site.

Please note that the Next.js integration is optional, and you can skip these steps if you don't want to integrate it.
