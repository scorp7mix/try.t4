<?php

namespace App\Controllers;

use App\Models\PPP\Consignment;
use App\Models\PPP\Place;
use App\Models\PPP\Move;
use T4\Mvc\Controller;
use App\Models\PPP\Remain as Model;

/**
 * Class Move
 * @package App\Controllers
 */
class Remain
    extends Controller
{
    public function actionIndex()
    {
        $remains = Model::findAll([
            'where' => 'qty <> 0'
        ]);

        $remains = $remains->sort(function($a, $b) {
            if ($a->place->stock->__id == $b->place->stock->__id) {
                return ($a->place->name > $b->place->name);
            } else {
                return ($a->place->stock->__id > $b->place->stock->__id);
            }
        });

        $post = $this->app->request->post;

        if ($post->count()) {
            Model::invent($post);
            $this->redirect('/remain/index');
        }

        $this->data->remains = $remains;
    }

    public function actionNew()
    {
        $post = $this->app->request->post;

        if ($post->count()) {
            try {
                $remain = new Model();
                $remain->fill($post);
                $remain->save();

                $move = new Move();
                $move->__type_id = 5;
                $move->__consignment_id = $post->__consignment_id;

                if ($post->qty > 0) {
                    $move->__place_to_id = $post->__place_id;
                    $move->qty_to = $post->qty;
                } else {
                    $move->__place_from_id = $post->__place_id;
                    $move->qty_from = -$post->qty;
                }

                $move->save();

                $this->app->flash->success = 'Запись #' . $remain->__id . ' успешно добавлена';
                $this->redirect('/remain/index');
            } catch (\Exception $e) {
                $this->data->error = $e->getMessage();
            }
        }

        $this->data->consignments = Consignment::findAll(['order' => 'name']);
        $this->data->places = Place::findAll(['order' => 'name']);
    }
}