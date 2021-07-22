<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Customer extends Model
{
    use Notifiable, SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'customers';

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'cpf_cnpj',
        'type',
        'cep',
        'address',
        'complement',
        'number',
        'city',
        'neighborhood',
        'state'

    ];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id'                    => $this->id,
            'name'                  => $this->name,
            'cpf_cnpj'              => $this->cpf_cnpj,
            'type'                  => $this->type,
            'cep'                   => $this->cep,
            'address'               => $this->address,
            'complement'            => $this->complement,
            'number'                => $this->number,
            'city'                  => $this->city,
            'neighborhood'          => $this->neighborhood,
            'state'                 => $this->state,

        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contracts()
    {
        return $this->HasMany('App\Models\Contract', Contract::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->HasMany('App\Models\Contact');
    }

    public function logs()
    {
        // Não esqueça de usar a classe Access: use App\Models\Access;
        return $this->hasMany(Log::class);
    }

    public function registerCustomer()
    {
        // Cadastra na tabela accesses um novo registro com as informações do usuário logado + data e hora
        return $this->logs()->create([
            'user_id'   => Auth::user()->id,
            'customer_id' => $this->id,
            'description' => 'Cadastrou cliente no sistema',
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trackers()
    {
        return $this->HasMany('App\Models\Tracker');
    }
}
