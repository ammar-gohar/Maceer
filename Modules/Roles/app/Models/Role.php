<?php

namespace Modules\Roles\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Contracts\Role as RoleContranct;

// use Modules\Roles\Database\Factories\RoleFactory;

class Role extends SpatieRole implements RoleContranct
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'id';
    protected $increment = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    // protected static function newFactory(): RoleFactory
    // {
    //     // return RoleFactory::new();
    // }
}
