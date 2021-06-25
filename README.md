## About the Project

This is a simple website project named Idea Furniture, utilizing Laravel 7 and Bootstrap 5. 
For authentication, we used Laravel’s build in authentication service by accessing via the Auth facade, utilizing the laravel/ui package (version 2.4).

## Notes

* Please create a new .env file according to you
* Please perform migration and seeding with php artisan migrate:fresh –seed
* Please create storage link with php artisan storage:link
    All product type images are stored in thumbnail/ folder
    Product type images when stored are named in this format: timestamp_productTypeName.ext
    All product images are stored in a folder named after its product type
    Product type images when stored are named in this format: timestamp_productName.ext
* All users who registers through the register page will be automatically be registered as ‘member’ role. To add admin user(s), manually insert through SQL queries or from the UserSeeder
