<?php

    namespace LeeCraigJeffries\Sidebar;

    abstract class SidebarAbstract
    {
        /**
         * @var array
         */
        protected $links = [];

        /**
         * @var int
         */
        protected static $i = -1;

        /**
         * Add a new Link
         *
         * @param string $text
         * @param string|null $routeName
         * @param array|null $options
         * @param callable|null $callable
         * @return Link
         */
        public function push(string $text, ?string $routeName, ?array $options = [], ?callable $callable = null): Link
        {
            static::$i++;

            $newLink = $this->links[static::$i] = new Link($text, $routeName, $options);

            if (is_callable($callable)) {
                $callable($this->getLinks()[static::$i]);
            }

            return $newLink;
        }

        /**
         * Get Links
         *
         * @return array
         */
        public function getLinks(): array
        {
            return $this->links;
        }
    }