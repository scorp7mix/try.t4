<?php

namespace App\Controllers;

use App\Models\PPP\Move;
use T4\Mvc\Controller;

class Report
    extends Controller
{
    public function actionMain()
    {
        $this->data->success = $this->app->flash->success;

        $this->data->moves = Move::findAll();
    }
}
