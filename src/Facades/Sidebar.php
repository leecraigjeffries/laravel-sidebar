<?php

    namespace LeeCraigJeffries\Sidebar\Facades;

    use Illuminate\Support\Facades\Facade;
    use LeeCraigJeffries\Sidebar\SidebarManager;

    class Sidebar extends Facade
    {

        /**
         * Get the registered name of the component.
         *
         * @return string
         */
        protected static function getFacadeAccessor(): string
        {
            return SidebarManager::class;
        }
    }