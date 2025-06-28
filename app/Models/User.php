<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $keyType = 'int';

    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'username',
        'password',
    ];

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}
