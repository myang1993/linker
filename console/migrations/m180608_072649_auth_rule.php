<?php

use yii\db\Migration;

/**
 * Class m180608_072649_auth_rule
 */
class m180608_072649_auth_rule extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180608_072649_auth_rule cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180608_072649_auth_rule cannot be reverted.\n";

        return false;
    }
    */
}
