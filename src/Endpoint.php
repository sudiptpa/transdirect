<?php

namespace Sujip\Transdirect;

trait Endpoint
{
    /**
     * @var mixed
     */
    private $sandbox = false;

    public function sandbox()
    {
        $this->sandbox = true;
    }

    /**
     * @param $segment
     * @return mixed
     */
    protected function getEndpoint($segment = null)
    {
        return $this->sandbox ?
            'https://private-anon-5e1c356539-transdirectapiv4.apiary-mock.com/api/' . $segment :
            'https://www.transdirect.com.au/api/' . $segment;
    }
}
