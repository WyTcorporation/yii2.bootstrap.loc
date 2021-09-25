<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 12.09.2021
 * Time: 22:18
 * User: WyTcorporation
 */

class m000000_000002_user_address extends \yii\db\Migration
{
    public function up()
    {

        $this->createTable('user_address', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'firstname' => $this->string(255)->Null(),
            'lastname' => $this->string(255)->Null(),
            'company' => $this->string(255)->Null(),
            'address_1' => $this->string(255)->Null(),
            'address_2' => $this->string(255)->Null(),
            'city' => $this->string(255)->Null()
        ]);

        $this->addForeignKey('user-address-user-id', 'user_address', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');

    }

    public function down()
    {
        $this->dropTable('user_address');
    }
}