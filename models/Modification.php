<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Modification extends Model {
    protected $guarded = ['id'];

    public function snippet(): BelongsTo {
        return $this->belongsTo(Snippet::class);
    }
}