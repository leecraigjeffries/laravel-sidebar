### 1. Install Laravel Breadcrumbs

Run this at the command line:

```bash
composer require leecraigjeffries/laravel-sidebar
```

This will update `composer.json` and install the package into the `vendor/` directory.

### 2. Define your sidebars

Create a file called `routes/sidebar.php` that looks like this:

```php
<?php
    Sidebar::register('default', 'vendor.sidebar.default', static function ($sidebar) {
        $sidebar->push('Section', '#section', ['icon' => '<i class="far fa-flag"></i>'], static function ($group) {
            $group->push('Heading', '', null, static function ($heading) {
                $heading->push('Link', '#link', null, static function($link){
                    $link->push('Sub Link', '#welcome')->setActive();
                });
            });
        });
    });
```