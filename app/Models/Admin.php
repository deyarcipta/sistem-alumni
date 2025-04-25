<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    public const ROLE_SUPER     = 'super user';
    public const ROLE_KEPSEK    = 'kepsek';
    public const ROLE_TU        = 'tu';
    public const ROLE_KEUANGAN  = 'keuangan';
    public const ROLE_BKK       = 'bkk';

    protected $table = 'admin';
    protected $guard = 'admin';
    protected $fillable = ['nama', 'email', 'password', 'foto', 'role'];

     // helper
     public function isRole(string $role): bool
     {
         return $this->role === $role;
     }
}
