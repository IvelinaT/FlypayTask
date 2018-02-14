<?php
$app->get('/payments', 'ApiController:index')->setName('index');
$app->post('/payments', 'ApiController:payments');
$app->get('/payments/{id:[0-9]+}', 'ApiController:payment')->setName('payment-show');
