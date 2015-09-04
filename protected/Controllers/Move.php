<?php

namespace App\Controllers;

use App\Models\PPP\Consignment;
use App\Models\PPP\Place;
use T4\Mvc\Controller;
use App\Models\PPP\Move as Model;

/**
 * Class Move
 * @package App\Controllers
 */
class Move
    extends Controller
{
    public function actionToStock()
    {
        $post = $this->app->request->post;

        if ($post->count()) {
            try {
                $move = new Model();
                $move->fill($post);
                $move->save();
                $this->app->flash->message = 'Запись #' . $move->__id . ' успешно добавлена';
                $this->redirect('/report/main');
            } catch (\Exception $e) {
                $this->data->error = $e->getMessage();
            }
        }

        $this->data->consignments = Consignment::findAll();
        $this->data->places = Place::findAllByColumn('__stock_id', '1');
    }
}