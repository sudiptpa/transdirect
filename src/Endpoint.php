<?php

namespace Sujip\Transdirect;

trait Endpoint
{
    /**
     * @var string
     */
    protected $liveEndpoint = 'https://www.transdirect.com.au/api/';

    /**
     * @var string|null
     */
    protected $sandboxEndpoint;

    /**
     * @var bool
     */
    protected $sandbox = false;

    /**
     * Backward-compatible sandbox toggle.
     *
     * @param bool $enabled
     *
     * @return $this
     */
    public function sandbox($enabled = true)
    {
        $this->sandbox = (bool) $enabled;

        return $this;
    }

    /**
     * Fluent alias for sandbox mode.
     *
     * @param bool $enabled
     *
     * @return $this
     */
    public function useSandbox($enabled = true)
    {
        return $this->sandbox($enabled);
    }

    /**
     * @return $this
     */
    public function useProduction()
    {
        $this->sandbox = false;

        return $this;
    }

    /**
     * @param string $endpoint
     *
     * @return $this
     */
    public function setEndpoint($endpoint)
    {
        $this->liveEndpoint = rtrim($endpoint, '/').'/';

        return $this;
    }

    /**
     * @param string $endpoint
     *
     * @return $this
     */
    public function setSandboxEndpoint($endpoint)
    {
        $this->sandboxEndpoint = rtrim($endpoint, '/').'/';

        return $this;
    }

    /**
     * @return bool
     */
    public function isSandbox()
    {
        return $this->sandbox;
    }

    /**
     * @param string|null $segment
     *
     * @return string
     */
    protected function getEndpoint($segment = null)
    {
        if ($this->sandbox && !$this->sandboxEndpoint) {
            throw new \Sujip\Transdirect\Exceptions\RequestException('Sandbox endpoint is not configured.');
        }

        $base = $this->sandbox ? $this->sandboxEndpoint : $this->liveEndpoint;

        return $base.ltrim((string) $segment, '/');
    }
}
