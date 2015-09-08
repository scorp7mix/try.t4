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
                $move->__type_id = 1;
                $move->save();
                $this->app->flash->success = 'Запись #' . $move->__id . ' успешно добавлена';
                $this->redirect('/report/main');
            } catch (\Exception $e) {
                $this->data->error = $e->getMessage();
            }
        }

        $this->data->consignments = Consignment::findAll();
        $this->data->places = Place::findAllByColumn('__stock_id', '1');
    }

    public function actionStockToWorkshop()
    {
        $post = $this->app->request->post;
        $c_id = $this->app->request->get->c_id;

        if (isset($c_id)) {
            $this->data->places_from = Model::getPlaceRemains($c_id, 1);
            $this->data->c_id = $c_id;
        }

        if ($post->count()) {
            try {
                $move = new Model();
                $move->__consignment_id = $post->__consignment_id;
                $move->__place_from_id = $post->__place_from_id;
                $move->qty_from = $post->qty;
                $move->kr = $post->kr;
                $move->__type_id = 2;
                $move->save();
                $move = new Model();
                $move->__consignment_id = $post->__consignment_id;
                $move->__place_to_id = $post->__place_to_id;
                $move->qty_to = $post->qty;
                $move->kr = $post->kr;
                $move->__type_id = 2;
                $move->save();
                $this->app->flash->success = 'Запись #' . $move->__id . ' успешно добавлена';
                $this->redirect('/report/main');
            } catch (\Exception $e) {
                $this->data->error = $e->getMessage();
            }
        }

        $this->data->consignments = Model::getConsignmentRemains(1);
        $this->data->places_to = Place::findAllByColumn('__stock_id', '2');
    }

    public function actionWorkshopToStock()
    {
        $post = $this->app->request->post;
        $c_id = $this->app->request->get->c_id;

        if (isset($c_id)) {
            $this->data->places_from = Model::getPlaceRemains($c_id, 2);
            $this->data->c_id = $c_id;
        }

        if ($post->count()) {
            try {
                $move = new Model();
                $move->__consignment_id = $post->__consignment_id;
                $move->__place_from_id = $post->__place_from_id;
                $move->qty_from = $post->qty;
                $move->__type_id = 3;
                $move->save();
                $move = new Model();
                $move->__consignment_id = $post->__consignment_id;
                $move->__place_to_id = $post->__place_to_id;
                $move->qty_to = $post->qty;
                $move->__type_id = 3;
                $move->save();
                $this->app->flash->success = 'Запись #' . $move->__id . ' успешно добавлена';
                $this->redirect('/report/main');
            } catch (\Exception $e) {
                $this->data->error = $e->getMessage();
            }
        }

        $this->data->consignments = Model::getConsignmentRemains(2);
        $this->data->places_to = Place::findAllByColumn('__stock_id', '1');
    }

    public function actionWorkshopTo()
    {
        $post = $this->app->request->post;
        $c_id = $this->app->request->get->c_id;

        if (isset($c_id)) {
            $this->data->places = Model::getPlaceRemains($c_id, 2);
            $this->data->c_id = $c_id;
        }

        if ($post->count()) {
            try {
                $move = new Model();
                $move->fill($post);
                $move->__type_id = 4;
                $move->save();
                $this->app->flash->success = 'Запись #' . $move->__id . ' успешно добавлена';
                $this->redirect('/report/main');
            } catch (\Exception $e) {
                $this->data->error = $e->getMessage();
            }
        }

        $this->data->consignments = Model::getConsignmentRemains(2);
    }
}