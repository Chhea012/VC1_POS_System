<?php
require_once 'BaseController.php';
class WeatherController extends BaseController{
    function index(){
        $this -> view('weathers/weather');
    }
}