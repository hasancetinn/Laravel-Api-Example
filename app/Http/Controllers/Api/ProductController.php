<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductWithCategoriesResource;
use App\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return Product[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request)
    {
//        return Product::all();

//        return response()->json(Product::all(),200);
//        return response(Product::paginate(10),200);
        $offset = $request->has('offset') ? $request->query('offset') : 0;
        $limit = $request->has('limit') ? $request->query('limit') : 10;

        $list = Product::query()->with('categories');
        if ($request->has('q'))
            $list->where('name', 'like', '%' . $request->query('q') . '%');

        if ($request->has('sortBy'))
            $list->orderBy($request->query('sortBy'), $request->query('sort', 'DESC'));

        $data = $list->offset($offset)->limit($limit)->get();

        $data = $data->makeHidden('slug');

        return response($data, 200);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * Model kısmında $fillable alanları gösterildiği için verileri tek tek yazmadım.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $product = Product::create($input);

        return response([
            'data' => $product,
            'message' => 'Product Created'
        ], 201);
    }

    /**
     * Display the specified resource.
     *0
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);
            return $this->apiResponse(ResultType::Success, $product, 'Product Found', 200);

        } catch (ModelNotFoundException $exception){
            return $this->apiResponse(ResultType::Error, null, 'Product Not Found', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     * Model yapısı kullanılıdğı için product otomatik gelmektedir.
     */
    public function update(Request $request, Product $product)
    {

        $product->name = $request->name;
        $product->slug = Str::slug($request->slug);
        $product->price = $request->price;
        $product->save();

        return response([
            'data' => $product,
            'message' => 'Product Updated'
        ], 201);
    }

    /**
     * @param Product $product
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        $product->delete();

        $sad = Product::with('categories')->where('created_at', null)->get();

        return response([
            'message' => 'Product Deleted.'
        ], 200);
    }

    public function custom1()
    {

        return Product::select('id', 'name')->orderBy('created_at', 'DESC')->take(10)->get();
    }

    public function custom2()
    {

        $products = Product::orderBy('created_at', 'DESC')->take(10)->get();

        $mapped = $products->map(function ($product) {
            return [
                '_id' => $product['id'],
                'product_name' => $product['name'],
                'product_price' => $product['price'] * 1.03
            ];
        });

        return $mapped->all();
    }

    public function custom3()
    {
        $products = Product::paginate(10);

        return ProductResource::collection($products);
    }

    public function listwithCategories()
    {

        $products = Product::with('categories')->paginate(10);

        return ProductWithCategoriesResource::collection($products);
    }
}
