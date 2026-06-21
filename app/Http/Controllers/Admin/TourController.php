<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    /**
     * Hiển thị danh sách tour quản trị (Tích hợp bộ lọc vùng miền, từ khóa, khoảng giá)
     */
    public function index(Request $request)
    {
        // 1. Lấy dữ liệu bộ lọc và dùng trim() để loại bỏ khoảng trắng thừa
        $category_filter = $request->input('category', '');
        $search_query = trim($request->input('keyword', ''));
        $price_range_filter = $request->input('price_range', '');

        // 2. Khởi tạo câu lệnh truy vấn qua Model Tour
        $query = Tour::query();

        // 3. LOGIC PHÂN TÁCH VÙNG MIỀN: Lọc theo danh mục / vùng miền nếu có dữ liệu
        if (!empty($category_filter)) {
            $query->where('category', $category_filter);
        }

        // 4. LOGIC TÌM KIẾM: Lọc theo từ khóa tìm kiếm (Tiêu đề hoặc Địa điểm) nếu có dữ liệu
        if (!empty($search_query)) {
            $query->where(function($q) use ($search_query) {
                $q->where('title', 'LIKE', '%' . $search_query . '%')
                  ->orWhere('location', 'LIKE', '%' . $search_query . '%');
            });
        }

        // 5. LOGIC LỌC KHOẢNG GIÁ: Đồng bộ hóa xử lý phân tách khoảng giá giống Client
        if (!empty($price_range_filter)) {
            if ($price_range_filter === '0-5') {
                $query->where('price', '<', 5000000);
            } elseif ($price_range_filter === '5-10') {
                $query->whereBetween('price', [5000000, 10000000]);
            } elseif ($price_range_filter === '10+') {
                $query->where('price', '>', 10000000);
            }
        }

        // 6. CẬP NHẬT: Thay đổi số lượng phân trang từ 5 xuống còn đúng 4 bản ghi/trang
        // appends() tự động giữ lại toàn bộ các tham số lọc khi admin bấm chuyển trang sau
        $tours = $query->orderBy('id', 'desc')->paginate(4)->appends($request->all());

        // Mảng danh sách các miền để hiển thị cấu trúc select box hoặc tab trong giao diện admin
        $categories = ['Miền Bắc', 'Miền Trung', 'Miền Nam', 'Biển Đảo'];

        // 7. Trả dữ liệu về view admin kèm theo các biến trạng thái bộ lọc
        return view('admin.tours.index', compact(
            'tours', 
            'category_filter', 
            'search_query', 
            'price_range_filter', 
            'categories'
        ));
    }

    /**
     * Form thêm tour mới
     */
    public function create()
    {
        $categories = ['Miền Bắc', 'Miền Trung', 'Miền Nam', 'Biển Đảo'];
        return view('admin.tours.create', compact('categories'));
    }

    /**
     * Xử lý lưu tour mới vào cơ sở dữ liệu (POST)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required',
            'short_desc'  => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'duration'    => 'required|string|max:255', 
            'location'    => 'required|string|max:255',
            'category'    => 'required|string|max:255',
            'featured'    => 'nullable|boolean',
            'image_url'   => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Xử lý upload ảnh vào thư mục public/images
        if ($request->hasFile('image_url')) {
            $imageName = time() . '.' . $request->image_url->extension();
            $request->image_url->move(public_path('images'), $imageName);
            $data['image_url'] = $imageName;
        }

        // Ép kiểu checkbox thành giá trị boolean 1 hoặc 0 để lưu vào DB
        $data['featured'] = $request->has('featured') ? 1 : 0;
        Tour::create($data);

        return redirect()->route('admin.tours.index')
            ->with('success', 'Thêm tour mới thành công!');
    }

    /**
     * Form chỉnh sửa dữ liệu tour
     */
    public function edit(Tour $tour)
    {
        $categories = ['Miền Bắc', 'Miền Trung', 'Miền Nam', 'Biển Đảo'];
        return view('admin.tours.edit', compact('tour', 'categories'));
    }

    /**
     * Xử lý cập nhật thông tin dữ liệu (PUT/PATCH)
     */
    public function update(Request $request, Tour $tour)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required',
            'short_desc'  => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'duration'    => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'category'    => 'required|string|max:255',
            'featured'    => 'nullable|boolean',
            'image_url'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Xử lý upload ảnh mới và xóa tệp tin ảnh cũ để tiết kiệm tài nguyên máy chủ
        if ($request->hasFile('image_url')) {
            if ($tour->image_url && file_exists(public_path('images/' . $tour->image_url))) {
                @unlink(public_path('images/' . $tour->image_url));
            }
            $imageName = time() . '.' . $request->image_url->extension();
            $request->image_url->move(public_path('images'), $imageName);
            $data['image_url'] = $imageName;
        } else {
            // Nếu không chọn ảnh mới, gỡ key này ra để Eloquent giữ nguyên tên file cũ trong DB
            unset($data['image_url']);
        }

        $data['featured'] = $request->has('featured') ? 1 : 0;
        $tour->update($data);

        return redirect()->route('admin.tours.index')
            ->with('success', 'Cập nhật thông tin tour thành công!');
    }

    /**
     * Xóa vĩnh viễn tour và tệp tin ảnh kèm theo khỏi hệ thống
     */
    public function destroy(Tour $tour)
    {
        // Sử dụng dấu @ trước hàm unlink để tránh sinh ngoại lệ lỗi nếu file ảnh bị mất từ trước
        if ($tour->image_url && file_exists(public_path('images/' . $tour->image_url))) {
            @unlink(public_path('images/' . $tour->image_url));
        }
        
        $tour->delete();
        
        return redirect()->route('admin.tours.index')
            ->with('success', 'Xóa dữ liệu tour thành công!');
    }
}