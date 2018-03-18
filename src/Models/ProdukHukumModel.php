<?php namespace Bantenprov\ProdukHukum\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * The ProdukHukumModel class.
 *
 * @package Bantenprov\ProdukHukum
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class ProdukHukumModel extends Model
{
    /**
    * Table name.
    *
    * @var string
    */
    protected $table = 'produk-hukum';

    /**
    * The attributes that are mass assignable.
    *
    * @var mixed
    */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
