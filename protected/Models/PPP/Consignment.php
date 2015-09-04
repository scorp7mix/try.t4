<?php

namespace App\Models\PPP;

use T4\Orm\Model;

/**
 * Class Consignment
 * @package App\Models\PPP
 * @property string $name
 * @property int $date_of_end
 * @property \App\Models\PPP\Paint $paint
 */
class Consignment
    extends Model
{

    protected static $schema = [
        'table' => 'consignments',
        'columns' => [
            'name' => ['type'=>'string'],
            'date_of_end'  => ['type'=>'datetime'],
        ],
        'relations' => [
            'paint' => ['type' => self::BELONGS_TO, 'model' => Paint::class],
        ]
    ];

}
