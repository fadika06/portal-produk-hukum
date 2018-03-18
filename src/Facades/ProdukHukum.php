<?php

namespace Bantenprov\ProdukHukum\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * The ProdukHukum facade.
 *
 * @package Bantenprov\ProdukHukum
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class ProdukHukumFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'produk-hukum';
    }
}
