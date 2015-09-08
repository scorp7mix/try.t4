<?php

namespace App\Models\PPP;

use T4\Core\Collection;
use T4\Orm\Model;

/**
 * Class Move
 * @package App\Models
 * @property \App\Models\PPP\Type $type
 * @property \App\Models\PPP\Consignment $consignment
 * @property \App\Models\PPP\Place $place_from
 * @property \App\Models\PPP\Place $place_to
 * @property int $qty_from
 * @property int $qty_to
 * @property int $qty_plan
 * @property string $kr
 * @property int $parts
 */
class Move
    extends Model
{

    protected static $schema = [
        'table' => 'moves',
        'columns' => [
            'qty_from' => ['type'=>'int'],
            'qty_to' => ['type'=>'int'],
            'qty_plan' => ['type'=>'int'],
            'kr' => ['type'=>'string'],
            'parts' => ['type'=>'int'],
        ],
        'relations' => [
            'type' => ['type' => self::BELONGS_TO, 'model' => Type::class],
            'consignment' => ['type' => self::BELONGS_TO, 'model' => Consignment::class],
            'place_from' => ['type' => self::BELONGS_TO, 'model' => Place::class, 'by' => '__place_from_id'],
            'place_to' => ['type' => self::BELONGS_TO, 'model' => Place::class, 'by' => '__place_to_id'],
        ]
    ];

    public static function getConsignmentRemains($stock_id)
    {
        $moves = static::findAll();
        $data = [];

        foreach ($moves as $move) {
            $place = empty($move->place_from) ? $move->place_to : $move->place_from;
            if ($stock_id == $place->__stock_id) {
                if (isset($data[$move->consignment->__id])) {
                    $data[$move->consignment->__id]['qty'] += empty($move->qty_from) ? (int)$move->qty_to : -$move->qty_from;
                } else {
                    $data[$move->consignment->__id]['name'] = $move->consignment->name;
                    $data[$move->consignment->__id]['paint'] = $move->consignment->paint->name;
                    $data[$move->consignment->__id]['qty'] = empty($move->qty_from) ? (int)$move->qty_to : -$move->qty_from;
                }
            }
        }

        foreach ($data as $k => $v) {
            if ($v['qty'] <= 0) {
                unset($data[$k]);
            }
        }

        return $data;
    }

    public static function getPlaceRemains($consignment_id, $stock_id)
    {
        $moves = static::findAllByColumn('__consignment_id', $consignment_id);
        $data = [];

        foreach ($moves as $move) {
            $place = empty($move->place_from) ? $move->place_to : $move->place_from;
            if ($stock_id == $place->__stock_id) {
                if (isset($data[$place->__id])) {
                    $data[$place->__id]['qty'] += empty($move->qty_from) ? (int)$move->qty_to : -$move->qty_from;
                } else {
                    $data[$place->__id]['name'] = $place->name;
                    $data[$place->__id]['qty'] = empty($move->qty_from) ? (int)$move->qty_to : -$move->qty_from;
                }
            }
        }

        foreach ($data as $k => $v) {
            if ($v['qty'] <= 0) {
                unset($data[$k]);
            }
        }

        return $data;
    }
}
