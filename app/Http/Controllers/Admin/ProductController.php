<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catelogue;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductGallery;
use App\Models\ProductSize;
use App\Models\ProductVariant;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const PATH_VIEW = 'admin.products.';
    public function index()
    {
        //
        $data = Product::with(['catelogue', 'tags'])->latest('id')->get();
        // dd($data->first()->catelogue->name);

        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $catelogues = Catelogue::pluck('name', 'id')->all();
        $colors = ProductColor::pluck('name', 'id')->all();
        $sizes = ProductSize::pluck('name', 'id')->all();
        $tags = Tag::pluck('name', 'id')->all();
        return view(self::PATH_VIEW . __FUNCTION__, compact('catelogues', 'colors', 'sizes', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    //     // dd($request->all());


    //     $dataProduct = $request->except('product_variants', 'tag', 'product_galleries');
    //     $dataProductVariants = $request->product_variants;

    //     $dataProduct['is_active'] = isset($dataProduct['is_active']) ? 1 : 0;
    //     $dataProduct['is_hot_deal'] = isset($dataProduct['is_hot_deal']) ? 1 : 0;
    //     $dataProduct['is_good_deal'] = isset($dataProduct['is_good_deal']) ? 1 : 0;
    //     $dataProduct['	is_new'] = isset($dataProduct['is_new']) ? 1 : 0;
    //     $dataProduct['is_show_home'] = isset($dataProduct['is_show_home']) ? 1 : 0;
    //     $dataProduct['slug'] = Str::slug($dataProduct['name']) . '-' . $dataProduct['sku'];
    // // dd($dataProduct);
    //     if ($dataProduct['img_thumbnail']) {
    //         $dataProduct['img_thumbnail'] = Storage::put('products', $dataProduct['img_thumbnail']);
    //     }


    //     $dataProductVariantsTmp = $request->product_variants;
    //     $dataProductVariants = [];

    //     foreach ($dataProductVariantsTmp as $key => $item) {
    //         $tmp = explode('-', $key);
    //         $dataProductVariants[] = [
    //             'product_size_id' => $tmp[0],
    //             'product_color_id' => $tmp[1],
    //             'quantity' => $item['quantity'],
    //             'image' => $item['image'] ?? null,
    //         ];
    //     }
    //     // dd($dataProductVariants);
    //     $dataProductTags = $request->tags;
    //     $dataProductGalleries = $request->product_galleries ?: [];

    //     try {
    //         DB::beginTransaction();

    //         /** @var Product $product */
    //         $product = Product::create($dataProduct);
    //         foreach ($dataProductVariants as $dataProductVariant) {
    //             $dataProductVariant['product_id'] = $product->id;
    //             if ($dataProductVariant['image']) {
    //                 $dataProductVariant['image'] = Storage::put('products', $dataProductVariant['image']);
    //             }
    //             ProductVariant::create($dataProductVariant);
    //         }

    //         $product->tags()->sync($dataProductTags);
    //         foreach ($dataProductGalleries as $image) {
    //             ProductGallery::create([
    //                 'product_id' => $product->id,
    //                 'image' => Storage::put('products', $image),
    //             ]);
    //         }
    //         DB::commit();

    //         return redirect()->route('admin.products.index');
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         return back()->withErrors(['error' => $th->getMessage()]);
    //     }
    // }
    /**
     * Display the specified resource.
     */

    public function store(Request $request)
    {
        // Kiểm tra dữ liệu gửi lên
        // dd($request->all());

        $dataProduct = $request->except('product_variants', 'tags', 'product_galleries');
        $dataProductVariants = $request->product_variants;

        // Thiết lập các giá trị boolean cho các checkbox
        $dataProduct['is_active'] = isset($dataProduct['is_active']) ? 1 : 0;
        $dataProduct['is_hot_deal'] = isset($dataProduct['is_hot_deal']) ? 1 : 0;
        $dataProduct['is_good_deal'] = isset($dataProduct['is_good_deal']) ? 1 : 0;
        $dataProduct['is_new'] = isset($dataProduct['is_new']) ? 1 : 0;
        $dataProduct['is_show_home'] = isset($dataProduct['is_show_home']) ? 1 : 0;

        $dataProduct['slug'] = Str::slug($dataProduct['name']) . '-' . $dataProduct['sku'];

        // Xử lý ảnh thumbnail nếu có
        if (isset($dataProduct['img_thumbnail'])) {
            $dataProduct['img_thumbnail'] = Storage::put('products', $dataProduct['img_thumbnail']);
        }

        // Khởi tạo mảng để lưu trữ các biến thể của sản phẩm
        $dataProductVariantsTmp = $request->product_variants;
        $dataProductVariants = [];

        // Xử lý từng biến thể sản phẩm
        foreach ($dataProductVariantsTmp as $key => $item) {
            $tmp = explode('-', $key);
            $dataProductVariants[] = [
                'product_size_id' => $tmp[0],
                'product_color_id' => $tmp[1],
                'quantity' => $item['quantity'],
                'image' => $item['image'] ?? null,
            ];
        }

        // lấy tags và galleries từ request
        $dataProductTags = $request->tags;
        $dataProductGalleries = $request->product_galleries ?: [];

        try {
          
            DB::beginTransaction();

            $product = Product::create($dataProduct);

            // Tạo từng biến thể sản phẩm và xử lý ảnh của nó
            foreach ($dataProductVariants as $dataProductVariant) {
                $dataProductVariant['product_id'] = $product->id;
                if ($dataProductVariant['image']) {
                    $dataProductVariant['image'] = Storage::put('products', $dataProductVariant['image']);
                }
                ProductVariant::create($dataProductVariant);
            }

            $product->tags()->sync($dataProductTags);

            // Tạo galleries cho sản phẩm
            foreach ($dataProductGalleries as $image) {
                ProductGallery::create([
                    'product_id' => $product->id,
                    'image' => Storage::put('products', $image),
                ]);
            }

            DB::commit();

            return redirect()->route('admin.products.index');
        } catch (\Throwable $th) {
            // Hoàn tác giao dịch trong trường hợp xảy ra lỗi
            DB::rollBack();
            // Hiển thị chi tiết lỗi
            // dd($th);
            return back()->withErrors(['error' => $th->getMessage()]);
        }
    }

    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
