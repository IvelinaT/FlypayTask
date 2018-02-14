<?php

namespace Flyt\Tests;

use \Flyt\Tests\BaseTestCase;


class PaymentsTest extends BaseTestCase
{

    /** @test */
    public function will_return_all_payments()
    {
        $response = $this->runApp('GET', '/payments');

        $this->assertEquals(200, $response->getStatusCode());

    }

    /** @test */
    public function will_return_payment()
    {
        $response = $this->runApp('GET', '/payments/3');

        $this->assertEquals(200, $response->getStatusCode());

    }

    /** @test */
    public function will_return_404_error()
    {
        $response = $this->runApp('GET', '/');

        $this->assertEquals(404, $response->getStatusCode());

    }


    /** @test */
    public function will_create_new_payment()
    {
        $payload = [
            'amount' => '333.87',
            'tip' => '2.15',
            'currency' => 'USD',
            'table_number' => '1',
            'location' => 'COVENT GARDEN GBK',
            'reference' => 'TR4126634',
            'card_type' => 'Diners Club'
        ];

        $response = $this->request('POST', '/payments', $payload);

        $this->assertEquals(201, $response->getStatusCode());

    }

    /** @test */
    public function will_not_create_new_payment()
    {
        $payload = [
            'amount' => '333.87',
            'tip' => '2.15',
            'currency' => 'USD',
            'table_number' => '1',
            'location' => 'COVENT GARDEN GBK',
            'reference' => 'TR4126634',
            'card_type' => 'Diners Club'
        ];

        $response = $this->request('POST', '/payments', $payload);

        $this->assertEquals(422, $response->getStatusCode());

    }


}