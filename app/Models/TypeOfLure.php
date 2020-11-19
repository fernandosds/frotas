<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeOfLure extends Model
{
    /**
     * @var string
     */
    protected $table = 'type_of_lures';

    /**
     * @var string
     */
    protected $with = ["lures"];

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'technologie_id'
    ];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id'                            => $this->id,
            'technologie_id'                => $this->technologie_id,
            
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function lures()
    {
        return $this->HasMany('App\Models\Lure');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function technologie()
    {
        return $this->BelongsTo('App\Models\Technologie');
    }
}
