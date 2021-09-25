<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 13.09.2021
 * Time: 06:58
 * User: WyTcorporation
 */

class m000000_000026_chat extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('chat', [
            'id' => $this->primaryKey(),
            'first_user_id' => $this->integer()->Null(),
            'second_user_id' => $this->integer()->Null(),
            'message' => $this->text()->Null(),
            'images' => $this->text()->Null(),
            'video' => $this->text()->Null(),
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
        $this->dropTable('chat');
    }
}