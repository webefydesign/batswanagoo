<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\CategoryFields;
use App\Models\Fields;
use Session;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->sort??'desc';
        $limit = $request->limit??10;
        if($request->has('q') && $request->q!='') {
            $q = $request->q;
            $data = Categories::where('name', 'LIKE', "%{$q}%")->where('parent_id', null);
            if($sort == 'desc' || $sort == 'asc') {
                $data = $data->OrderBy('id', $sort);
            } else {
                $data = $data->OrderBy($sort);
            }
            $data = $data->paginate($limit);
        } else {
            $data = Categories::where('parent_id', null);
            if($sort == 'desc' || $sort == 'asc') {
                $data = $data->OrderBy('id', $sort);
            } else {
                $data = $data->OrderBy($sort);
            }
            $data = $data->paginate($limit)->appends(['sort' => $sort]);
        }
        return view('backend.categories.index', compact('data', 'sort'));
    }

    public function create()
    {
        $categories = Categories::where('is_active', 1)->where('parent_id', null)->with('childrens')->get();
        $sort_order = Categories::max('sort_order')+1;
        $fields = Fields::where('is_active', 1)->get();
        return view('backend.categories.create', compact('categories', 'sort_order', 'fields'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data['is_active'] = 1;
        // $data['is_special'] = (isset($request->is_special)) ? 1 : 0;
        // $data['display'] = (isset($request->display)) ? 1 : 0;
        $category = Categories::create($data);
        CategoryFields::updateOrCreator($category->id, ($data['field']) ?? []);
        if (isset($data['parent_fields']) && $data['parent_fields'] == 1) {
            $fields = CategoryFields::where('category_id', $category->parent_id)->orderBy('sort_order', 'ASC')->get();
            $i = count(($data['field']) ?? []);
            foreach ($fields as $field) {
                $field = $field->toArray();
                $field['category_id'] = $category->id;
                $field['sort_order'] = $i;
                CategoryFields::create($field);
                $i++;
            }
        }
        Session::flash('success', 'Item added successfully');
        return redirect()->route('categories.index');
    }

    public function edit($id)
    {
        $data = Categories::find($id);        
        $categories = Categories::where('is_active', 1)->where('parent_id', null)->with('childrens')->get();
        $fields = Fields::where('is_active', 1)->get();
        return view('backend.categories.edit', compact('categories', 'data', 'fields'));
    }
    
    public function update($id, Request $request)
    {
        $data = $request->except('_token', 'seo_data');
        $data['seo_data'] = $request->seo_data??null;
        Categories::find($id)->update($data);
        CategoryFields::updateOrCreator($id, ($data['field']) ?? []);
        if (isset($data['parent_fields']) && $data['parent_fields'] == 1) {
            $fields = CategoryFields::where('category_id', $category->parent_id)
                ->orderBy('sort_order', 'ASC')->get();
            $i = count(($data['field']) ?? []);
            foreach ($fields as $field) {
                $field = $field->toArray();
                $field['category_id'] = $category->id;
                $field['sort_order'] = $i;
                CategoryFields::create($field);
                $i++;
            }
        }
        Session::flash('success', 'Item update successfully');
        return redirect()->route('categories.index');
    }

    public function status($id)
    {
        $client = Categories::find($id);
        $client->is_active = ($client->is_active==1)?0:1;
        $client->save();
        return redirect()->back();
    }
    
    public function display($id)
    {
        $client = Categories::find($id);
        $client->display = ($client->display==1)?0:1;
        $client->save();
        return redirect()->back();
    }
    
    public function special($id)
    {
        $client = Categories::find($id);
        $client->is_special = ($client->is_special==1)?0:1;
        $client->save();
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $count = count($request->ids);
        Categories::destroy($request->ids);
        Session::flash('success', "{$count} item(s) deleted");
        return redirect()->back();
    }

    /* Sub Categories */
    public function sub_categories_index(Request $request)
    {
        $sort = $request->sort??'desc';
        $limit = $request->limit??10;
        if($request->has('q') && $request->q!='') {
            $q = $request->q;
            $data = Categories::where('name', 'LIKE', "%{$q}%")->where('parent_id', '!=', null);
            if($sort == 'desc' || $sort == 'asc') {
                $data = $data->OrderBy('id', $sort);
            } else {
                $data = $data->OrderBy($sort);
            }
            $data = $data->paginate($limit)->appends(['sort' => $sort]);
        } else {
            $data = Categories::where('parent_id', '!=', null);
            if($sort == 'desc' || $sort == 'asc') {
                $data = $data->OrderBy('id', $sort);
            } else {
                $data = $data->OrderBy($sort);
            }
            $data = $data->paginate($limit)->appends(['sort' => $sort]);
        }
        return view('backend.categories.sub.index', compact('data', 'sort'));
    }

    public function sub_categories_create()
    {
        $categories = Categories::where('is_active', 1)->where('parent_id', null)->with('childrens')->get();
        $sort_order = Categories::max('sort_order')+1;
        $fields = Fields::where('is_active', 1)->get();
        return view('backend.categories.sub.create', compact('categories', 'sort_order', 'fields'));
    }

    public function sub_categories_store(Request $request)
    {
        $data = $request->except('_token');
        $data['is_active'] = 1;
        // $data['is_special'] = (isset($request->is_special)) ? 1 : 0;
        // $data['display'] = (isset($request->display)) ? 1 : 0;
        $category = Categories::create($data);
        CategoryFields::updateOrCreator($category->id, ($data['field']) ?? []);
        if (isset($data['parent_fields']) && $data['parent_fields'] == 1) {
            $fields = CategoryFields::where('category_id', $category->parent_id)->orderBy('sort_order', 'ASC')->get();
            $i = count(($data['field']) ?? []);
            foreach ($fields as $field) {
                $field = $field->toArray();
                $field['category_id'] = $category->id;
                $field['sort_order'] = $i;
                CategoryFields::create($field);
                $i++;
            }
        }
        Session::flash('success', 'Item added successfully');
        return redirect()->route('sub-categories.index');
    }

    public function sub_categories_edit($id)
    {
        $data = Categories::find($id);
        $categories = Categories::where('is_active', 1)->where('parent_id', null)->with('childrens')->get();
        $fields = Fields::where('is_active', 1)->get();
        return view('backend.categories.sub.edit', compact('categories', 'data', 'fields'));
    }

    public function sub_categories_update($id, Request $request)
    {
        $data = $request->except('_token', 'seo_data');
        $data['seo_data'] = $request->seo_data??null;
        Categories::find($id)->update($data);
        CategoryFields::updateOrCreator($id, ($data['field']) ?? []);
        Session::flash('success', 'Item update successfully');
        return redirect()->route('sub-categories.index');
    }

    public function sub_categories_status($id)
    {
        $client = Categories::find($id);
        $client->is_active = ($client->is_active==1)?0:1;
        $client->save();
        return redirect()->back();
    }

    public function sub_categories_display($id)
    {
        $client = Categories::find($id);
        $client->display = ($client->display==1)?0:1;
        $client->save();
        return redirect()->back();
    }

    public function sub_categories_special($id)
    {
        $client = Categories::find($id);
        $client->is_special = ($client->is_special==1)?0:1;
        $client->save();
        return redirect()->back();
    }

    public function sub_categories_delete(Request $request)
    {
        $count = count($request->ids);
        Categories::destroy($request->ids);
        Session::flash('success', "{$count} item(s) deleted");
        return redirect()->back();
    }
}
