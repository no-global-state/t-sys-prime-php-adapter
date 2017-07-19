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
    private $options = array();

    /**
     * State initialization
     * 
     * @param array $options
     * @return void
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }
}
