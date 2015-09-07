<?php

namespace App\Models\PPP;

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

}
