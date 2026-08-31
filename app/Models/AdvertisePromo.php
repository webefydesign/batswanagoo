<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdvertisePromo extends Model
{
    use SoftDeletes;

    protected $table = 'advertises_promotions';
    protected $fillable = ['promotion_id', 'adv_id', 'start_date', 'start_time', 'start', 'end_date', 'end_time', 'end', 'promo_name', 'price', 'paid', 'expire', 'transaction_id', 'days', 'currency_id', 'currency'];


    public static function creator($promotions, $adv){
        $currency = getCurrency();
        if(count($promotions)>0){
            $promos = [];
            foreach ($promotions as $val) {
                $promo['promotion_id'] = $val['id'];
                $promo['adv_id'] = $adv['id'];
                $promo['days'] = $val['days'];
                $promo['start_date'] = date('Y-m-d');
                $promo['start_time'] = date('H:i:s');
                $promo['start'] = date('Y-m-d H:i:s');
                $promo['end_date'] = Carbon::parse(date('Y-m-d'))->addDays($val['days']*1)->format('Y-m-d');
                $promo['end_time'] = date('H:i:s');
                $promo['end'] = Carbon::parse(date('Y-m-d'))->addDays($val['days']*1)->format('Y-m-d H:i:s');
                $promo['promo_name'] = Promote::find($val['id'])->name;
                $promo['price'] = $val['price'];
                $promo['currency_id'] = $currency['id'];
                $promo['currency'] = $currency['symbol'];
                $pro = AdvertisePromo::create($promo);
                // dd($pro);
                $promos[] = $pro;
            }
            return $promos;
        }

    }

    public static function updator($promotions, $adv){

        $currency = getCurrency();
        if(count($promotions)>0){
            $promos = [];
            foreach ($promotions as $val) {
                $promo['promotion_id'] = $val['id'];
                $promo['adv_id'] = $adv['id'];
                $promo['days'] = $val['days'];
                $promo['start_date'] = date('Y-m-d');
                $promo['start_time'] = date('H:i:s');
                $promo['start'] = date('Y-m-d H:i:s');
                // $promo['end_date'] = Carbon::parse(date('Y-m-d'))->addDays($val['days'])->format('Y-m-d');
                $promo['end_date'] = Carbon::parse(date('Y-m-d'))->addDays((int) $val['days'])->format('Y-m-d');
                $promo['end_time'] = date('H:i:s');
                $promo['end'] = Carbon::parse(date('Y-m-d'))->addDays((int) $val['days'])->format('Y-m-d H:i:s');
                $promo['promo_name'] = Promote::find($val['id'])->name;
                $promo['price'] = $val['price'];
                $promo['currency_id'] = $currency['id'];
                $promo['currency'] = $currency['symbol'];
                $pro = AdvertisePromo::create($promo);
                $promos[] = $pro;
            }
            return $promos;
        }

    }

}
