<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brands;
use App\Models\Categories;
use Session;

class BrandsController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->sort??'DESC';
        $limit = $request->limit??10;
        if($request->has('q') && $request->q!='') {
            $q = $request->q;
            $data = Brands::where('title', 'LIKE', "%{$q}%")->OrderBy('id', $sort)->paginate($limit);
        } else {
            $data = Brands::OrderBy('id', $sort)->paginate($limit);
        }
        return view('backend.brands.index', compact('data'));
    }

    public function create()
    {
        $categories = Categories::where('is_active', 1)->OrderBy('id', 'DESC')->get();
        $sort_order = Brands::max('sort_order')+1;
        return view('backend.brands.create', compact('categories', 'sort_order'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data['is_active'] = 1;
        Brands::create($data);
        Session::flash('success', 'Item added successfully');
        return redirect()->route('brands.index');
    }

    public function edit($id)
    {
        $data = Brands::find($id);        
        $categories = Categories::where('is_active', 1)->OrderBy('id', 'DESC')->get();
        return view('backend.brands.edit', compact('categories', 'data'));
    }
    
    public function update($id, Request $request)
    {
        $data = $request->except('_token');
        Brands::find($id)->update($data);
        Session::flash('success', 'Item update successfully');
        return redirect()->route('brands.index');
    }

    public function status($id)
    {
        $client = Brands::find($id);
        $client->is_active = ($client->is_active==1)?0:1;
        $client->save();
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $count = count($request->ids);
        Brands::destroy($request->ids);
        Session::flash('success', "{$count} item(s) deleted");
        return redirect()->back();
    }
}
