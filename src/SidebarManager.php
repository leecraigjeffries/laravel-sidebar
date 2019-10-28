<?php

    namespace LeeCraigJeffries\Sidebar;

    use Illuminate\View\View;
    use LeeCraigJeffries\Sidebar\Exceptions\DuplicateSidebar;

    class SidebarManager
    {
        protected $callbacks = [];
        protected $sidebars = [];
        protected $views = [];
        protected $activeId = -1;
        protected $activePath;
        protected $paths = [];
        protected $pathsOfParentsWithChildren = [];

        /**
         * Register a new Sidebar
         *
         * @param string $name
         * @param string $viewName Path to the view
         * @param callable|null $callback
         * @return Sidebar|null
         * @throws DuplicateSidebar
         */
        public function register(string $name, string $viewName, callable $callback = null): ?Sidebar
        {
            $this->setView($name, $viewName);

            if (isset($this->callbacks[$name])) {
                throw new DuplicateSidebar("Sidebar \"{$name}\" is already registered");
            }
            
            if ($callback) {
                $this->callbacks[$name] = $callback;
            } else {
                return $this->createSidebar($name);
            }

            return null;
        }

        /**
         * @param string $name
         * @return View
         * @throws DuplicateSidebar
         */
        public function render(string $name): View
        {
            $this->callbacks[$name]($this->sidebar($name));

            $this->getParentsAndChildren($this->sidebar($name)->getLinks());

            if ($this->activeId >= 0) {
                $this->generatePaths(array_keys($this->sidebar($name)->getLinks()));
                $this->setHasActiveChildren($this->sidebar($name));
            }

            return view($this->views[$name], ['links' => $this->sidebar($name)->getLinks()]);
        }

        /**
         * @param $name
         * @return array
         * @throws DuplicateSidebar
         */
        public function getSidebarLinks($name): array
        {
            $this->callbacks[$name]($this->sidebar($name));

            return $this->sidebar($name)->getLinks();
        }

        /**
         * @param array $links
         */
        private function getParentsAndChildren(array $links): void
        {
            foreach ($links as $key => $value) {
                if ($value->getActive()) {
                    $this->activeId = $key;
                }

                if (count($value->getLinks())) {
                    $this->paths[$key] = array_keys($value->getLinks());

                    $this->getParentsAndChildren($value->getLinks());
                }
            }
        }

        /**
         * @param $array
         * @param array $array2
         */
        private function generatePaths($array, $array2 = []): void
        {
            foreach ($array as $key => $value) {
                $temp = $array2;
                $temp[] = $value;
                $this->pathsOfParentsWithChildren[] = $temp;

                if ($value === $this->activeId) {
                    $this->activePath = $temp;
                    break;
                }

                if (isset($this->paths[$value])) {
                    $this->generatePaths($this->paths[$value], $temp);
                }
            }
        }

        /**
         * @param Sidebar $sidebar
         */
        private function setHasActiveChildren(Sidebar $sidebar): void
        {
            array_pop($this->activePath);

            foreach ($this->activePath as $id) {
                $sidebar->getLinks()[$id]->setHasActiveChild();
                $sidebar = $sidebar->getLinks()[$id];
            }
        }

        /**
         * @param string $name
         * @param string $viewName
         */
        public function setView(string $name, string $viewName): void
        {
            $this->views[$name] = $viewName;
        }

        /**
         * @param string $name
         * @return Sidebar
         * @throws DuplicateSidebar
         */
        public function createSidebar(string $name): Sidebar
        {
            if ($this->sidebarExists($name)) {
                throw new DuplicateSidebar("Sidebar named \"{$name}\" already exists");
            }

            $this->sidebars[$name] = new Sidebar($name);

            return $this->sidebars[$name];
        }

        /**
         * @param string $name
         * @return bool
         */
        public function sidebarExists(string $name): bool
        {
            return isset($this->sidebars[$name]);
        }

        /**
         * @param string $name
         * @return Sidebar
         * @throws DuplicateSidebar
         */
        public function sidebar(string $name): Sidebar
        {
            if (!$this->sidebarExists($name)) {
                $this->createSidebar($name);
            }

            return $this->sidebars[$name];
        }

    }