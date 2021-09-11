<?php

use yii\db\Migration;

/**
 * Handles the creation of table links.
 */
class m210911_110908_create_links_table extends Migration
{
    /**
     * {@inheritDoc }
     */
    public function safeUp()
    {
        $this->createTable('links', [
            'id' => $this->primaryKey(),
            'url' => $this->text()->notNull(),
            'hash' => $this->string(6)->notNull()->unique(),
            'visits' => $this->integer()->defaultValue(0),
        ]);
        $this->createIndex(
            'idx-links-hash',
            'links',
            'hash'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-links-hash',
            'links'
        );
        $this->dropTable('links');
    }
}
