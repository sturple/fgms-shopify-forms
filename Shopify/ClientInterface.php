<?php

namespace Fgms\EmailInquiriesBundle\Shopify;

/**
 * An interface which may be implemented to provide
 * a channel through which to interact with the Shopify
 * API.
 */
interface ClientInterface
{
    /**
     * Invokes the Shopify REST API.
     *
     * @param string $method
     * @param string $endpoint
     * @param array $args
     *
     * @return ValueWrapper
     */
    public function call($method, $endpoint, array $args = []);
}
