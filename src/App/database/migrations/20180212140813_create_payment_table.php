<?php


use Illuminate\Database\Schema\Blueprint;

class CreatePaymentTable extends BaseMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('payment', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->double('amount', 5, 2);
            $table->double('tip', 5, 2);
            $table->enum('currency', \Flyt\Models\Payment::CURRENCIES);
            $table->string('location',100);
            $table->integer('table_number');
            $table->string('reference',12)->unique();
            $table->enum('card_type', \Flyt\Models\Payment::ACCT);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('payment');
    }
}
