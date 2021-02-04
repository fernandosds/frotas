<?php

namespace App;

//use App\Models\Log;
use App\Models\Access;
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
        'access_level'
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

    public function accesses()
    {
        // Não esqueça de usar a classe Access: use App\Models\Access;
        return $this->hasMany(Access::class);
    }

    public function registerAccess()
    {
        // Cadastra na tabela accesses um novo registro com as informações do usuário logado + data e hora
        return $this->accesses()->create([
            'user_id'   => $this->id,
            'description' => 'Efetuou o login no sistema',
        ]);
    }

    public function registerClose()
    {
        // Cadastra na tabela accesses um novo registro com as informações do usuário logado + data e hora
        return $this->accesses()->create([
            'user_id'   => $this->id,
            'description' => 'Saiu do sistema',
        ]);
    }
    /**
    public function registerCustomer()
    {
        $customerId = $this->customer()->id;
        
        return $this->accesses()->create([
            'user_id'       => $this->id,
            'customer_id'   => $this->customer_id,
            'description'   => 'Cadastrou um novo usuario',
        ]);
    }
     */
}
