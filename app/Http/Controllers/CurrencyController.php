<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Countries;
use App\Models\Currencies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CurrencyController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->sort??'DESC';
        $limit = $request->limit??10;
        if($request->has('q') && $request->q!='') {
            $q = $request->q;
            $data = Currencies::where('name', 'LIKE', "%{$q}%")->OrderBy('id', $sort)->paginate($limit);
        } else {
            $data = Currencies::OrderBy('id', $sort)->paginate($limit);
        }
        return view('backend.currency.index', compact('data'));
    }

    public function create()
    {
        $countries = Countries::where('status',1)->get();
        $default = Currencies::where('is_default',1)->first();
        return view('backend.currency.create', compact('countries','default'));
    }

    public function store(Request $request)
    {
        $currencies = Currencies::where('is_default',1)->first();
        $data = $request->except('_token');
        if(!isset($currencies)){
            $data['is_default'] = 1;
        }
        Currencies::create($data);
        Session::flash('success', 'Item added successfully');
        return redirect()->route('currencies.index');
    }

    public function edit($id)
    {
        $countries = Countries::where('status',1)->get();
        $default = Currencies::where('is_default',1)->first();
        $data = Currencies::find($id);
        return view('backend.currency.edit', compact('data','countries','default'));
    }

    public function update($id, Request $request)
    {
        $data = $request->except('_token');
        Currencies::find($id)->update($data);
        Session::flash('success', 'Item update successfully');
        return redirect()->route('currencies.index');
    }

    public function status($id)
    {
        $currencies = Currencies::find($id);
        $currencies->is_active = ($currencies->is_active==1)?0:1;
        $currencies->save();
        return redirect()->route('currencies.index');
    }

    public function delete(Request $request)
    {
        $count = count($request->ids);
        Currencies::destroy($request->ids);
        Session::flash('success', "{$count} item(s) deleted");
        return redirect()->route('currencies.index');
    }
}
