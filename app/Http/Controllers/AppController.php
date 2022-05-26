<?php


namespace App\Http\Controllers;


class AppController extends \Illuminate\Routing\Controller
{
    public function ping()
    {
        return 'ok';
    }
}