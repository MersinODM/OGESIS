<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notification extends Model
{
    protected $table="ogs_notifications";

    protected $fillable= [
        'notifiable_id',
        'notifiable_type',
        'title',
        'content',
        'is_read'
    ];

    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }
}