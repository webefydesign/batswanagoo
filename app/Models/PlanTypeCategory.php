<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanTypeCategory extends Model
{
    use HasFactory;

    protected $table = 'plan_type_categories';
    protected $fillable = ['plan_type_id', 'category_id'];
    public $timestamps = false;

    public function planType()
    {
        return $this->belongsTo(PlanType::class, 'plan_type_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id', 'id');
    }
}
