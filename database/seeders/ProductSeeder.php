<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductGallery;
use App\Models\ProductSize;
use App\Models\ProductVariant;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // xóa trắng dl  
        Schema::disableForeignKeyConstraints();
        ProductVariant::truncate();
        ProductGallery::truncate();
        DB::table('product_tag')->truncate();
        Product::truncate();
        ProductSize::truncate();
        ProductColor::truncate();
        Tag::truncate();
        // end 

        //
        Tag::factory(15)->create();

        // Size 'S', 'M', 'L', 'XL', 'XXL' 
        foreach (['S', 'M', 'L', 'XL', 'XXL'] as $item) {
            ProductSize::create([
                'name' => $item,
            ]);
        }

        // Color 'black', 'blue', 'green', 'yellow', 'red' 
        foreach (['#00BFFF', '#00EE00', '#EE0000', '#FFB5C5', '#828282'] as $item) {
            ProductColor::create([
                'name' => $item,
            ]);
        }

        for ($i = 0; $i < 1000; $i++) {
            $name = fake()->text(100);

            Product::create([
                'catelogue_id' => rand(3, 7),
                'name' => $name,
                'slug' => Str::slug($name) . '-' . Str::random(8),
                'sku' => Str::random(8) . $i,
                'img_thumbnail' => 'https://canifa.com/img/1000/1500/resize/6/o/6ot24s002-sb001-1.webp',
                'price_regular' => 600000,
                'price_sale' => 499000,

            ]);
        }

        for ($i = 1; $i < 1001; $i++) {
            ProductGallery::insert([
                [
                    'product_id' => $i,
                    'image' => 'https://canifa.com/img/1000/1500/resize/6/o/6ot24s002-sb001-l-1-u.webp'
                ],
                [
                    'product_id' => $i,
                    'image' => 'https://canifa.com/img/1000/1500/resize/6/o/6ot24s002-sb001-1.webp'
                ],
            ]);
        }

        for ($i = 1; $i < 1001; $i++) {
            DB::table('product_tag')->insert([
                [
                    'product_id' => $i,
                    'tag_id' => rand(1, 8)
                ],
                [
                    'product_id' => $i,
                    'tag_id' => rand(9, 15)
                ],
            ]);
        }

        for ($productID = 1; $productID < 1001; $productID++) {
            $data = [];
            for ($sizeID = 1; $sizeID < 6; $sizeID++) {
                for ($colorID = 1; $colorID < 6; $colorID++) {
                    $data[] = [
                        'product_id' => $productID,
                        'product_size_id' => $sizeID,
                        'product_color_id' => $colorID,
                        'quantity' => 100,
                        'image' => 'https://canifa.com/img/1000/1500/resize/6/o/6ot24s002-sb001-1.webp',
                    ];
                }
            }
            // ProductVariant::insert($data); // dùng eloquen lâu hơn nên dùng query
            DB::table('product_variants')->insert($data);
        }
    }
}
