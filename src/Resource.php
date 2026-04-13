<?php

namespace Sujip\Transdirect;

class Resource
{
    /**
     * @var \Sujip\Transdirect\Transdirect
     */
    protected $client;

    /**
     * @var string
     */
    protected $segment;

    /**
     * @param \Sujip\Transdirect\Transdirect $client
     * @param string                         $segment
     */
    public function __construct(Transdirect $client, $segment)
    {
        $this->client = $client;
        $this->segment = trim($segment, '/');
    }

    /**
     * @param array $parameters
     *
     * @return \Sujip\Transdirect\Response
     */
    public function create(array $parameters = [])
    {
        return $this->client->make($this->segment, $parameters, 'post');
    }

    /**
     * @param array $query
     *
     * @return \Sujip\Transdirect\Response
     */
    public function all(array $query = [])
    {
        return $this->client->make($this->segment, $query, 'get');
    }

    /**
     * @param array $query
     *
     * @return \Sujip\Transdirect\Response
     */
    public function get(array $query = [])
    {
        return $this->all($query);
    }

    /**
     * @param string|int $id
     * @param array      $query
     *
     * @return \Sujip\Transdirect\Response
     */
    public function find($id, array $query = [])
    {
        return $this->client->make($this->path($id), $query, 'get');
    }

    /**
     * @param string|int $id
     * @param array      $parameters
     *
     * @return \Sujip\Transdirect\Response
     */
    public function update($id, array $parameters = [])
    {
        return $this->client->make($this->path($id), $parameters, 'put');
    }

    /**
     * @param string|int $id
     * @param array      $parameters
     *
     * @return \Sujip\Transdirect\Response
     */
    public function delete($id, array $parameters = [])
    {
        return $this->client->make($this->path($id), $parameters, 'delete');
    }

    /**
     * @param string|int $id
     * @param string     $action
     * @param array      $parameters
     * @param string     $method
     *
     * @return \Sujip\Transdirect\Response
     */
    public function action($id, $action, array $parameters = [], $method = 'post')
    {
        return $this->client->make($this->path($id).'/'.trim($action, '/'), $parameters, $method);
    }

    /**
     * @param string|int $id
     * @param string     $child
     * @param array      $parameters
     * @param string     $method
     *
     * @return \Sujip\Transdirect\Response
     */
    public function nested($id, $child, array $parameters = [], $method = 'get')
    {
        return $this->client->make($this->path($id).'/'.trim($child, '/'), $parameters, $method);
    }

    /**
     * @param string|int $id
     *
     * @return string
     */
    protected function path($id)
    {
        return $this->segment.'/'.rawurlencode((string) $id);
    }
}
