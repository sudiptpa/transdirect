<?php

namespace Sujip\Transdirect;

/**
 * Lightweight response wrapper used by both old and fluent APIs.
 */
class Response
{
    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var array
     */
    protected $headers = array();

    /**
     * @var string
     */
    protected $body = '';

    /**
     * @param int    $statusCode
     * @param array  $headers
     * @param string $body
     */
    public function __construct($statusCode = 200, array $headers = array(), $body = '')
    {
        $this->statusCode = (int) $statusCode;
        $this->headers = $headers;
        $this->body = (string) $body;
    }

    /**
     * @return string|null
     */
    public function getId()
    {
        $object = $this->toObject();

        return isset($object->id) ? $object->id : null;
    }

    /**
     * @return object|null
     */
    public function getItems()
    {
        $object = $this->toObject();

        return isset($object->items) ? $object->items : null;
    }

    /**
     * @return array|null
     */
    public function getQuotes()
    {
        $quotes = array();
        $object = $this->toObject();

        if (!isset($object->quotes)) {
            return null;
        }

        if (is_object($object->quotes)) {
            foreach ($object->quotes as $key => $quote) {
                $service = isset($quote->service) ? $quote->service : '';
                $transitTime = isset($quote->transit_time) ? $quote->transit_time : '';
                $formatted = sprintf(
                    '%s - %s [%s]',
                    ucwords(str_replace('_', ' ', $key)),
                    ucwords($service),
                    $transitTime
                );

                $quotes[] = array(
                    'booking_id' => $this->getId(),
                    'provider' => $key,
                    'name_original' => $this->parse($key),
                    'name_formatted' => $this->parse($formatted),
                    'total' => isset($quote->total) ? $quote->total : null,
                    'fee' => isset($quote->fee) ? $quote->fee : null,
                    'price_insurance_ex' => isset($quote->price_insurance_ex) ? $quote->price_insurance_ex : null,
                    'insured_amount' => isset($quote->insured_amount) ? (float) $quote->insured_amount : 0.0,
                    'additional' => 0,
                    'service' => $service,
                    'transit_time' => $transitTime,
                    'pickup_dates' => isset($quote->pickup_dates) ? $quote->pickup_dates : null,
                    'pickup_time' => isset($quote->pickup_time) ? $quote->pickup_time : null,
                );
            }
        }

        return $quotes;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return $this->body;
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
        return $this->statusCode;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->getCode();
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param string $name
     *
     * @return string|null
     */
    public function getHeader($name)
    {
        foreach ($this->headers as $key => $value) {
            if (strtolower($key) === strtolower($name)) {
                return $value;
            }
        }

        return null;
    }

    /**
     * @return bool
     */
    public function successful()
    {
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public function parse($string)
    {
        $string = str_replace('_', ' ', $string);

        return str_replace('Tnt', 'TNT', $string);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}
