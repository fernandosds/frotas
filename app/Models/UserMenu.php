<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMenu extends Model
{
    protected $table = 'user_menu';

    protected $fillable = [
        'user_id',
        'list_menu_id',
    ];

    public function menu()
    {
        return $this->belongsTo(ListMenu::class, 'list_menu_id');
    }
}
