<?php

use yii\db\Migration;

/**
 * Class m221027_100835_seed_config_table
 */
class m221027_100835_seed_config_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insertInitConfig();
    }

    private function insertInitConfig() {
        $this->insert('config', [
            'key' => 'TOKEN_EXP_SECONDS',
            'value' => 60*60*24*7,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221027_100835_seed_config_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221027_100835_seed_config_table cannot be reverted.\n";

        return false;
    }
    */
}
