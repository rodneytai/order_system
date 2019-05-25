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
        foreach ( range(1, 100) as $key) 
        {
        	ProductInfo::create([
        		'pId' => 'PL0'.$key,
        		'pName' => $faker->word,
        		'pUnit' => '個',
        		'pPrice' => $faker->randomNumber(2),
        	]);
        }
    }
}
