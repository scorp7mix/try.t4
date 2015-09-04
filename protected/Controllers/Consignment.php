<?php

namespace App\Controllers;

use App\Models\PPP\Paint;
use T4\Mvc\Controller;
use App\Models\PPP\Consignment as Model;

/**
 * Class Consignment
 * @package App\Controllers
 */
class Consignment
    extends Controller
{
    public function actionIndex()
    {
        $this->data->consignments = Model::findAll();
        $this->data->success = $this->app->flash->message;
    }

    public function actionNew()
    {
        $post = $this->app->request->post;

        if ($post->count()) {
            try {
                $consignment = new Model();
                $consignment->fill($post);
                $consignment->save();
                $this->app->flash->message = 'Запись #' . $consignment->__id . ' успешно добавлена';
                $this->redirect('/consignment/index');
            } catch (\Exception $e) {
                $this->data->error = $e->getMessage();
            }
        }

        $this->data->paints = Paint::findAll();
    }

    public function actionEdit($id)
    {
        $consignment = Model::findByPK($id);
        $post = $this->app->request->post;

        if ($post->count()) {
            try {
                $consignment->fill($post);
                $consignment->save();
                $this->app->flash->message = 'Запись #' . $id . ' успешно изменена';
                $this->redirect('/consignment/index');
            } catch (\Exception $e) {
                $this->data->error = $e->getMessage();
            }
        }

        $this->data->paints = Paint::findAll();
        $this->data->consignment = $consignment;
    }

    public function actionDelete($id)
    {
        $consignment = Model::findByPK($id);

        try {
            $consignment->delete();
            $this->app->flash->message = 'Запись #' . $id . ' успешно удалена';
            $this->redirect('/consignment/index');
        } catch (\Exception $e) {
            $this->data->error = $e->getMessage();
        }
    }
}