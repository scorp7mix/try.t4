<?php

namespace App\Models\PPP;

use T4\Orm\Model;

/**
 * Class Remain
 * @package App\Models
 * @property \App\Models\PPP\Consignment $consignment
 * @property \App\Models\PPP\Place $place
 * @property int $qty
 */
class Remain
    extends Model
{

    protected static $schema = [
        'table' => 'remains',
        'columns' => [
            'qty' => ['type'=>'int'],
        ],
        'relations' => [
            'consignment' => ['type' => self::BELONGS_TO, 'model' => Consignment::class],
            'place' => ['type' => self::BELONGS_TO, 'model' => Place::class],
        ]
    ];

    public static function findByConsPlace($cons_id, $place_id)
    {
        return static::findByQuery('
                  SELECT *
                  FROM remains
                  WHERE
                    __consignment_id = ' . $cons_id . ' AND
                    __place_id = ' . $place_id
        );
    }

    public static  function saveWithCheck (Remain $remain, $post)
    {
        if (empty($remain)) {
            $remain = new static();
            $remain->__consignment_id = $post->__consignment_id;
            $remain->__place_id = $post->__place_to_id;
            $remain->qty = $post->qty;
            $remain->save();
        } else {
            $remain->qty += $post->qty;
            $remain->save();
        }
    }

    public static function saveWithoutCheck (Remain $remain, $post)
    {
        $remain->qty -= $post->qty;
        $remain->save();
    }

    public static function getConsignmentRemains($stock_id)
    {
        $remains = static::findAllByQuery('
            SELECT
              c.__id AS id,
              c.name AS name,
              p.name AS paint,
              SUM(r.qty) AS qty
            FROM
              remains AS r
            LEFT JOIN places AS pl ON pl.__id = r.__place_id
            LEFT JOIN consignments AS c ON c.__id = r.__consignment_id
            LEFT JOIN paints AS p ON p.__id = c.__paint_id
            WHERE
              pl.__stock_id = ' . $stock_id . ' AND
              qty <> 0
            GROUP BY name
            '
        );

        return $remains;
    }

    public static function getPlaceRemains($consignment_id, $stock_id)
    {
        $remains = static::findAllByQuery('
            SELECT
              pl.__id AS id,
              pl.name AS name,
              SUM(r.qty) AS qty
            FROM
              remains AS r
            LEFT JOIN places AS pl ON pl.__id = r.__place_id
            WHERE
              pl.__stock_id = ' . $stock_id . ' AND
              r.__consignment_id = ' . $consignment_id . ' AND
              qty <> 0
            GROUP BY name
            '
        );

        return $remains;
    }

    public static function invent($post)
    {
        foreach ($post as $k => $v) {
            $remain = static::findByPK($k);
            if ((int)$remain->qty != (int)$v) {
                $diff = $remain->qty - $v;

                $move = new Move();
                $move->__type_id = 5;
                $move->__consignment_id = $remain->__consignment_id;

                if ($diff > 0) {
                    $move->__place_from_id = $remain->__place_id;
                    $move->qty_from = $diff;
                } else {
                    $move->__place_to_id = $remain->__place_id;
                    $move->qty_to = -$diff;
                }

                $move->save();
                $remain->qty = $v;
                $remain->save();
            }
        }
    }
}
