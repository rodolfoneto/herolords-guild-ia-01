<?php
namespace App\Models;

// Remove HasUuids if Spatie's base model handles UUIDs
// use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Illuminate\Support\Str; // Import Str

class Permission extends SpatiePermission
{
    use HasFactory;
    // The SpatiePermission model itself should handle UUID logic if the package is configured for UUIDs.

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

    // By default, Spatie models use 'id' as the primary key column name, even for UUIDs.
    // protected $primaryKey = 'id'; 
}