<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fields;
use App\Models\Make;
use App\Models\MakeModels;
use App\Models\Brands;
use App\Models\BodyTypes;
use Session;

class FieldsController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->sort??'DESC';
        $limit = $request->limit??10;
        if($request->has('q') && $request->q!='') {
            $q = $request->q;
            $data = Fields::where('name', 'LIKE', "%{$q}%")->OrderBy('updated_at', $sort)->paginate($limit);
        } else {
            $data = Fields::OrderBy('updated_at', $sort)->paginate($limit);
        }
        $makes = Make::where('is_active', 1)->count();
        $models = MakeModels::where('is_active', 1)->count();
        $brands = Brands::where('is_active', 1)->count();
        $body_types = BodyTypes::where('is_active', 1)->count();
        return view('backend.fields.index', compact('data', 'makes', 'models', 'brands', 'body_types'));
    }

    public function create()
    {
        return view('backend.fields.create');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data['is_active'] = 1;
        Fields::create($data);
        Session::flash('success', 'Item added successfully');
        return redirect()->route('fields.index');
    }

    public function edit($id)
    {
        $data = Fields::find($id);        
        return view('backend.fields.edit', compact('data'));
    }
    
    public function update($id, Request $request)
    {
        $data = $request->except('_token');
        $data['data']['options'] = implode(',', $data['data']['options']);
        Fields::find($id)->update($data);
        Session::flash('success', 'Item update successfully');
        return redirect()->route('fields.index');
    }

    public function status($id)
    {
        $client = Fields::find($id);
        $client->is_active = ($client->is_active==1)?0:1;
        $client->save();
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $count = count($request->ids);
        Fields::destroy($request->ids);
        Session::flash('success', "{$count} item(s) deleted");
        return redirect()->back();
    }
}
