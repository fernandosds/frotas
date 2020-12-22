<?php
/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 17/12/2020
 * Time: 17:36
 */

namespace App\Models;


class ContractDevice extends Model
{

    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'customers';

   
    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = [
        'contract_id',
        'device_id',
        'type_id'
    ];

}