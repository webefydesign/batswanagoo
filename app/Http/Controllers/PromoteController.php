<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Promote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PromoteController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->sort??'DESC';
        $limit = $request->limit??10;
        if($request->has('q') && $request->q!='') {
            $q = $request->q;
            $data = Promote::where('name', 'LIKE', "%{$q}%")->OrderBy('id', $sort)->paginate($limit);
        } else {
            $data = Promote::OrderBy('id', $sort)->paginate($limit);
        }
        return view('backend.promotes.index', compact('data'));
    }

    public function create()
    {
        return view('backend.promotes.create');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        // $data['is_active'] = 1;
        if(isset($data['promote'])){
            $promote = [];
            foreach($data['promote'] as $pr){ $promote[] = $pr; }
            $data['promote'] = $promote;
        }
        Promote::create($data);
        Session::flash('success', 'Item added successfully');
        return redirect()->route('promote.index');
    }

    public function edit($id)
    {
        $data = Promote::find($id);
        return view('backend.promotes.edit', compact('data'));
    }

    public function update($id, Request $request)
    {
        $data = $request->except('_token');
        $data['is_active'] = (isset($request->is_active))?1:0;
        if(isset($data['promote'])){
            $promote = [];
            foreach($data['promote'] as $pr){ $promote[] = $pr; }
            $data['promote'] = $promote;
        }
        Promote::find($id)->update($data);
        Session::flash('success', 'Item update successfully');
        return redirect()->route('promote.index');
    }

    public function status($id)
    {
        $promote = Promote::find($id);
        $promote->is_active = ($promote->is_active==1)?0:1;
        $promote->save();
        return redirect()->route('promote.index');
    }

    public function delete(Request $request)
    {
        $count = count($request->ids);
        Promote::destroy($request->ids);
        Session::flash('success', "{$count} item(s) deleted");
        return redirect()->route('promote.index');
    }
}
