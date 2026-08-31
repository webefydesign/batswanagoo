<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Countries;
use App\Models\FAQs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->sort??'DESC';
        $limit = $request->limit??10;
        if($request->has('q') && $request->q!='') {
            $q = $request->q;
            $data = FAQs::where('title', 'LIKE', "%{$q}%")->OrderBy('id', $sort)->paginate($limit);
        } else {
            $data = FAQs::OrderBy('id', $sort)->paginate($limit);
        }
        return view('backend.faq.index', compact('data'));
    }

    public function create()
    {
        return view('backend.faq.create');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        FAQs::create($data);
        Session::flash('success', 'Item added successfully');
        return redirect()->route('faqs.index');
    }

    public function edit($id)
    {
        $data = FAQs::find($id);
        return view('backend.faq.edit', compact('data'));
    }

    public function update($id, Request $request)
    {
        $data = $request->except('_token');
        FAQs::find($id)->update($data);
        Session::flash('success', 'Item update successfully');
        return redirect()->route('faqs.index');
    }

    public function status($id)
    {
        $faqs = FAQs::find($id);
        $faqs->is_active = ($faqs->is_active==1)?0:1;
        $faqs->save();
        return redirect()->route('faqs.index');
    }

    public function delete(Request $request)
    {
        $count = count($request->ids);
        FAQs::destroy($request->ids);
        Session::flash('success', "{$count} item(s) deleted");
        return redirect()->route('faqs.index');
    }
}
