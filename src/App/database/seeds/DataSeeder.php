<?php

use Flyt\database\BaseSeeder;


class DataSeeder extends BaseSeeder
{
    protected $paymentsCount = 20;

    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $payments = $this->factory->of(\Flyt\Models\Payment::class)->times($this->paymentsCount)->create();

        $payments->each(function (\Flyt\Models\Payment $payment) {
            $this->factory->of(\Flyt\Models\PaymentDetail::class)->times(rand(0, 1))->create(
                ['payment_id' => $payment->id]);
        });

    }
}