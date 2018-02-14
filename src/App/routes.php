<?php
$app->get('/payments', 'ApiController:index')->setName('index');
$app->post('/payments', 'ApiController:payments')->setName('payments-all');
$app->get('/payments/{id:[0-9]+}', 'ApiController:payment')->setName('payment-show');
