<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1441353610_createTables
    extends Migration
{

    public function up()
    {
        if (!$this->existsTable('types')) {
            $this->createTable('types', [
                'name' => ['type' => 'string'],
            ], [
                ['type' => 'unique', 'columns' => ['name']],
            ]);
        }

        $this->insert('types', ['name' => 'Поставка на склад']);
        $this->insert('types', ['name' => 'Перемещение в цех']);
        $this->insert('types', ['name' => 'Возврат на склад']);
        $this->insert('types', ['name' => 'Расход в цеху']);

        if (!$this->existsTable('stocks')) {
            $this->createTable('stocks', [
                'name' => ['type' => 'string'],
            ], [
                ['type' => 'unique', 'columns' => ['name']],
            ]);
        }

        $this->insert('stocks', ['name' => 'Основной склад']);
        $this->insert('stocks', ['name' => 'Склад в цеху']);

        if (!$this->existsTable('places')) {
            $this->createTable('places', [
                'name' => ['type' => 'string'],
                '__stock_id' => ['type' => 'link'],
            ], [
                'stock' => ['columns' => ['__stock_id']],
            ]);
        }

        if (!$this->existsTable('paints')) {
            $this->createTable('paints', [
                'name' => ['type' => 'string'],
            ], [
                ['type' => 'unique', 'columns' => ['name']],
            ]);
        }

        if (!$this->existsTable('consignments')) {
            $this->createTable('consignments', [
                'name' => ['type' => 'string'],
                '__paint_id' => ['type' => 'link'],
                'date_of_end' => ['type' => 'date'],
            ], [
                ['type' => 'unique', 'columns' => ['name']],
                'paint' => ['columns' => ['__paint_id']],
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
        $this->dropTable('consignments');
        $this->dropTable('paints');
        $this->dropTable('places');
        $this->dropTable('stocks');
        $this->dropTable('types');
    }

}