<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class GuestController extends Controller
{
    public function dashboard(Request $request) {

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
        return view('dashboard', compact('products'));
    }
}
