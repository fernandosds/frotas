<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ListMenu extends Model
{
    /**
     * @var string
     */
    protected $table = 'list_menu';
   
    protected $fillable = [
        'id',
        'name',
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_menu');
    }
}
