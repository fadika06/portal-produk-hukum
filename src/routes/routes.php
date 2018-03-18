<?php

Route::group(['prefix' => 'api/produk-hukum', 'middleware' => ['web']], function() {
    $controllers = (object) [
        'index'     => 'Bantenprov\ProdukHukum\Http\Controllers\ProdukHukumController@index',
        'create'    => 'Bantenprov\ProdukHukum\Http\Controllers\ProdukHukumController@create',
        'show'      => 'Bantenprov\ProdukHukum\Http\Controllers\ProdukHukumController@show',
        'store'     => 'Bantenprov\ProdukHukum\Http\Controllers\ProdukHukumController@store',
        'edit'      => 'Bantenprov\ProdukHukum\Http\Controllers\ProdukHukumController@edit',
        'update'    => 'Bantenprov\ProdukHukum\Http\Controllers\ProdukHukumController@update',
        'destroy'   => 'Bantenprov\ProdukHukum\Http\Controllers\ProdukHukumController@destroy',
    ];

    Route::get('/',             $controllers->index)->name('produk-hukum.index');
    Route::get('/create',       $controllers->create)->name('produk-hukum.create');
    Route::get('/{id}',         $controllers->show)->name('produk-hukum.show');
    Route::post('/',            $controllers->store)->name('produk-hukum.store');
    Route::get('/{id}/edit',    $controllers->edit)->name('produk-hukum.edit');
    Route::put('/{id}',         $controllers->update)->name('produk-hukum.update');
    Route::delete('/{id}',      $controllers->destroy)->name('produk-hukum.destroy');
});
