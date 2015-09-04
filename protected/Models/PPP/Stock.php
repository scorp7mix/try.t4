<?php

namespace App\Models\PPP;

use T4\Orm\Model;

/**
 * Class Stock
 * @package App\Models\PPP
 * @property string name
 */
class Stock
    extends Model
{

    protected static $schema = [
        'table' => 'stocks',
        'columns' => [
            'name' => ['type' => 'string'],
        ],
    ];

}