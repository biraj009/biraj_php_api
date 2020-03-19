<?php

use yii\db\Migration;

/**
 * Class m200319_110300_add_table_user_in_sandbox_app
 */
class m200319_110300_add_table_user_in_sandbox_app extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `user` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `name` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL , `username` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL , `email` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL , `age` INT(11) NOT NULL , `sex` VARCHAR(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL , `city` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL , `state` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL , `password` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL , `status` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1=active, 0=inactive' , `deleted` TINYINT(1) NOT NULL DEFAULT '0' , `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = InnoDB;");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200319_110300_add_table_user_in_sandbox_app cannot be reverted.\n";

        return false;
    }

}
