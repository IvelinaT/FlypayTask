<?php
$this->factory->define(\Flyt\Models\Payment::class, function (\Faker\Generator $faker) {
    return [
        'amount' => $faker->randomFloat(5,1,20000),
        'tip'    => $faker->randomFloat(5,1,2000),
        'currency'    => $faker->randomElement($array = \Flyt\Models\Payment::CURRENCIES),
        'location' =>$faker->randomElement($array = array('Great Portland Street GBK','COVENT GARDEN GBK','BIRMINGHAM RESORTS WORLD GBK','SOHO GBK','MAIDSTONE GBK')),
        'table_number'    => $faker->randomNumber(3),
        'reference'    => 'TR'.$faker->numberBetween(10000,99000),
        'card_type' =>$faker->randomElement($array = \Flyt\Models\Payment::ACCT)
    ];
});