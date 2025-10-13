<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Admin extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'status',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function role()
    {
        return $this->belongsTo(Role::class , 'role_id');
    }
    public function hasAccess($config_permession){
        $role = $this->role;
        if(!$role){
            return false;
        }
        foreach($role->permession as $permession){
            if($config_permession == $permession ?? false){
                return true;
            }
        }
    }
    //old way
    // public function getStatusAttribute($value){
    //     return $value == 1 ? 'Active' : 'Inactive';
    // }
    public function status(): Attribute
{
    return new Attribute(
        get: fn ($value) => $value == 1 ? 'Active' : 'Inactive',
    );
}

}
