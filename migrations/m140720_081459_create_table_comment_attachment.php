<?php

use yii\db\Schema;

class m140720_081459_create_table_comment_attachment extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('sc_comment_attachment', [
            'id' => 'pk',
            'commentId' => 'integer',
            'fileName' => 'varchar(100)',
            'fileExtension' => 'varchar(100)',
            'filePath' => 'varchar(200)',
            'fileUrl' => 'varchar(200)',
            'createdDate' => 'timestamp not null default now()',
        ]);

        $this->addForeignKey(
            'FK_CommentAttachment_commentId',
            'sc_comment_attachment', 'commentId',
            'sc_comment', 'id',
            'CASCADE', 'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('sc_comment_attachment');
    }
}
