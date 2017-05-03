<?php

namespace Sujip\Transdirect;

use GuzzleHttp\Message\Response as GuzzleHttpResponse;

/**
 * Class Response.
 */
class Response extends GuzzleHttpResponse
{
    /**
     * The guzzle http client response.
     *
     * @var \GuzzleHttp\Message\Response
     */
    protected $response;

    /**
     * Create a new response instance.
     *
     * @param GuzzleHttpResponse $response
     *
     * @return void
     */
    public function __construct(GuzzleHttpResponse $response)
    {
        $this->response = $response;
    }

    public function getId()
    {
        $object = $this->toObject();

        return isset($object->id) ? $object->id : null;
    }

    /**
     * @return object
     */
    public function getItems()
    {
        $object = $this->toObject();

        if (!isset($object->items)) {
            return;
        }

        return $object->items;
    }

    /**
     * @return array
     */
    public function getQuotes()
    {
        $quotes = [];
        $object = $this->toObject();

        if (!isset($object->quotes)) {
            return;
        }

        if (is_object($object->quotes)) {
            foreach ($object->quotes as $key => $quote) {
                $formatted = sprintf(
                    '%s - %s [%s]',
                    ucwords(str_replace('_', '  ', $key)),
                    ucwords($quote->service), $quote->transit_time
                    );
                $quotes[] = [
                    'booking_id'         => $this->getId(),
                    'provider'           => $key,
                    'name_original'      => str_replace('_', '  ', $key),
                    'name_formatted'     => str_replace('Tnt', 'TNT', $formatted),
                    'total'              => $quote->total,
                    'fee'                => $quote->fee,
                    'price_insurance_ex' => $quote->price_insurance_ex,
                    'insured_amount'     => (float) $quote->insured_amount,
                    'service'            => $quote->service,
                    'transit_time'       => $quote->transit_time,
                    'pickup_dates'       => $quote->pickup_dates,
                    'pickup_time'        => $quote->pickup_time,
                ];
            }
        }

        return $quotes;
    }

    public function toJson()
    {
        return (string) $this->response->getBody();
    }

    /**
     * @return mixed
     */
    public function toArray()
    {
        return json_decode($this->toJson(), true);
    }

    /**
     * @return mixed
     */
    public function toObject()
    {
        return json_decode($this->toJson());
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->response->getStatusCode();
    }
}
