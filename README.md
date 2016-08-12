# Full Silex

Silex is a powerfull micro framework. Well, "micro" means you can create a small website within seconds. But sometimes you need to expand this framework into a full stack to moderate a bigger website. To make it happen at least you need to register several service providers, adding some functions in base controller, models, and many more.

Full Silex is the a fast track to build a full stack framework based on the amazing Silex Micro Framework. It contains several base classes such as Base Controller, Base Model, several Helpers, and many more.

## Installation

#### 1. Add full-stack as a required library in your composer project
```
composer require icemanbsi/full-stack
```

#### 2. Prepare the project
you can copy the project template from `/vendor/icemanbsi/full-silex/project-template` into your project root.

#### 3. Setting up the project
- Set your database configurations and others in `/resources/config/dev.php` (for development) and `/resources/config/prod.php` (for production).
- Inside the `src/App/Application.php` you need to override 'setControllerProviders' function. Please set your controller provider.
- Now we move to your controller provider (such as `src/App/DefaultControllerProvider.php`). You can set your url rules inside 'setUrlRules' function. Don't forget to add a rule for '/' and bind it with name 'homepage'.

#### 4. You are ready to go..
Add your controllers, models, template files, and others.


## Credits

1. Silex Framework
2. Database migration by Ruckus (ruckusing/ruckusing-migrations)