<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();

        return view('admin.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'status' => 'required|in:active,hidden',
            'description' => 'nullable|string',
        ]);

        $category = Category::create([
            'name' => $validated['name'],
            'status' => $validated['status'],
            'description' => $validated['description'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Danh mục đã được tạo thành công.',
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
                'status' => $category->status,
            ],
        ]);
    }

    public function update(Request $request, int $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'status' => 'required|in:active,hidden',
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name' => $validated['name'],
            'status' => $validated['status'],
            'description' => $validated['description'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Danh mục đã được cập nhật thành công.',
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
                'status' => $category->status,
            ],
        ]);
    }

    public function destroy(int $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Danh mục đã được xóa thành công.',
        ]);
    }
}
