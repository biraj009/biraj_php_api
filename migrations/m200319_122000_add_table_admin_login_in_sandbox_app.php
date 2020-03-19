<?php

use yii\db\Migration;

/**
 * Class m200319_122000_add_table_admin_login_in_sandbox_app
 */
class m200319_122000_add_table_admin_login_in_sandbox_app extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `admin_login` ( `id` INT(11) NOT NULL , `username` VARCHAR(50) NOT NULL , `password` VARCHAR(100) NOT NULL , `status` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1= active, 0=inactive' ) ENGINE = InnoDB;");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200319_122000_add_table_admin_login_in_sandbox_app cannot be reverted.\n";

        return false;
    }

}
