<?php 
class CalendarController extends BaseController {
    public function index() {
        $this->view('calendars/calendar');
    }
}