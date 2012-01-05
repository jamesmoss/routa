# Routa

A RESTful, flexible MVC router component for PHP 5.3+.  Declare rules which route HTTP requests to a controller.

## Do we need another router?

There's loads of router components so why do we need another? Many of the existing   ones are tightly coupled, poorly written. Routa is built with the following in mind:

- RESTful
- Loosely coupled
- Inspired by Ruby on Rails
- Compatible with PHP >= 5.3
- Prefers convention over configuration
- Flexible and extendable
- Automated test suite

## Installation

Routa adheres to the [PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md) spec. If you have a compatible autoloader place the contents of `lib` in your vendor directory.

## Basic usage

Within your code create a new instance of the router class. 

    $router = new JamesMoss\Routa\Router;

This approach automatically uses the current page URL and HTTP method from the $_SERVER super global, it's possible to override this which we'll cover later.

Next add some routes to map URLs to controller names/actions:

    $router
        ->add('/login', 'Account#login')
        ->add('/profile/:id', 'User#view')
        ->add('/profile/:id/edit', 'User#edit')
        ->add('/search/*', 'Products#search');

Once all your routes have been declared match your request against them.

    if($result = $router->match()) {
        // Assuming the url is /profile/432
        var_dump($result->controller); // returns 'User'
        var_dump($result->action); // returns 'view'
        var_dump($result->params); // returns ['id' => 432]
        // Load your controller… 
    } else {
        // Display your 404 page.
    }



