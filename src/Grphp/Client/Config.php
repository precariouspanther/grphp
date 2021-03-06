<?php
/**
 * Copyright (c) 2017-present, BigCommerce Pty. Ltd. All rights reserved
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the
 * Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
declare(strict_types = 1);

namespace Grphp\Client;

use Grphp\Client\Strategy\Grpc\Config as GrpcConfig;
use Grphp\Client\Strategy\Grpc\Strategy as GrpcStrategy;
use Grphp\Client\Strategy\StrategyInterface;
use Grphp\Serializers\Errors\Json as JsonSerializer;

/**
 * Configuration object for Grphp Client
 * @package Grphp\Client
 */
class Config
{
    /** @var string $hostname */
    public $hostname = '';
    /** @var string $authentication */
    public $authentication;
    /** @var array $authenticationOptions */
    public $authenticationOptions = [];
    /** @var string $errorSerializer */
    public $errorSerializer;
    /** @var array $errorSerializerOptions */
    public $errorSerializerOptions = [];
    /** @var string $errorMetadataKey */
    public $errorMetadataKey = 'error-internal-bin';
    /** @var array $interceptorOptions */
    public $interceptorOptions = [];
    /** @var bool $useDefaultInterceptors */
    public $useDefaultInterceptors = true;
    /** @var \stdClass */
    private $strategy;

    /**
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->hostname = array_key_exists('hostname', $options)
            ? $options['hostname']
            : '';
        $this->authentication = array_key_exists('authentication', $options)
            ? $options['authentication']
            : null;
        $this->authenticationOptions = array_key_exists('authentication_options', $options)
            ? $options['authentication_options']
            : [];
        $this->errorSerializer = array_key_exists('error_serializer', $options)
            ? $options['error_serializer']
            : JsonSerializer::class;
        $this->errorSerializerOptions = array_key_exists('error_serializer_options', $options)
            ? $options['error_serializer_options']
            : [];
        $this->errorMetadataKey = array_key_exists('error_metadata_key', $options)
            ? $options['error_metadata_key']
            : 'error-internal-bin';
        $this->interceptorOptions = array_key_exists('interceptor_options', $options)
            ? $options['interceptor_options']
            : [];
        $this->useDefaultInterceptors = array_key_exists('use_default_interceptors', $options)
            ? $options['use_default_interceptors']
            : true;
        $this->strategy = array_key_exists('strategy', $options)
            ? $options['strategy']
            : new GrpcStrategy(new GrpcConfig());
    }

    /**
     * @return StrategyInterface
     */
    public function getStrategy(): StrategyInterface
    {
        return $this->strategy;
    }

    /**
     * @param mixed $strategy
     * @return $this
     */
    public function setStrategy($strategy): Config
    {
        $this->strategy = $strategy;
        return $this;
    }
}
