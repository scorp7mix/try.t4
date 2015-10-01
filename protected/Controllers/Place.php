<?php

namespace App\Controllers;

use App\Models\PPP\Stock;
use T4\Mvc\Controller;
use App\Models\PPP\Place as Model;

/**
 * Class Place
 * @package App\Controllers
 */
class Place
    extends Controller
{
    public function actionIndex()
    {
        $this->data->places = Model::findAll([
            'order' => 'name'
        ]);
        $this->data->success = $this->app->flash->success;
        $this->data->error = $this->app->flash->error;
    }

    public function actionNew()
    {
        $post = $this->app->request->post;

        if ($post->count()) {
            try {
                $place = new Model();
                $place->fill($post);
                $place->save();
                $this->app->flash->success = 'Запись #' . $place->__id . ' успешно добавлена';
                $this->redirect('/place/index');
            } catch (\Exception $e) {
                $this->data->error = $e->getMessage();
            }
        }

        $this->data->stocks = Stock::findAll();
    }

    public function actionEdit($id)
    {
        $place = Model::findByPK($id);
        $post = $this->app->request->post;

        if ($post->count()) {
            try {
                $place->fill($post);
                $place->save();
                $this->app->flash->success = 'Запись #' . $id . ' успешно изменена';
                $this->redirect('/place/index');
            } catch (\Exception $e) {
                $this->data->error = $e->getMessage();
            }
        }

        $this->data->stocks = Stock::findAll();
        $this->data->place = $place;
    }

    public function actionDelete($id)
    {
        $place = Model::findByPK($id);

        try {
            $place->delete();
            $this->app->flash->success = 'Запись #' . $id . ' успешно удалена';
            $this->redirect('/place/index');
        } catch (\Exception $e) {
            $this->app->flash->error = $e->getMessage();
        }
    }
}