<?php

use yii\db\Schema;

class m140718_081441_create_table_sc_comment extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('sc_comment', [
            'id' => 'pk',
            'relModelClass' => 'varchar(25)',
            'relModelId' => 'integer',
            'text' => 'text',
            'createdDate' => 'timestamp not null default now()',
        ]);
    }

    public function down()
    {
        $this->dropTable('sc_comment');
    }
}
