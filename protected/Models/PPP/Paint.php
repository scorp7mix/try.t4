<?php

namespace App\Models\PPP;

use T4\Orm\Model;

/**
 * Class Paint
 * @package App\Models\PPP
 * @property string name
 */
class Paint
    extends Model
{

    protected static $schema = [
        'table' => 'paints',
        'columns' => [
            'name' => ['type' => 'string'],
        ],
        'relations' => [
            'consignments' => ['type' => Model::HAS_MANY, 'model' => Consignment::class],
        ]
    ];

}