<?php
$this->factory->define(\Flyt\Models\PaymentDetail::class, function (\Faker\Generator $faker) {
    return [
        'payment_id'   => function () {
            return $this->factory->of(\Flyt\Models\Payment::class)->create()->id;
        },
        'card_holder'    => $faker->name(),
        'phone_number'    => $faker->phoneNumber,
        'device' => $faker->randomElement($array = array('Andoid', 'iOS'))
    ];
});