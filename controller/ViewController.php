<?php

namespace controller;

class ViewController
{
    /**
     * @param $view
     */
    public function viewRouter($view)
    {
        include_once "view/$view.php";
    }
}