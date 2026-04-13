<?php

namespace Sujip\Transdirect;

use Sujip\Transdirect\Http\Request;

class Transdirect extends Request
{
    public static function connect($token, $transport = null)
    {
        return new static($token, $transport);
    }

    public function quotes()
    {
        return $this->resource('quotes');
    }

    public function bookings()
    {
        return $this->resource('bookings');
    }

    public function orders()
    {
        return $this->resource('orders');
    }

    public function locations()
    {
        return $this->resource('locations');
    }

    public function couriers()
    {
        return $this->resource('couriers');
    }

    public function member()
    {
        return $this->resource('member');
    }

    public function frequentRates()
    {
        return $this->resource('frequent-rates');
    }

    public function resource($segment)
    {
        return new Resource($this, $segment);
    }

    public function tracking($bookingId)
    {
        return $this->make('bookings/track/'.rawurlencode((string) $bookingId), [], 'get');
    }

    public function postcode($postcode)
    {
        return $this->make('locations/postcode/'.rawurlencode((string) $postcode), [], 'get');
    }

    public function pagedLocations($page)
    {
        return $this->make('locations/page/'.rawurlencode((string) $page), [], 'get');
    }
}
