<?php

namespace Flyt\Controllers;

use Carbon\Carbon;
use Flyt\Models\Payment;
use Flyt\Models\PaymentDetail;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;
use Respect\Validation\Validator as v;
use Illuminate\Pagination\Paginator;

class ApiController
{
    /** @var \Slim\Container */
    protected $container;


    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * display payments and filter by different criteria
     *
     * @param  Request $request
     * @return Response
     */
    public function index(Request $request, Response $response) : ResponseInterface
    {


        $data = $request->getParams();
        $validation = $this->validateFilterRequest($data);
        if ($validation->failed()) {
            return $response->withJson(['errors' => $validation->getErrors()], 422);
        }
        $query = Payment::query()->leftJoin('payment_detail', function ($join) {
            $join->on('payment.id', '=', 'payment_detail.payment_id');
        });
        if (isset($data['amount'])) {
            $query->where('amount', '>=', $data['amount']);
        }
        if (isset($data['tip'])) {
            $query->where('tip', '>=', $data['tip']);
        }
        if (isset($data['currency'])) {
            $query->where('currency', '=', $data['currency']);
        }
        if (isset($data['location'])) {
            $query->where('location', 'LIKE', '%' . $data['location'] . '%');
        }
        if (isset($data['table'])) {
            $query->where('table_number', 'LIKE', '%' . $data['table'] . '%');
        }
        if (isset($data['reference'])) {
            $query->where('reference', '=', $data['reference']);
        }

        if (isset($data['card'])) {
            $query->where('card_type', '=', $data['card']);
        }
        // filter payments for the last 'hours' hours
        if (isset($data['hours'])) {
            $dt = Carbon::now(); // sorting
            $query->where('created_at', '>=', $dt->subHours($data['hours']));
        }

        if (isset($data['card_holder'])) {
            $query->where('card_holder', 'LIKE', '%' . $data['card_holder'] . '%');
        }
        if (isset($data['phone'])) {
            $query->where('phone_number', 'LIKE', '%' . $data['phone'] . '%');
        }
        if (isset($data['device'])) {
            $query->where('device', 'LIKE', '%' . $data['device'] . '%');
        }
        $sort = 'desc';
        if (isset($data['sort'])) {
            $sort = $data['sort']; // sorting
        }
        if (isset($data['orderby'])) { // Ordering
            $query->orderBy($data['orderby'], $sort);
        } else {
            $query->orderBy('created_at', 'desc');
        }
        $page = (isset($data['page']) ? $data['page'] : 1);
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
        $payments = $query->paginate(10);
        return $this->container->get('view')->render($response, 'payroll.html.twig', ['payments' => $payments]);

    }

    /**
     * display payment detail
     * @param  integer $id
     * @param  Request $request
     * @return Response
     */
    public function payment(Request $request, Response $response, $id) : ResponseInterface
    {
        $payment = Payment::query()->leftJoin('payment_detail', function ($join) {
            $join->on('payment.id', '=', 'payment_detail.payment_id');
        })->where('id', $id)->firstOrFail();

        return $this->container->get('view')->render($response, 'payment.html.twig', compact('payment'));

    }

    /**
     * Store a new payment.
     *
     * @param  Request $request
     * @return Response
     */
    public function payments(Request $request, Response $response)
    {
        $data = $request->getParams();
        $validation = $this->validateCreateRequest($data);
        if ($validation->failed()) {
            return $response->withJson(['errors' => $validation->getErrors()], 422);
        }
        $payment = new Payment();
        try {
            $payment->amount = $data['amount'];
            if (isset($data['tip'])) {
                $payment->tip = $data['tip'];
            }
            $payment->currency = $data['currency'];
            $payment->table_number = $data['table_number'];
            $payment->location = $data['location'];
            $payment->reference = $data['reference'];
            $payment->card_type = $data['card_type'];

            if ($payment->save()) {
                if (isset($data['card_holder']) || isset($data['phone_number']) || isset($data['device'])) {
                    $paymentDetail = new PaymentDetail();
                    $paymentDetail->payment_id = $payment->id;
                    if (isset($data['card_holder'])) {
                        $paymentDetail->card_holder = $data['card_holder'];
                    }
                    if (isset($data['phone_number'])) {
                        $paymentDetail->phone_number = $data['phone_number'];
                    }
                    if (isset($data['device'])) {
                        $paymentDetail->device = $data['device'];
                    }
                    $paymentDetail->save();
                }

                return $response->withJson($payment, 201);
            } else {
                return $response->withJson(['message' => "Failed to add new payment"], 422);

            }
        } catch (Exception $e) {
            $response->withJson(['error' => 'Unable to get the web service. ' . $e->getMessage()], 503);

        }
        return $response;
    }

    /**
     * @param array
     *
     * @return \Flyt\Validation\Validator
     */
    protected function validateCreateRequest($values)
    {

        return $this->container->validator->validateArray(
            $values,
            [
                'amount' => v::notOptional()->noWhitespace()->notEmpty()->floatVal()->positive(),
                'tip' => v::optional(v::noWhitespace()->floatVal()->positive()),
                'currency' => v::notOptional()->noWhitespace()->notEmpty()->in(Payment::CURRENCIES),
                'location' => v::notOptional()->notEmpty(),
                'table_number' => v::notOptional()->noWhitespace()->intVal()->positive(),
                'reference' => v::notOptional()->notEmpty()->existsInTable($this->container->db->table('payment'), 'reference'),
                'card_type' => v::notOptional()->notEmpty()->in(Payment::ACCT),
                'card_holder' => v::optional(v::notEmpty()),
                'phone_number' => v::optional(v::phone()),
                'device' => v::optional(v::notEmpty()),
            ]
        );
    }

    /**
     * @param array
     *
     * @return \Flyt\Validation\Validator
     */
    protected function validateFilterRequest($values)
    {
        return $this->container->validator->validateArray(
            $values,
            [
                'amount' => v::optional(v::noWhitespace()->notEmpty()->floatVal()->positive()),
                'tip' => v::optional(v::noWhitespace()->floatVal()->positive()),
                'currency' => v::optional(v::noWhitespace()->notEmpty()->in(Payment::CURRENCIES)),
                'location' => v::optional(v::notEmpty()),
                'table_number' => v::optional(v::noWhitespace()->intVal()->positive()),
                'reference' => v::optional(v::noWhitespace()->notEmpty()),
                'card' => v::optional(v::notEmpty()->in(Payment::ACCT)),
                'phone' => v::optional(v::notEmpty()),
                'card_holder' => v::optional(v::notEmpty()),
                'table' => v::optional(v::noWhitespace()->intVal()->positive()),
                'hours' => v::optional(v::noWhitespace()->intVal()->positive()),
                'sort' => v::optional(v::notEmpty()->in(['asc', 'desc'])),
                'orderby' => v::optional(v::notEmpty()->in(['created_at', 'location'])),
            ]
        );
    }
}
