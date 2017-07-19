<?php

/**
 * This file is part of the T-SYS Prime PHP Adapter
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Prime;

final class PrimeGenerator
{
    /**
     * A collection of options
     * 
     * @var array
     */
    private $options = array(
        'Version' => '1.0.0',
        'SignatureMethod' => 'SHA1',
        'PurchaseCurrency' => '840',
        'PurchaseCurrencyExponent' => '2'
    );

    /**
     * State initialization
     * 
     * @param array $options
     * @return void
     */
    public function __construct(array $options)
    {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * Render fields
     * 
     * @return string
     */
    public function renderFields()
    {
        $fragment = null;

        foreach ($this->createFields() as $name => $value) {
            $fragment .= sprintf('<input type="hidden" name="%s" value="%s">', $name, $value) . PHP_EOL;
        }

        return $fragment;
    }

    /**
     * Create fields to be rendered
     * 
     * @return array
     */
    private function createFields()
    {
        return array_merge($this->options, array(
            // Dynamic fields
            'Signature' => $this->createSignature(),
            'OrderID' => $this->createOrderId()
        ));
    }

    /**
     * Creates unique order ID
     * 
     * @return string
     */
    private function createOrderId()
    {
        static $id = null;

        // Generate only once for multiple calls
        if ($id === null) {
            $id = uniqid();
        }

        return $id;
    }

    /**
     * Creates the signature
     * 
     * @return string
     */
    public function createSignature()
    {
        // Secret string
        $secret = $this->options['Password'] . 
                  $this->options['MerID'] . 
                  $this->options['AcqID'] . 
                  $this->createOrderId() . 
                  $this->options['PurchaseAmt'] . 
                  $this->options['PurchaseCurrency'];

        return base64_encode(sha1($secret, true));
    }
}
