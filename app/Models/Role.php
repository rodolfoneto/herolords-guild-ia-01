<?php
namespace App\Models;

// Remove HasUuids if Spatie's base model handles UUIDs, which it should if configured for it.
// use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Support\Str; // Import Str

class Role extends SpatieRole
{
    use HasFactory;
    // The SpatieRole model itself should handle UUID logic if the package is configured for UUIDs.
    // You typically don't need HasUuids or to redefine $primaryKey here unless you've heavily customized Spatie's setup.

    // Ensure these are set if not inherited or if overriding Spatie's defaults:
    // public $incrementing = false; // Spatie's base model should set this if using UUIDs
    // protected $keyType = 'string'; // Spatie's base model should set this if using UUIDs

    // By default, Spatie models use 'id' as the primary key column name, even for UUIDs.
    protected $primaryKey = 'uuid'; // Set the primary key to 'uuid'
    public $incrementing = false;    // Indicate that the primary key is not auto-incrementing
    protected $keyType = 'string';   // Set the primary key type to string

    protected static function boot()
    {
        parent::boot(); // Call parent boot method

        // Automatically populate the 'uuid' field when creating a new model.
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }
}