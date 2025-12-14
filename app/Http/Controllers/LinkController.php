<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Illuminate\Support\Str; // Dùng để tạo chuỗi ngẫu nhiên
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{
    // 1. Hiển thị danh sách link của User (Dashboard)
    public function index()
    {
        $links = Link::where('user_id', Auth::id())
                     ->orderBy('created_at', 'desc')
                     ->get();
        
        return view('dashboard', compact('links'));
    }

    // 2. Logic tạo link rút gọn (Store)
    public function store(Request $request)
    {
        // 1. Validate dữ liệu
        $request->validate([
            'original_url' => 'required|url'
        ]);

        // 2. KIỂM TRA TỒN TẠI 
        // Tìm xem trong Database có link này của User này chưa?
        $existingLink = Link::where('original_url', $request->original_url)
                            ->where('user_id', Auth::id()) // Quan trọng: Chỉ check link của chính người đó
                            ->first();

        // Nếu tìm thấy, trả về luôn link cũ, không tạo mới nữa
        if ($existingLink) {
            return back()->with('success', 'Link này bạn đã rút gọn rồi: ' . url($existingLink->short_code));
        }

        // 3. Nếu chưa có thì mới tạo mới (Code cũ giữ nguyên)
        do {
            $short_code = Str::random(6);
        } while (Link::where('short_code', $short_code)->exists());

        Link::create([
            'original_url' => $request->original_url,
            'short_code'   => $short_code,
            'user_id'      => Auth::id(),
            'visits'       => 0
        ]);

        return back()->with('success', 'Link rút gọn mới: ' . url($short_code));
    }

    // 3. Logic chuyển hướng (Redirect)
    public function shortenLink($short_code)
    {
        // Tìm link trong DB theo short_code
        $link = Link::where('short_code', $short_code)->firstOrFail();

        // Tăng số lượt click (Analytics đơn giản)
        $link->increment('visits');

        // Chuyển hướng tới link gốc
        return redirect($link->original_url);
    }
}