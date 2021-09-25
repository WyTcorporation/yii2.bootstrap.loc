<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 12.09.2021
 * Time: 22:17
 * User: WyTcorporation
 */

class m000000_000003_user_profile extends \yii\db\Migration
{
    public function up()
    {

        $this->createTable('user_profile', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'phone' => $this->string(255)->Null(),
            'firstname' => $this->string(255)->Null(),
            'lastname' => $this->string(255)->Null(),
        ]);

        $this->addForeignKey('user-profile-user-id', 'user_profile', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');

    }

    public function down()
    {
        $this->dropTable('user_profile');
    }
}