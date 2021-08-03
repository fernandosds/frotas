<?php

namespace App;

use App\Models\Log;
use App\Models\ListMenu;
use App\Models\Tracker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'status',
        'customer_id',
        'access_level',
        'required_validation',
        'validation_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function logs()
    {
        // Não esqueça de usar a classe Access: use App\Models\Access;
        return $this->hasMany(Log::class);
    }

    public function registerAccess()
    {
        // Cadastra na tabela accesses um novo registro com as informações do usuário logado + data e hora
        return $this->logs()->create([
            'user_id'   => $this->id,
            'customer_id' =>  Auth::user()->customer_id,
            'description' => 'Efetuou o login no sistema',
        ]);
    }

    public function registerClose()
    {
        // Cadastra na tabela accesses um novo registro com as informações do usuário logado + data e hora
        return $this->logs()->create([
            'user_id'   => $this->id,
            'customer_id' =>  Auth::user()->customer_id,
            'description' => 'Saiu do sistema',
        ]);
    }

    public function listMenu()
    {
        return $this->belongsToMany(ListMenu::class, 'user_menu');
    }

    public function accessMenu($menu)
    {
        return $this->listMenu()->where('name', $menu)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function usersmenu()
    {
        return $this->hasMany('App\Models\UserMenu');
    }

    public function trackers()
    {
        return DB::table('trackers')->get();
    }

    public function trackerDevice($model)
    {
        $trackerStatus = $this->trackers()
            ->where('status', $model)
            ->where('customer_id', Auth::user()->customer_id);

        foreach ($trackerStatus as $key => $value) {
            if (!empty($trackerStatus)) {
                return $trackerStatus;
            }
        }
    }
}
