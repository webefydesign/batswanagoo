<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlanType;
use App\Models\Categories;
use App\Models\PlanTypeCategory;
use Session;

class PlanTypeController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->sort??'DESC';
        $limit = $request->limit??10;
        if($request->has('q') && $request->q!='') {
            $q = $request->q;
            $data = PlanType::where('title', 'LIKE', "%{$q}%")->OrderBy('id', $sort)->paginate($limit);
        } else {
            $data = PlanType::OrderBy('id', $sort)->paginate($limit);
        }
        return view('backend.plan-types.index', compact('data'));
    }

    public function create()
    {
        $categories = Categories::whereNull('parent_id')->where('is_active', 1)->OrderBy('id', 'DESC')->get();
        return view('backend.plan-types.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token', 'categories');
        $data['is_active'] = 1;
        $plan_type = PlanType::create($data);
        if($request->has('categories')){
            foreach ($request->categories as $cat) {
                PlanTypeCategory::create(['plan_type_id'=>$plan_type['id'], 'category_id'=>$cat]);
            }
        }
        Session::flash('success', 'Item added successfully');
        return redirect()->route('plan-types.index');
    }

    public function edit($id)
    {
        $data = PlanType::find($id);        
        $categories = Categories::whereNull('parent_id')->where('is_active', 1)->OrderBy('id', 'DESC')->get();
        return view('backend.plan-types.edit', compact('categories', 'data'));
    }
    
    public function update($id, Request $request)
    {
        $data = $request->except('_token', 'categories');
        PlanType::find($id)->update($data);
        PlanTypeCategory::where('plan_type_id', $id)->delete();
        if($request->has('categories')){
            foreach ($request->categories as $cat) {
                PlanTypeCategory::create(['plan_type_id'=>$id, 'category_id'=>$cat]);
            }
        }
        Session::flash('success', 'Item update successfully');
        return redirect()->route('plan-types.index');
    }

    public function status($id)
    {
        $client = PlanType::find($id);
        $client->is_active = ($client->is_active==1)?0:1;
        $client->save();
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $count = count($request->ids);
        PlanTypeCategory::whereIn('plan_type_id', $request->ids??[])->delete();
        PlanType::destroy($request->ids);
        Session::flash('success', "{$count} item(s) deleted");
        return redirect()->back();
    }
}
