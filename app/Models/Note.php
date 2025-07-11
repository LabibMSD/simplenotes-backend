<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Note extends Model
{
    protected $table = 'notes';
    protected $primaryKey = 'id';
    protected $keyType = 'int';

    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'user_id',
        'title',
        'content',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
