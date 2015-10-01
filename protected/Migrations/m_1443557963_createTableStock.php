<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1443557963_createTableStock
    extends Migration
{

    public function up()
    {
        if (!$this->existsTable('remains')) {
            $this->createTable('remains', [
                '__consignment_id' => ['type' => 'link'],
                '__place_id' => ['type' => 'link'],
                'qty' => ['type' => 'int'],
            ], [
                'consignment' => ['columns' => ['__consignment_id']],
                'place' => ['columns' => ['__place_id']],
            ]);
        }

        if (!$this->existsTable('moves')) {
            $this->createTable('moves', [
                'date' => ['type' => 'datetime', 'default' => 'now'],
                '__type_id' => ['type' => 'link'],
                '__consignment_id' => ['type' => 'link'],
                '__place_from_id' => ['type' => 'link'],
                '__place_to_id' => ['type' => 'link'],
                'qty_from' => ['type' => 'int'],
                'qty_to' => ['type' => 'int'],
                'qty_plan' => ['type' => 'int'],
                'kr' => ['type' => 'string'],
                'parts' => ['type' => 'int'],
            ], [
                'type' => ['columns' => ['__type_id']],
                'consignment' => ['columns' => ['__consignment_id']],
                'place_from' => ['columns' => ['__place_from_id']],
                'place_to' => ['columns' => ['__place_to_id']],
            ]);
        }
    }

    public function down()
    {
        $this->dropTable('moves');
        $this->dropTable('remains');
    }

}