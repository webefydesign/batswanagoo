<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatStickers;
use Session;

class ChatStickersController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->sort ?? 'DESC';
        $limit = $request->limit ?? 10;
        if ($request->has('q') && $request->q != '') {
            $q = $request->q;
            $data = ChatStickers::where('name', 'LIKE', "%{$q}%")->orderBy('id', $sort)->paginate($limit);
        } else {
            $data = ChatStickers::orderBy('id', $sort)->paginate($limit);
        }
        return view('backend.chat_stickers.index', compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data['is_active'] = 1;
        ChatStickers::create($data);
        Session::flash('success', 'Sticker added successfully');
        return redirect()->back();
    }

    public function update($id, Request $request)
    {
        $data = $request->except('_token');
        ChatStickers::find($id)->update($data);
        Session::flash('success', 'Sticker updated successfully');
        return redirect()->back();
    }

    public function status($id)
    {
        $sticker = ChatStickers::find($id);
        $sticker->is_active = ($sticker->is_active == 1) ? 0 : 1;
        $sticker->save();
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $count = count($request->ids);
        ChatStickers::destroy($request->ids);
        Session::flash('success', "{$count} item(s) deleted");
        return redirect()->back();
    }
}



