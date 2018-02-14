<?php


use Illuminate\Database\Schema\Blueprint;

class CreatePaymentDetailTable extends BaseMigration
{
    public function up()
    {
        $this->schema->create('payment_detail', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('payment_id');
            $table->string('card_holder',50)->nullable();
            $table->string('phone_number',20)->nullable();
            $table->string('device',50)->nullable();
            $table->primary(['payment_id']);
            $table->foreign('payment_id')->references('id')->on('payment')->onDelete('cascade');
        });
    }
    public function down()
    {
        $this->schema->dropIfExists('payment_detail');
    }
}
