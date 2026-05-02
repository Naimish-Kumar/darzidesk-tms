<?php

namespace App\Traits;

use App\Models\Scopes\ParentScope;

trait ParentIdTrait
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new ParentScope);

        static::creating(function ($model) {
            if (auth()->check() && empty($model->parent_id)) {
                $model->parent_id = parentId();
            }
        });
    }
}
