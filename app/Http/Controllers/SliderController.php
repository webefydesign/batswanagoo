<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Media;
use Session;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->sort??'DESC';
        $limit = $request->limit??10;
        if($request->has('q') && $request->q!='') {
            $q = $request->q;
            $data = Media::where('name', 'LIKE', "%{$q}%")->OrderBy('id', $sort)->paginate($limit);
        } else {
            $data = Media::OrderBy('id', $sort)->paginate($limit);
        }
        return view('backend.sliders.index', compact('data'));
    }

    public function create()
    {
        return view('backend.sliders.create');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token', 'slider');
        $data['type'] = 'slider';
        if($request->has('slider')) { $data['meta'] = json_encode($request->slider); }
        $media = Media::create($data);
        Session::flash('success', 'Item added successfully');
        return redirect()->route('sliders.index');
    }

    public function edit($id)
    {
        $data = Media::find($id);
        $sliders = [];
        if(!empty($data['meta'])) { $sliders = json_decode($data['meta'], true); }
        return view('backend.sliders.edit',['data'=>$data, 'sliders'=>$sliders]);
    }

    public function update($id, Request $request)
    {
        $data = $request->except('slider');
        if($request->has('slider')) { $data['meta'] = json_encode($request->slider); }
        Media::find($id)->update($data);
        Session::flash('success', 'Item update successfully');
        return redirect()->route('sliders.index');
    }

    public function delete(Request $request)
    {
        $count = count($request->ids);
        Media::destroy($request->ids);
        Session::flash('success', "{$count} item(s) deleted");
        return redirect()->back();
    }
}
