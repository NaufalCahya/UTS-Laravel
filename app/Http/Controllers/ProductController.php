<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;


class ProductController extends Controller
{
    //membuat data ke database
    public function store(Request $request) {
        //memvalidasi inputan
        $validator = Validator::make($request->all(),[
            'product_name' => 'required|max:50',
            'product_type' => 'required|in:snack,drink,fruit,drug,groceries,cigarette,make-up,cigarette',
            'product_price' => 'required|numeric',
            'expired_at'=> 'required|date'
        ]);
        //kondisi apabila inputan yang diinginkan tidak sesuai
        if($validator->fails()){
            //response json akan dikirim jika ada inputan yang salah
            return response() -> json($validator->messages())->setStatusCode(422);

        }

        $payload = $validator->validate();
        //masukkan inputan yang benar ke database (table product)
        Product::create([
            'product_name' => $payload['product_name'],
            'product_type' => $payload['product_type'],
            'product_price' => $payload['product_price'],
            'expired_at' => $payload['expired_at']
        ]);
        //response json akan dikirm jika inputan benar 
        return response()->json([
            'msg'=>'Data produk berhasil disimpan'
        ],201);
    }

    //membuat update ke database
    public function update(Request $request, $id) {
        //memvalidasi inputan
        $validator = Validator::make($request->all(),[
            'product_name' => 'required|max:50',
            'product_type' => 'required|in:snack,drink,fruit,drug,groceries,cigarette,make-up,cigarette',
            'product_price' => 'required|numeric',
            'expired_at'=> 'required|date'
        ]);
        //kondisi apabila inputan yang diinginkan tidak sesuai
        if($validator->fails()){
            //response json akan dikirim jika ada inputan yang salah
            return response() -> json($validator->messages())->setStatusCode(422);

        }

        $payload = $validator->validate();
        //masukkan inputan yang benar ke database (table product)
        Product::where('id',$id)->update([
            'product_name' => $payload['product_name'],
            'product_type' => $payload['product_type'],
            'product_price' => $payload['product_price'],
            'expired_at' => $payload['expired_at']
        ]);
        //response json akan dikirm jika inputan benar 
        return response()->json([
            'msg'=>'Data produk berhasil Diubah'
        ],201);
    }
    
    //membuat delete data ke database
    public function delete($id){
        $product=Product::where('id',$id)->get();

        if($product){
            Product::where('id',$id)->delete();

            //respon json akan dikirim 
            return response()->json([
                'msg' => 'Data Produk dengan ID: '.$id.' Berhasil Dihapus'
            ],200);
        }

        //response json bila ID tidak ada 
        return response()->json([
            'msg'=>'Data Produk Dengan ID: '.$id.' Tidak Ditemukan'
        ],404);
    }

    function showAll(){
        //panggil semua data produk dari tabel products
        $products = Product::all();

        //kirim response json
        return response()->json([
            'msg' => 'Data Produk Keseluruhan',
            'data' => $products
        ],200);

    }

    function showById($id){
        //mencari data berdasarkan ID produk
        $product = Product::where('id',$id)->first();

        //kondisi apabila data dengan id ada 
        if($product){

            //response ketika data ada
            return response()->json([
                'msg' => 'Data Produk Dengan ID: '.$id,
                'data' => $product
            ],200);
        }
        //response ketika data tidak ada 
        return response()->json([
            'msg' => 'Data Produk dengan ID: '.$id.' Tidak Ditemukan',
        ],400);
    }

    function showByName($product_name){
        //cari data berdasarkan nama produk yang mirip
        $product = Product::where('product_name', 'LIKE', '%'.$product_name.'%')->get();

        //apabila data produk ada
        if ($product->count()>0){
            return response()->json([
            'msg' => 'Data Produk dengan Nama yang Mirip: '.$product_name,
            'data' => $product
            ],200);
        }

        //respon ketika data tidak ada
        return response()->json([
            'msg' => 'Data Produk dengan Nama yang Mirip: '.$product_name.' Tidak Ditemukan',
        ],404);
    }

}