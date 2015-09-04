<?php

namespace App\Models\PPP;

use T4\Orm\Model;

/**
 * Class Place
 * @package App\Models\PPP
 * @property string $name
 * @property \App\Models\PPP\Stock $stock
 */
class Place
    extends Model
{

    protected static $schema = [
        'table' => 'places',
        'columns' => [
            'name' => ['type'=>'string'],
        ],
        'relations' => [
            'stock' => ['type' => self::BELONGS_TO, 'model' => Stock::class],
        ]
    ];

}
