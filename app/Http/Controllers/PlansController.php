<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Plans;
use App\Models\PlanCategory;
use App\Models\PlanPricing;
use App\Models\PlanPromotion;
use App\Models\PlanType;
use Session;

class PlansController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->sort??'DESC';
        $limit = $request->limit??10;
        if($request->has('q') && $request->q!='') {
            $q = $request->q;
            $data = Plans::where('name', 'LIKE', "%{$q}%")->OrderBy('id', $sort)->paginate($limit);
        } else {
            $data = Plans::OrderBy('id', $sort)->paginate($limit);
        }
        return view('backend.plans.index', compact('data'));
    }

    public function create()
    {
        // Plan Type & Categories are no longer selectable here - ad posting
        // is plan-free now, this form only records pricing/marketing info.
        return view('backend.plans.create');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data['sms'] = (isset($request->sms)) ? 1 : 0;
        $data['media_links'] = (isset($request->media_links)) ? 1 : 0;
        $data['dedicated_link'] = (isset($request->dedicated_link)) ? 1 : 0;
        // plan_type_id kept only to satisfy the legacy column - no longer user-selectable.
        $data['plan_type_id'] = optional(PlanType::first())->id;
        // $data['is_active'] = 1;
        $plan = Plans::create($data);
        // PlanCategory::creator($data, $plan); // Categories/ad-limits removed - posting is unlimited now.
        // PlanPromotion::creator($data, $plan);
        PlanPricing::creator($data, $plan);
        Session::flash('success', 'Item added successfully');
        return redirect()->route('plans.index');
    }

    public function edit($id)
    {
        $data = Plans::with('getPlanPrice', 'getPlanCategory','planType')->find($id);
        return view('backend.plans.edit', compact('data'));
    }

    public function update($id, Request $request)
    {
        $data = $request->except('_token');
        $data['sms'] = (isset($request->sms)) ? 1 : 0;
        $data['media_links'] = (isset($request->media_links)) ? 1 : 0;
        $data['dedicated_link'] = (isset($request->dedicated_link)) ? 1 : 0;
        Plans::find($id)->update($data);
        PlanPricing::dataUpdate($data, $id);
        // PlanCategory::dataUpdate($data, $id); // Categories/ad-limits removed - posting is unlimited now.

        Session::flash('success', 'Item update successfully');
        return redirect()->route('plans.index');
    }

    public function status($id)
    {
        $client = Plans::find($id);
        $client->is_active = ($client->is_active==1)?0:1;
        $client->save();
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $count = count($request->ids);
        PlanCategory::whereIn('plan_id', $request->ids??[])->delete();
        PlanPricing::whereIn('plan_id', $request->ids??[])->delete();
        Plans::destroy($request->ids);
        Session::flash('success', "{$count} item(s) deleted");
        return redirect()->back();
    }

    public function planPoints(Request $request){
        $id = $request->id;
        $plan_type = PlanType::find($id);
        
        $categories = [];
        if(isset($plan_type->categories) && count($plan_type->categories)>0){
            $categories = Categories::whereIn('parent_id', $plan_type->categories->pluck('category_id')->toArray())
            ->orderBy('parent_id', 'ASC')->orderBy('name', 'ASC')->get();
        }else{
            $categories = Categories::where('parent_id', null)->orderBy('name', 'ASC')->get();
        }


        $category = view('backend.plans.categories', ['categories' => $categories])->render();
        $points = view('backend.plans.points', ['typePoints' => ($plan_type->points)??[]])->render();

        return response()->json(['points' => $points, 'category' => $category]);
    }
}
