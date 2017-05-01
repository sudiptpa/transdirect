<?php

namespace Sujip\Transdirect;

use Sujip\Transdirect\Http\Request;

/**
 * Class Transdirect.
 */
class Transdirect extends Request
{
    /**
     * @param array $parameters
     *
     * @return \Sujip\Transdirect\Response
     */
    public function simpleQuotes(array $parameters)
    {
        return $this->make('quotes', $parameters);
    }

    /**
     * @param $parameters
     *
     * @return \Sujip\Transdirect\Response
     */
    public function createBooking($parameters)
    {
        return $this->make('bookings', $parameters);
    }

    /**
     * @param $since
     * @param null $sort
     *
     * @return \Sujip\Transdirect\Response
     */
    public function getBookings($since = null, $sort = null)
    {
        $uri = sprintf('bookings/?since=%s&sort=%s', $since, $sort);

        return $this->make($uri, [], 'get');
    }

    /**
     * @param $booking_id
     *
     * @return \Sujip\Transdirect\Response
     */
    public function getSingleBooking($booking_id)
    {
        $uri = sprintf('bookings/%s', $booking_id);

        return $this->make($uri, [], 'get');
    }

    /**
     * @param $booking_id
     * @param $parameters
     *
     * @return \Sujip\Transdirect\Response
     */
    public function updateBooking($booking_id, $parameters)
    {
        $uri = sprintf('bookings/%s', $booking_id);

        return $this->make($uri, $parameters, 'put');
    }

    /**
     * @param $booking_id
     *
     * @return \Sujip\Transdirect\Response
     */
    public function removeBooking($booking_id)
    {
        $uri = sprintf('bookings/%s', $booking_id);

        return $this->make($uri, [], 'delete');
    }

    /**
     * @param $booking_id
     * @param $parameters
     *
     * @return \Sujip\Transdirect\Response
     */
    public function confirmBooking($booking_id, $parameters)
    {
        $uri = sprintf('bookings/%s/confirm', $booking_id);

        return $this->make($uri, $parameters);
    }

    /**
     * @param $booking_id
     *
     * @return \Sujip\Transdirect\Response
     */
    public function trackBooking($booking_id)
    {
        $uri = sprintf('bookings/track/%s', $booking_id);

        return $this->make($uri, [], 'get');
    }

    /**
     * @param $booking_id
     *
     * @return \Sujip\Transdirect\Response
     */
    public function getBookingItems($booking_id)
    {
        $uri = sprintf('bookings/%s/items', $booking_id);

        return $this->make($uri, [], 'get');
    }

    /**
     * @param $booking_id
     * @param $parameters
     *
     * @return \Sujip\Transdirect\Response
     */
    public function addItemInBooking($booking_id, $parameters)
    {
        $uri = sprintf('bookings/%s/items', $booking_id);

        return $this->make($uri, $parameters);
    }

    /**
     * @param $page
     *
     * @return \Sujip\Transdirect\Response
     */
    public function getLocations($page = null)
    {
        $uri = 'locations';

        if (isset($page)) {
            $uri = sprintf($uri.'/page/%s', $page);
        }

        return $this->make($uri, [], 'get');
    }

    /**
     * @param $query
     *
     * @return \Sujip\Transdirect\Response
     */
    public function searchLocations($query = null)
    {
        $uri = sprintf('locations?q=%s', $query);

        return $this->make($uri, [], 'get');
    }

    /**
     * @param $query
     *
     * @return \Sujip\Transdirect\Response
     */
    public function getByPostcode($query)
    {
        $uri = sprintf('locations/postcode/%s', $query);

        return $this->make($uri, [], 'get');
    }

    /**
     * @param $parameters
     *
     * @return \Sujip\Transdirect\Response
     */
    public function createOrder($parameters)
    {
        return $this->make('orders', $parameters);
    }

    /**
     * @param $since
     * @param null $sort
     *
     * @return \Sujip\Transdirect\Response
     */
    public function getOrders($since = null, $sort = null)
    {
        $uri = sprintf('orders/?since=%s&sort=%s', $since, $sort);

        return $this->make($uri, [], 'get');
    }

    /**
     * @param $order_id
     *
     * @return \Sujip\Transdirect\Response
     */
    public function getOrder($order_id)
    {
        $uri = sprintf('orders/%s', $order_id);

        return $this->make($uri, [], 'get');
    }

    /**
     * @param $order_id
     * @param $parameters
     *
     * @return \Sujip\Transdirect\Response
     */
    public function updateOrder($order_id, $parameters)
    {
        $uri = sprintf('orders/%s', $order_id);

        return $this->make($uri, $parameters, 'put');
    }

    /**
     * @param $order_id
     *
     * @return \Sujip\Transdirect\Response
     */
    public function removeOrder($order_id)
    {
        $uri = sprintf('orders/%s', $order_id);

        return $this->make($uri, [], 'delete');
    }

    /**
     * @param $booking_id
     *
     * @return \Sujip\Transdirect\Response
     */
    public function getPdfLabel($booking_id)
    {
        $uri = sprintf('bookings/%s/label', $booking_id);

        return $this->make($uri, [], 'get');
    }

    /**
     * @param $booking_id
     *
     * @return \Sujip\Transdirect\Response
     */
    public function getInvoice($booking_id)
    {
        $uri = sprintf('bookings/%s/invoice', $booking_id);

        return $this->make($uri, [], 'get');
    }

    /**
     * @param $booking_id
     *
     * @return \Sujip\Transdirect\Response
     */
    public function getTntLabel($booking_id)
    {
        $uri = sprintf('bookings/%s/tntregeneralabel', $booking_id);

        return $this->make($uri, [], 'get');
    }

    /**
     * @return \Sujip\Transdirect\Response
     */
    public function getCouriers()
    {
        return $this->make('couriers', [], 'get');
    }

    /**
     * @return \Sujip\Transdirect\Response
     */
    public function getMember()
    {
        return $this->make('member', [], 'get');
    }
}
