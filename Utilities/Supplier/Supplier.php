<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities\Supplier;

/**
 * Represents a supplier of results.
 * @package Ouzo\Utilities\Supplier
 */
interface Supplier
{
    /**
     * Gets a result.
     *
     * @return mixed
     */
    public function get();
}
