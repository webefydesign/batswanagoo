<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Make;
use App\Models\MakeModels;
use Session;

class MakeController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->sort??'DESC';
        $limit = $request->limit??10;
        if($request->has('q') && $request->q!='') {
            $q = $request->q;
            $data = Make::where('name', 'LIKE', "%{$q}%")->OrderBy('id', $sort)->paginate($limit);
        } else {
            $data = Make::OrderBy('id', $sort)->paginate($limit);
        }
        return view('backend.make.index', compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data['is_active'] = 1;
        Make::create($data);
        Session::flash('success', 'Item added successfully');
        return redirect()->back();
    }

    public function update($id, Request $request)
    {
        $data = $request->except('_token');
        Make::find($id)->update($data);
        Session::flash('success', 'Item update successfully');
        return redirect()->back();
    }

    public function status($id)
    {
        $client = Make::find($id);
        $client->is_active = ($client->is_active==1)?0:1;
        $client->save();
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $count = count($request->ids);
        Make::destroy($request->ids);
        Session::flash('success', "{$count} item(s) deleted");
        return redirect()->back();
    }

    public function fetchMakeModels(Request $request){
        $data = $request->all();
        if(isset($data['id']) && $data['id']!=null){
            $models = MakeModels::where('make_id', $data['id'])->orderBy('name', 'ASC')->get();
            $html = ($data['start'])??'<option value="">Select your model</option>';
            foreach ($models as $model) {
                $v = (isset($data['start']))?$model->id:$model->name;
                $html .= '<option value="'.$v.'">'.$model->name.'</option>';
            }
        }
        return response()->json(['models'=>$html]);
    }
}
