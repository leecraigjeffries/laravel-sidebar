### 1. Install Laravel Sidebar

Run this at the command line:

```bash
composer require leecraigjeffries/laravel-sidebar
```

This will update `composer.json` and install the package into the `vendor/` directory.

### 2. Define your sidebars

Create a file called `routes/sidebar.php` that looks like this:

```php
<?php
    /// Parameters: sidebar name, path to view
    Sidebar::register('default', 'vendor.sidebar.default', static function ($sidebar) {
        
    // Text, name of route or href, extra properties
    $sidebar->push('Section', '#section', ['icon' => '<i class="far fa-flag"></i>'], static function ($group) {
            $group->push('Heading', '', null, static function ($heading) {
                $heading->push('Link', '#link', null, static function($link){
                
                // Links can be embedded endlessly    
                $link->push('Sub Link', '#welcome')->setActive();
                });
            });
        });
    });
```

### 3. Render your Sidebar in Blade View
```php
{!! Sidebar::render('default') !!}
```