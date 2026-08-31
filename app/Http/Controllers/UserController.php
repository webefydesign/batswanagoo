<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserGroups;
use App\Models\UserLog;
use Session;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->sort??'DESC';
        $limit = $request->limit??10;
        if($request->has('q') && $request->q!='') {
            $q = $request->q;
            $data = User::where('name', 'LIKE', "%{$q}%")->where('group_id', "!=",null)->where('user_type', 'admin')->OrderBy('id', $sort)->paginate($limit);
        } else {
            $data = User::where('group_id', "!=",null)->where('user_type', 'admin')->OrderBy('id', $sort)->paginate($limit);
        }
        $groups = UserGroups::OrderBy('name')->get();
        return view('backend.users.index', compact('data', 'groups'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        ]);
        $data['user_type'] = 'admin';
        $data['is_active'] = 1;
        $data['is_verified'] = 1;
        $data['password'] = bcrypt($request->password);
        User::create($data);
        Session::flash('success', 'User added successfully');
        return redirect()->back();
    }
    
    public function update($id, Request $request)
    {
        $data = $request->except('_token', 'password');
        if($request->has('password') && $request->password!='') {
            $data['password'] = bcrypt($request->password);
        }
        $data['user_type'] = 'admin';
        User::find($id)->update($data);
        Session::flash('success', 'User update successfully');
        return redirect()->back();
    }

    public function status($id)
    {
        $client = User::find($id);
        $client->is_active = ($client->is_active==1)?0:1;
        $client->is_verified = ($client->is_verified==1)?0:1;
        $client->save();
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $count = count($request->ids);
        User::destroy($request->ids);
        Session::flash('success', "{$count} users(s) deleted");
        return redirect()->back();
    }

    public function logs(Request $request)
    {
        $sort = $request->sort??'DESC';
        $limit = $request->limit??10;
        if($request->has('q') && $request->q!='') {
            $q = $request->q;
            $data = UserLog::where('description', 'LIKE', "%{$q}%")->where('user_type', 'admin')->OrderBy('id', $sort)->paginate($limit);
        } else {
            $data = UserLog::where('user_type', 'admin')->OrderBy('id', $sort)->paginate($limit);
        }
        return view('backend.users.logs', compact('data'));
    }
    
    public function customer_logs(Request $request)
    {
        $sort = $request->sort??'DESC';
        $limit = $request->limit??10;
        if($request->has('q') && $request->q!='') {
            $q = $request->q;
            $data = UserLog::where('description', 'LIKE', "%{$q}%")->where('user_type', 'customer')->OrderBy('id', $sort)->paginate($limit);
        } else {
            $data = UserLog::where('user_type', 'customer')->OrderBy('id', $sort)->paginate($limit);
        }
        return view('backend.customers.logs', compact('data'));
    }

    public function customers(Request $request)
    {
        $sort = $request->sort ?? 'DESC';
        $limit = $request->limit ?? 10;        
        $data = User::where('user_type', 'customer');        
        if($request->has('q') && $request->q != '') {
            $q = $request->q;            
            $data = $data->where(function($query) use ($q) {
                $query->where('first_name', 'LIKE', "%{$q}%")
                    ->orWhere('last_name', 'LIKE', "%{$q}%")
                    ->orWhere('name', 'LIKE', "%{$q}%")
                    ->orWhere('email', 'LIKE', "%{$q}%")
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$q}%"]);
            });
        }
        
        $data = $data->orderBy('created_at', $sort);
        
        $data = $data->paginate($limit);
        
        return view('backend.customers.index', compact('data'));
    }
    
    public function customer_edit($id)
    {
        $data = User::find($id);
        $states = getStatesByCountryName('Botswana');
        $cities = getCitiesByStateName($data->state ?? '', 'Botswana');
        return view('backend.customers.edit', compact('data', 'states', 'cities'));        
    }
    
    public function customer_update($id, Request $request)
    {
        $data = $request->except('_token');
 
        if($request->has('password') && $request->password != '') {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }
        
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
        ]);
        
        User::find($id)->update($data);
        
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully');
    }

    public function customer_status($id)
    {
        $client = User::find($id);
        $client->is_active = ($client->is_active==1)?0:1;
        $client->save();
        return redirect()->back();
    }
    
    public function customer_verify($id)
    {
        $client = User::find($id);
        $client->is_verified = ($client->is_verified==1)?0:1;
        $client->save();
        return redirect()->back();
    }

    public function customers_delete(Request $request)
    {
        $count = count($request->ids);
        User::destroy($request->ids);
        Session::flash('success', "{$count} customers(s) deleted");
        return redirect()->back();
    }
}
