<?php

namespace App;

use App\Models\Log;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;


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
            'description' => 'Efetuou o login no sistema',
        ]);
    }

    public function registerClose()
    {
        // Cadastra na tabela accesses um novo registro com as informações do usuário logado + data e hora
        return $this->logs()->create([
            'user_id'   => $this->id,
            'description' => 'Saiu do sistema',
        ]);
    }
   
}
