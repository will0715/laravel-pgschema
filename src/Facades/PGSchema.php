<?php

namespace Poyi\PGSchema\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class PGSchema
 *
 * @package Poyi\PGSchema\Facades
 */
class PGSchema extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'pgschema';
    }
}
