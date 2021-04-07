<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMenu extends Model
{
    protected $table = 'user_menu';

    protected $fillable = [
        'user_id',
        'menu_acess_id',
    ];

    public function menu()
    {
        return $this->belongsTo(MenuAccess::class, 'menu_acess_id');
    }
}
