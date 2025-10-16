<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'user',
        'email',
        'senha',
    ];

    public static function searchByUser(string $user)
    {
        return self::where('user', $user)->first();
    }

    public static function deleteUser(int $id): bool
    {
        return (bool) self::destroy($id);
    }
}
