<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 20.09.2021
 * Time: 05:58
 * User: WyTcorporation, WyTcorp, WyTco
 */

class m000000_000033_shop extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('shop', [
            'id' => $this->primaryKey(),
            'address' => $this->text()->Null(),
            'phones' => $this->text()->Null(),
            'location' => $this->text()->Null(),
            'date' => $this->text()->Null(),
            'email' => $this->string(255)->Null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->Null(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->Null(),
            'created_ip' => $this->string()->notNull(),
            'updated_ip' => $this->string()->Null(),
        ]);
    }

    public function down()
    {
        $this->dropTable('shop');
    }
}