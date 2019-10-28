<?php
//    dd('here gbh');
    return [
        /*
        |--------------------------------------------------------------------------
        | View Name
        |--------------------------------------------------------------------------
        |
        | Choose a view to display when Breadcrumbs::render() is called.
        | Built in templates are:
        |
        | - 'sidebar::bootstrap4'  - Bootstrap 4
        | - 'sidebar::bootstrap3'  - Bootstrap 3
        | - 'sidebar::bootstrap2'  - Bootstrap 2
        | - 'sidebar::bulma'       - Bulma
        | - 'sidebar::foundation6' - Foundation 6
        | - 'sidebar::materialize' - Materialize
        | - 'sidebar::uikit'       - UIkit
        | - 'sidebar::json-ld'     - JSON-LD Structured Data
        |
        | Or a custom view, e.g. '_partials/sidebar'.
        |
        */
        'view' => 'sidebar::default',
        /*
        |--------------------------------------------------------------------------
        | Breadcrumbs File(s)
        |--------------------------------------------------------------------------
        |
        | The file(s) where sidebar are defined. e.g.
        |
        | - base_path('routes/sidebar.php')
        | - glob(base_path('sidebar/*.php'))
        |
        */
        'files' => base_path('routes/sidebar.php')

    ];