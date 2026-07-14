<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    // Helper functions to check role/permission
    public function hasPermission($permission)
    {
        return $this->permissions->contains('slug', $permission);
    }

    public function hasRole($role)
    {
        return $this->where('slug', $role)->exists();
    }

}
