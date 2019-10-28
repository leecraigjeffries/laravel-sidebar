<?php

    namespace LeeCraigJeffries\Sidebar;

    use Illuminate\Contracts\Container\BindingResolutionException;
    use Illuminate\Support\ServiceProvider;

    class SidebarServiceProvider extends ServiceProvider
    {

        /**
         * @return bool
         */
        public function isDeferred(): bool
        {
            return true;
        }

        /**
         * Get the services provided for deferred loading.
         *
         * @return array
         */
        public function provides(): array
        {
            return [SidebarManager::class];
        }

        /**
         * Register the service provider.
         *
         * @return void
         */
        public function register(): void
        {
            // Load the default config values
            $configFile = __DIR__ . '/../config/sidebar.php';
            $this->mergeConfigFrom($configFile, 'sidebar');

            // Publish the config/sidebar.php file
            $this->publishes([
                $configFile => config_path('sidebar.php')
            ], 'sidebar-config');

            // Register 'sidebar::' view namespace
            $this->loadViewsFrom(__DIR__ . '/../views/', 'sidebar');

            $this->publishes([
                __DIR__ . '/../views' => resource_path('views/vendor/sidebar'),
                __DIR__ . '/../sass' => resource_path('sass/vendor/sidebar')
            ]);
        }

        /**
         * Bootstrap the application events.
         *
         * @return void
         * @throws BindingResolutionException
         */
        public function boot(): void
        {
            // Load the routes/sidebar.php file, or other configured file(s)
            $files = config('sidebar.files');
            if (!$files) {
                return;
            }

            // If it is set to the default value and that file doesn't exist, skip loading it rather than causing an error
            if ($files === base_path('routes/sidebar.php') && !is_file($files)) {
                return;
            }

            // Support both Sidebar:: and $sidebar-> syntax by making $sidebar variable available
            /** @noinspection PhpUnusedLocalVariableInspection */
            $sidebar = $this->app->make(SidebarManager::class);

            // Support both a single string filename and an array of filenames (e.g. returned by glob())
            foreach ((array)$files as $file) {
                /** @noinspection PhpIncludeInspection */
                require_once $file;
            }
        }
    }
