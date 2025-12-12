<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'discount_precentage', 'start_date', 'end_date', 'limit', 'time_used', 'is_active'];
     public function getCreatedAtAttribute($value)
    {
        return date('d/m/Y H:i a', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d/m/Y H:i a', strtotime($value));
    }
    public function ScopeValid($query){
        return $query->where(now() < 'end_date')
                     ->whereColumn('limit','>','time_used')
                     ->where('is_active',1)
                     ->where('start_date','<=',now());
    }
   public function scopeNotValid($query){
    return $query->where('end_date', '<', now())
                 ->orWhereColumn('limit', '<=', 'time_used')
                 ->orWhere('is_active', 0)
                 ->orWhere('start_date', '>', now());
    }
    public function status(){
        return $this->is_active == 1 ? __('dashboard.active'):__('dashboard.inactive');
    }


}
