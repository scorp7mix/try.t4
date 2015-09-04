<?php

namespace App\Controllers;

use T4\Mvc\Controller;
use App\Models\PPP\Paint as Model;

/**
 * Class Paint
 * @package App\Controllers
 */
class Paint
    extends Controller
{
    public function actionIndex()
    {
        $this->data->paints = Model::findAll();
        $this->data->success = $this->app->flash->message;
    }

    public function actionNew()
    {
        $post = $this->app->request->post;

        if ($post->count()) {
            try {
                $paint = new Model();
                $paint->fill($post);
                $paint->save();
                $this->app->flash->message = 'Запись #' . $paint->__id . ' успешно добавлена';
                $this->redirect('/paint/index');
            } catch (\Exception $e) {
                $this->data->error = $e->getMessage();
            }
        }
    }

    public function actionEdit($id)
    {
        $paint = Model::findByPK($id);
        $post = $this->app->request->post;

        if ($post->count()) {
            try {
                $paint->fill($post);
                $paint->save();
                $this->app->flash->message = 'Запись #' . $id . ' успешно изменена';
                $this->redirect('/paint/index');
            } catch (\Exception $e) {
                $this->data->error = $e->getMessage();
            }
        }

        $this->data->paint = $paint;
    }

    public function actionDelete($id)
    {
        $paint = Model::findByPK($id);

        try {
            $paint->delete();
            $this->app->flash->message = 'Запись #' . $id . ' успешно удалена';
            $this->redirect('/paint/index');
        } catch (\Exception $e) {
            $this->data->error = $e->getMessage();
        }
    }
}
