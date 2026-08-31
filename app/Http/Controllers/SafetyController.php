<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Safety;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SafetyController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->sort??'DESC';
        $limit = $request->limit??10;
        if($request->has('q') && $request->q!='') {
            $q = $request->q;
            $data = Safety::where('title', 'LIKE', "%{$q}%")->OrderBy('id', $sort)->paginate($limit);
        } else {
            $data = Safety::OrderBy('id', $sort)->paginate($limit);
        }
        return view('backend.safety.index', compact('data'));
    }

    public function create()
    {
        return view('backend.safety.create');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        Safety::create($data);
        Session::flash('success', 'Item added successfully');
        return redirect()->route('safeties.index');
    }

    public function edit($id)
    {
        $data = Safety::find($id);
        return view('backend.safety.edit', compact('data'));
    }

    public function update($id, Request $request)
    {
        $data = $request->except('_token');
        Safety::find($id)->update($data);
        Session::flash('success', 'Item update successfully');
        return redirect()->route('safeties.index');
    }

    public function status($id)
    {
        $safeties = Safety::find($id);
        $safeties->is_active = ($safeties->is_active==1)?0:1;
        $safeties->save();
        return redirect()->route('safeties.index');
    }

    public function delete(Request $request)
    {
        $count = count($request->ids);
        Safety::destroy($request->ids);
        Session::flash('success', "{$count} item(s) deleted");
        return redirect()->route('safeties.index');
    }
}
