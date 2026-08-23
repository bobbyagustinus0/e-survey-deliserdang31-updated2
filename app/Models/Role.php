<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['nama_role', 'slug', 'menu_access'];

    protected $casts = [
        'menu_access' => 'array',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function hasMenu(string $menuKey): bool
    {
        if ($this->slug === 'superadmin') {
            return true;
        }
        return in_array($menuKey, $this->menu_access ?? []);
    }
}
