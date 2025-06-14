<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public const MASTER = "Master";
    public const ADMIN = "Admin";
    public const USER = "User";

    public static function roles(): array
    {
        return [
            self::MASTER,
            self::ADMIN,
            self::USER,
        ];
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
