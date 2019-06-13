<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Model\ProductInfo;

class Products extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        ProductInfo::truncate();
        $faker = Faker::create("zh-TW");
        foreach ( range(1, 110) as $key) 
        {
            if ($key < 10) 
                $pId = 'PL00'.$key;
            elseif ($key >= 10 && $key <= 99) 
                $pId = 'PL0'.$key;
            elseif ($key)
                $pId = 'PL'.$key;
            ProductInfo::create([
                'pId' => $pId,
                'pName' => $faker->word,
                'pUnit' => $faker->randomElement([
                                '個',
                                '張',
                                '打',
                                '本',
                                '朵',
                                '桶',
                                '件',
                                '輛',
                                '把',
                                '塊',
                            ]),
                'pPrice' => $faker->randomNumber(3),
            ]);
        }
    }
}
