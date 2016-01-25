<?php

namespace App\Http;

use Illuminate\Session\Store as Session;

class Flash{

    protected $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function message($message, $title=null, $level='info'){
        $this->session->flash('flash_notification', [
            'message' => $message,
            'title'   => $title,
            'level'   => $level
        ]);
    }

    public function info($message, $title=null){
        $this->message($message, $title, 'info');
    }

    public function success($message, $title=null){
        $this->message($message, $title, 'success');
    }

    public function error($message, $title=null){
        $this->message($message, $title, 'error');
    }

    public function warning($message, $title=null){
        $this->message($message, $title, 'warning');
    }

}