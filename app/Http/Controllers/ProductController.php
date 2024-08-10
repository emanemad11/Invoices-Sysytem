<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $sections = Section::all();
        $products = Product::all();
        return view('products.products', compact('sections','products'));
    }

    public function store(Request $request)
    {
        Product::create([
            'Product_name'    => $request->Product_name,
            'section_id'      => $request->section_id,
            'description'     => $request->description,
        ]);

        session()->flash('Add', 'تم إضافة المنتج بنجاح');
        return back();
    }

    public function update(Request $request)
    {
        $sectionId = Section::where('section_name', $request->section_name)->firstOrFail()->id;

        $product = Product::findOrFail($request->pro_id);
        $product->update([
            'Product_name'    => $request->Product_name,
            'description'     => $request->description,
            'section_id'      => $sectionId,
        ]);

        session()->flash('Edit', 'تم تعديل المنتج بنجاح');
        return back();
    }

    public function destroy(Request $request)
    {
        $product = Product::findOrFail($request->pro_id);
        $product->delete();

        session()->flash('delete', 'تم حذف المنتج بنجاح');
        return back();
    }
}
