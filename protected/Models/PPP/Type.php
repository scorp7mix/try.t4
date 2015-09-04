<?php

namespace App\Models\PPP;

use T4\Orm\Model;

/**
 * Class Type
 * @package App\Models\PPP
 * @property string name
 */
class Type
    extends Model
{

    protected static $schema = [
        'table' => 'types',
        'columns' => [
            'name' => ['type' => 'string'],
        ],
    ];

}