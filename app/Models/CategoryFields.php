<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryFields extends Model
{
    use HasFactory;

    protected $table = 'categories_fields';
    protected $fillable = ['category_id', 'field_id', 'post_id' ,'module', 'title', 'is_required', 'col', 'sort_order'];

    public function field(){
        return $this->hasOne(Fields::class, 'id', 'field_id');
    }

    public function category(){
        return $this->hasOne(Categories::class, 'id', 'category_id');
    }

    public static function updateOrCreator($id, $data, $i=1){
        $dont_delete = [];
        // dd($data);
        foreach($data as $val){
            $field['category_id'] = $id;
            $field['module'] = (isset($val['module']) && $val['module'] != 'null')?$val['module']:null;
            if(isset($val['post_id']) && $val['post_id']!=0){
                $field['field_id'] = 0;
                $field['post_id'] = $val['post_id'];
            }else{
                $field['field_id'] = $val['id'];
                $field['post_id'] = null;
            }
            $field['is_required'] = (isset($val['is_required']) && $val['is_required']==1)?1:0;
            $field['col'] = $val['col'];
            $field['title'] = ($val['title'])??null;
            $field['sort_order'] = $i;
            if(isset($val['cf_id']) && $val['cf_id']!=null){
                CategoryFields::find($val['cf_id'])->update($field);
            }else{
                $cf = CategoryFields::create($field);
                $val['cf_id'] = $cf->id;
            }

            $dont_delete[] = $val['cf_id'];
            $i++;
        }
        CategoryFields::where('category_id', $id)->whereNotIn('id', $dont_delete)->delete();
    }
}
