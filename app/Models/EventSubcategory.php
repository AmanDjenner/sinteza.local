<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSubcategory extends Model
{
    protected $table = 'events_subcategory';

    protected $fillable = [
        'name',
        'id_category',
    ];

    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'id_category');
    }
}