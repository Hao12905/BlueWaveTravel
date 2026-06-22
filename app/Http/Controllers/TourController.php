<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    /**
     * Trang chủ hệ thống công khai
     */
    public function index()
    {
        // Lấy danh sách 4 tour nổi bật (featured = 1) mới nhất để hiển thị ở trang chủ
        $tours = Tour::where('featured', 1)->orderBy('id', 'desc')->take(4)->get();

        return view('home', compact('tours')); 
    }

    /**
     * Xử lý hiển thị trang danh sách Tours + Lọc Theo Miền + Tìm kiếm
     */
    public function tours(Request $request)
    {
        // 1. Đồng bộ giá trị category lấy từ Tab hoặc lấy từ thanh Tìm kiếm nâng cao
        $category_filter = $request->input('category');
        if (empty($category_filter) && $request->filled('select_category')) {
            $category_filter = $request->input('select_category');
        }

        $search_query = trim($request->input('keyword', ''));
        $price_range_filter = $request->input('price_range', '');

        $query = Tour::query();

        // 2. Thực thi lọc theo Vùng miền
        if (!empty($category_filter)) {
            $query->where('category', $category_filter);
        }

        // 3. Tìm kiếm theo Từ khóa (Tiêu đề hoặc Địa điểm)
        if (!empty($search_query)) {
            $query->where(function($q) use ($search_query) {
                $q->where('title', 'LIKE', '%' . $search_query . '%')
                  ->orWhere('location', 'LIKE', '%' . $search_query . '%');
            });
        }

        // 4. Lọc dữ liệu theo phân khúc tầm giá
        if (!empty($price_range_filter)) {
            if ($price_range_filter === '0-5') {
                $query->where('price', '<', 5000000);
            } elseif ($price_range_filter === '5-10') {
                $query->whereBetween('price', [5000000, 10000000]);
            } elseif ($price_range_filter === '10+') {
                $query->where('price', '>', 10000000);
            }
        }

        $tours = $query->orderBy('id', 'desc')->paginate(8)->appends($request->all());

        return view('tours', compact('tours'));
    }

    /**
     * Chi tiết hành trình Tour
     */
    public function show($id)
    {
        $tour = Tour::findOrFail($id);
        
        return view('tour-detail', compact('tour'));
    }
}