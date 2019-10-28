<?php

    namespace LeeCraigJeffries\Sidebar;

    use Route;

    class Link extends SidebarAbstract
    {
        /**
         * @var bool
         */
        protected $active = false;

        /**
         * @var bool
         */
        protected $hasActiveChild = false;

        /**
         * @var string
         */
        protected $text = '';

        /**
         * @var array|null
         */
        protected $props = [];

        /**
         * @var string
         */
        protected $uri = '';

        /**
         * Link constructor.
         *
         * @param string $text
         * @param string|null $routeNameOrUri
         * @param array|null $props
         */
        public function __construct(string $text, ?string $routeNameOrUri, ?array $props = [])
        {
            $this->text = $text;
            $this->uri = $this->getUriFromRouteName($routeNameOrUri);
            $this->props = $props;

            if (request()->route()->getName() === $routeNameOrUri) {
                $this->active = true;
            }
        }

        /**
         * @param string|null $routeNameOrUri
         *
         * @return string
         */
        private function getUriFromRouteName(?string $routeNameOrUri): string
        {
            if ($routeNameOrUri === null) {
                return '';
            }

            if (Route::getRoutes()->getByName($routeNameOrUri)) {
                return route($routeNameOrUri);
            }

            return $routeNameOrUri;
        }

        /**
         * @param string $name
         * @return string
         */
        public function getProp(string $name):string
        {
            return $this->props[$name];
        }

        /**
         * @return array|null
         */
        public function getProps(): ?array
        {
            return $this->props;
        }

        /**
         * @return string
         */
        public function getUri(): string
        {
            return $this->uri;
        }

        /**
         * @param string $uri
         *
         * @return Link
         */
        public function setUri(string $uri): self
        {
            $this->uri = $uri;

            return $this;
        }

        /**
         * Get Active status
         * @return bool
         */
        public function getActive(): bool
        {
            return $this->active;
        }

        /**
         * Set Active status
         *
         * @param bool $active
         *
         * @return Link
         */
        public function setActive(bool $active = true): self
        {
            $this->active = $active;

            return $this;
        }

        /**
         * Get Has Active Child status
         *
         * @return bool
         */
        public function getHasActiveChild(): bool
        {
            return $this->hasActiveChild;
        }

        /**
         * @param mixed $hasActiveChild
         *
         * @return self
         */
        public function setHasActiveChild(bool $hasActiveChild = true): self
        {
            $this->hasActiveChild = $hasActiveChild;

            return $this;
        }

        /**
         * @return string
         */
        public function getText(): string
        {
            return $this->text;
        }

        /**
         * @param string $text
         *
         * @return Link
         */
        public function setText(string $text): self
        {
            $this->text = $text;

            return $this;
        }
    }