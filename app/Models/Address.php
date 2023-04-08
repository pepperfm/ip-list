<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'frozen'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function network(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Network::class);
    }
}
