<?php

namespace Sujip\Transdirect;

use GuzzleHttp\Message\Response as GuzzleHttpResponse;

/**
 * Class Response.
 */
class Response extends GuzzleHttpResponse
{
    /**
     * @var GuzzleHttp\Message\Response
     */
    protected $response;

    /**
     * @param GuzzleHttpResponse $response
     */
    public function __construct(GuzzleHttpResponse $response)
    {
        $this->response = $response;
    }

    public function getBookingId()
    {
        $booking = $this->getBody();

        return isset($booking->id) ? $booking->id : null;
    }

    public function getQuotes()
    {
        $quotes = [];
        $booking = $this->getBody();

        if (!isset($booking->quotes)) {
            return;
        }

        if (is_object($booking->quotes)) {
            foreach ($booking->quotes as $key => $quote) {
                $quotes[] = [
                    'booking_id'         => $this->getBookingId(),
                    'provider'           => $key,
                    'name_original'      => str_replace('_', '  ', $key),
                    'name_formatted'     => sprintf('%s - %s [%s]', ucwords(str_replace('_', '  ', $key)), ucwords($quote->service), $quote->transit_time),
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

        return json_encode($quotes);
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        $body = (string) $this->response->getBody();

        return json_decode($body);
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->response->getStatusCode();
    }
}
