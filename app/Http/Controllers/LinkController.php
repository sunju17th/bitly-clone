<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{
    public function index()
    {
        $links = Link::where('user_id', Auth::id())
                     ->orderBy('created_at', 'desc')
                     ->get();
        
        return view('dashboard', compact('links'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'original_url' => ['required', 'url', 'active_url', function ($attribute, $value, $fail) {
                if (!preg_match('/^http(s)?:\/\//', $value)) {
                    $fail('Đường dẫn phải bắt đầu bằng http:// hoặc https://');
                }
                // Basic Blacklist check
                $blacklist = ['l.facebook.com', 'shady-site.com'];
                $domain = parse_url($value, PHP_URL_HOST);
                if (in_array($domain, $blacklist)) {
                    $fail('Tên miền này bị cấm vì lý do bảo mật.');
                }
            }]
        ]);

        $existingLink = Link::where('original_url', $request->original_url)
                            ->where('user_id', Auth::id())
                            ->first();

        if ($existingLink) {
            return back()->with('success', 'Link này bạn đã rút gọn rồi: ' . url($existingLink->short_code));
        }

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

    public function shortenLink($short_code)
    {
        $link = Link::where('short_code', $short_code)->firstOrFail();

        $link->increment('visits');

        return redirect($link->original_url);
    }
}