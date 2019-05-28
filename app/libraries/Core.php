<?php
  /**
   * App core
   * Creates url and loads core controller
   * url format - /controller/method/params
   */
  class Core {
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct() {
      // print_r($this->getUrl());
      $url = $this->getUrl();

      // Look in controllers for first index of $url
      if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
        $this->currentController = ucwords($url[0]);
        // Unset [0]
        unset($url[0]);
      }

      // Require the controller
      require_once "../app/controllers/{$this->currentController}.php";
      $this->currentController = new $this->currentController;

      // Check for [1] second part of url
      if (isset($url[1])) {
        // Check if method exists in $currentController
        if(method_exists($this->currentController, $url[1])) {
          $this->currentMethod = $url[1];
          unset($url[1]);
        }
      }

      // Get params
      $this->params = $url ? array_values($url) : [];
      call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl() {
      if (isset($_GET['url'])) {
        $url = rtrim($_GET['url'], '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);
        return $url;
      }
    }
  }