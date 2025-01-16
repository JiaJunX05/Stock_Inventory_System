<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request) {

        if ($request->ajax()) {
            $query = Product::query();
    
            // 处理搜索查询
            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('category', 'like', '%' . $request->search . '%');
                });
            }
    
            // 分页处理
            $perPage = $request->input('length', 10); // 每页显示条数，默认 10
            $page = $request->input('page', 1); // 当前页码，默认第 1 页
            $products = $query->paginate($perPage, ['*'], 'page', $page);
    
            // 返回 JSON 响应
            return response()->json([
                'data' => $products->items(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'total' => $products->total(),
            ]);
        }
    
        // 非 AJAX 请求，返回视图
        $products = Product::all(); // 不再默认按名称排序
        return view('admin.dashboard', compact('products'));
    }    

    public function showCreateForm() {
        return view('admin.create');
    }

    public function create(Request $request) {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255', //unique:products,name
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
        ]);

        // 手动检查产品名称是否已存在
        $existingProduct = Product::where('name', $request->name)->first();

        if ($existingProduct) {
            // 如果产品名称已经存在，手动添加错误消息
            return back()->withErrors(['name' => 'The product name has already been taken.'])->withInput();
        }

        if ($imageFile = $request->file('image')) {
            $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('assets/images'), $imageName); // 将图片保存到 public/assets/images 目录
        }

        $products = Product::create([
            'image' => 'images/' . $imageName,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category' => $request->category,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Product created successfully');
    }

    public function view($id) {
        $product = Product::findOrFail($id);
        return view('admin.view', compact('product'));
    }

    public function showEditForm($id) {
        $product = Product::findOrFail($id);
        return view('admin.edit', compact('product'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Make image validation optional
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
        ]);
    
        $product = Product::find($id);
    
        // Check if a new image has been uploaded
        if ($request->hasFile('image')) {
            // Delete the old image from the storage if a new one is being uploaded
            if ($product->image && file_exists(public_path('assets/' . $product->image))) {
                unlink(public_path('assets/' . $product->image));
            }
    
            // Save the new image
            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('assets/images'), $imageName);
            $product->image = 'images/' . $imageName;
        }
    
        // Update other product details
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->category = $request->category;
        $product->save();
    
        return redirect()->route('admin.dashboard')->with('success', 'Product updated successfully');
    }

    public function showStockForm($id) {
        $product = Product::find($id);
        return view('admin.stock', compact('product'));
    }
    
    public function stockUpdate(Request $request, $id) {
        $product = Product::find($id);

        $request->validate([
            'stock_quantity' => 'required|integer|min:1',
            'status' => 'required|in:stock_in,stock_out',
        ]);

        $stock_quantity = $request->stock_quantity;
        $status = $request->status;

        if ($status === 'stock_in') {
            $product->quantity += $stock_quantity;
        } elseif ($status === 'stock_out') {
            if ($product->quantity < $stock_quantity) {
                return back()->withErrors('Stock quantity exceeds available stock.');
            }
            $product->quantity -= $stock_quantity;
        }

        $product->save();

        return redirect()->route('admin.dashboard', $id)->with('success', 'Stock updated successfully.');
    }

    public function destroy($id) {
        $product = Product::find($id);
    
        // Get the image file path
        $imagePath = public_path('assets/' . $product->image);
    
        // Check if the image file exists and delete it
        if (file_exists($imagePath)) {
            unlink($imagePath); // Delete the file from the directory
        }
    
        // Delete the product record from the database
        $product->delete();
    
        // Redirect back to the dashboard with a success message
        return redirect()->route('admin.dashboard')->with('success', 'Product and its image deleted successfully');
    }    
}