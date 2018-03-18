<?php

/* Require */
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/* Models */
use Bantenprov\ProdukHukum\Models\Bantenprov\ProdukHukum\ProdukHukum;

class BantenprovProdukHukumSeederProdukHukum extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
	public function run()
	{
        Model::unguard();

        $produk-hukums = (object) [
            (object) [
                'user_id' => '1',
                'group_egovernment_id' => '1',
                'label' => 'GroupEgovernment 1',
                'description' => 'GroupEgovernment satu'
            ],
            (object) [
                'user_id' => '2',
                'group_egovernment_id' => '2',
                'label' => 'GroupEgovernment 2',
                'description' => 'GroupEgovernment dua',
            ]
        ];

        foreach ($produk-hukums as $produk-hukum) {
            $model = ProdukHukum::updateOrCreate(
                [
                    'user_id' => $produk-hukum->user_id,
                    'group_egovernment_id' => $produk-hukum->group_egovernment_id,
                    'label' => $produk-hukum->label,
                    'description' => $produk-hukum->description,
                ]
            );
            $model->save();
        }
	}
}
