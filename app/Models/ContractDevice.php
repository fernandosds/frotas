<?php
/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 17/12/2020
 * Time: 17:36
 */

 /**
 * Updated by VScode.
 * User: Raphael Falcão
 * Date: 21/01/2021
 * Time: 15:58
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ContractDevice extends Model
{

    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'contract_devices';

   
    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = [
        'contract_id',
        'device_id',
        'technologie_id',
        'type_id'
    ];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'contract_id'                => $this->contract_id,
            'device_id'                  => $this->device_id,
            'technologie_id'             => $this->technologie_id,
            'type_id'                    => $this->type_id,
            
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function technologie()
    {
        return $this->belongsTo('App\Models\Technologie');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contract()
    {
        return $this->belongsTo('App\Models\Contract');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device()
    {
        return $this->belongsTo('App\Models\Device');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo('App\Models\Type');
    }
}