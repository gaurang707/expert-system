<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->input('resetbutton') && $request->input('resetbutton') == "resetbutton") {
            $searchTerm = '';
        } else {
            $searchTerm = $request->input('search');
        }

        if ($searchTerm) {
            $searchTerm = trim($searchTerm);
        }

        if ($searchTerm) {
            $query = Product::select('id', 'name', 'description', 'price')
                ->where('name', 'LIKE', "%{$searchTerm}%")
                ->orWhere('description', 'LIKE', "%{$searchTerm}%");
        } else {
            $query = Product::select('id', 'name', 'description', 'price');
        }

        //dd($query->toRawSql());

        $products = $query->get();

        //dd( $products);
        return view('basic.product_search', compact('products', 'searchTerm'));
    }
}
