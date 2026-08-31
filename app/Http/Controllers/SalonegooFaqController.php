<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SalonegooFAQs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SalonegooFaqController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->sort??'DESC';
        $limit = $request->limit??10;
        if($request->has('q') && $request->q!='') {
            $q = $request->q;
            $data = SalonegooFAQs::where('title', 'LIKE', "%{$q}%")->OrderBy('id', $sort)->paginate($limit);
        } else {
            $data = SalonegooFAQs::OrderBy('id', $sort)->paginate($limit);
        }
        return view('backend.salonegoo_faq.index', compact('data'));
    }

    public function create()
    {
        return view('backend.salonegoo_faq.create');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        SalonegooFAQs::create($data);
        Session::flash('success', 'Item added successfully');
        return redirect()->route('salonegoo_faqs.index');
    }

    public function edit($id)
    {
        $data = SalonegooFAQs::find($id);
        return view('backend.salonegoo_faq.edit', compact('data'));
    }

    public function update($id, Request $request)
    {
        $data = $request->except('_token');
        SalonegooFAQs::find($id)->update($data);
        Session::flash('success', 'Item update successfully');
        return redirect()->route('salonegoo_faqs.index');
    }

    public function status($id)
    {
        $salonegoo_faqs = SalonegooFAQs::find($id);
        $salonegoo_faqs->is_active = ($salonegoo_faqs->is_active==1)?0:1;
        $salonegoo_faqs->save();
        return redirect()->route('salonegoo_faqs.index');
    }

    public function delete(Request $request)
    {
        $count = count($request->ids);
        SalonegooFAQs::destroy($request->ids);
        Session::flash('success', "{$count} item(s) deleted");
        return redirect()->route('salonegoo_faqs.index');
    }
}
