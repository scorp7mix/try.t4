<?php

namespace App\Controllers;

use App\Models\PPP\Move;
use T4\Mvc\Controller;
use App\Models\PPP\Report as Model;

class Report
    extends Controller
{
    public function actionMain()
    {
        $this->data->success = $this->app->flash->success;

        $this->data->moves = Move::findAll();
    }

    public function actionPaints()
    {
        $data = Move::findAll();

        $data = $data->collect(
            function (Move $x) {
                return [
                    'col1' => $x->consignment->paint->name,
                    'col2' => empty($x->place_from) ? $x->place_to->stock->name : $x->place_from->stock->name,
                    'col3' => empty($x->place_from) ? $x->place_to->name : $x->place_from->name,
                    'qty' => empty($x->qty_from) ? (int) $x->qty_to : -$x->qty_from,
                ];
            }
        );

        $this->data->result = Model::getResults($data);
    }

    public function actionConsignments()
    {
        $data = Move::findAll();

        $data = $data->collect(
            function (Move $x) {
                return [
                    'col1' => $x->consignment->name,
                    'col2' => empty($x->place_from) ? $x->place_to->stock->name : $x->place_from->stock->name,
                    'col3' => empty($x->place_from) ? $x->place_to->name : $x->place_from->name,
                    'qty' => empty($x->qty_from) ? (int) $x->qty_to : -$x->qty_from,
                ];
            }
        );

        $this->data->result = Model::getResults($data);
    }

    public function actionStocks()
    {
        $data = Move::findAll();

        $data = $data->collect(
            function (Move $x) {
                return [
                    'col1' => empty($x->place_from) ? $x->place_to->stock->name : $x->place_from->stock->name,
                    'col2' => empty($x->place_from) ? $x->place_to->name : $x->place_from->name,
                    'col3' => $x->consignment->paint->name,
                    'qty' => empty($x->qty_from) ? (int) $x->qty_to : -$x->qty_from,
                ];
            }
        );

        $this->data->result = Model::getResults($data);
    }

    public function actionToStock()
    {
        $data = Move::findAllByColumn('__type_id', 1);

        $this->data->moves = $data;
    }

    public function actionWorkshopTo()
    {
        $data = Move::findAllByColumn('__type_id', 4);

        $this->data->moves = $data;
    }
}
