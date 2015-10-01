<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1443613003_createTables
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
        $this->insert('types', ['name' => 'Корректировка']);

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
    }

    public function down()
    {
        $this->dropTable('consignments');
        $this->dropTable('paints');
        $this->dropTable('places');
        $this->dropTable('stocks');
        $this->dropTable('types');
    }

}