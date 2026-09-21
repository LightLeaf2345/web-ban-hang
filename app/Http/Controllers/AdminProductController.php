<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->orderBy('id', 'desc')->get();
        $categories = Category::all();
        return view('admin.products', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:products,sku',
            'category_id' => 'required|integer',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
            'image_file' => 'nullable|image|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Create uploads folder if not exists
            if (!File::exists(public_path('uploads'))) {
                File::makeDirectory(public_path('uploads'), 0755, true);
            }
            
            $file->move(public_path('uploads'), $filename);
            $imagePath = '/uploads/' . $filename;
        }

        $product = Product::create([
            'name' => $validated['name'],
            'sku' => $validated['sku'],
            'category_id' => $validated['category_id'],
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
            'status' => $validated['status'],
            'description' => $validated['description'] ?? '',
            'image' => $imagePath ?? '/images/default-product.png'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được đăng bán thành công!',
            'product' => $product
        ]);
    }

    public function update(Request $request, int $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:products,sku,' . $id,
            'category_id' => 'required|integer',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
            'image_file' => 'nullable|image|max:2048'
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            if (!File::exists(public_path('uploads'))) {
                File::makeDirectory(public_path('uploads'), 0755, true);
            }
            
            $file->move(public_path('uploads'), $filename);
            
            // Delete old image if it is local
            if ($product->image && str_starts_with($product->image, '/uploads/')) {
                File::delete(public_path($product->image));
            }
            
            $imagePath = '/uploads/' . $filename;
        }

        $product->update([
            'name' => $validated['name'],
            'sku' => $validated['sku'],
            'category_id' => $validated['category_id'],
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
            'status' => $validated['status'],
            'description' => $validated['description'] ?? '',
            'image' => $imagePath
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật sản phẩm thành công!',
            'product' => $product
        ]);
    }

    public function destroy(int $id)
    {
        $product = Product::findOrFail($id);
        
        // Delete image if exists
        if ($product->image && str_starts_with($product->image, '/uploads/')) {
            File::delete(public_path($product->image));
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa sản phẩm khỏi hệ thống!'
        ]);
    }
}
