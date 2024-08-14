<?php

namespace App\Traits;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

trait Uuids {

    /**
     * Boot the trait.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            // Genera un UUID versión 4 y lo asigna como el ID del modelo
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }

}
