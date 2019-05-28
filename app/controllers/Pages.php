<?php
class Pages extends Controller
{
  public function __construct()
  { }

  public function index()
  {

    $data = ['title' => 'Shareposts', 'description' => 'Simple social network build on the VibarMVC PHP framework'];

    $this->view('pages/index', $data);
  }

  public function about()
  {
    $data = ['title' => 'About', 'description' => 'App to share posts with other users'];
    $this->view('pages/about', $data);
  }
}
