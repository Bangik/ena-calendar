<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\UsesUuid;

class RecurringPattern extends Model
{
    use HasFactory, UsesUuid;

    protected $fillable = [
        'type',
        'count',
        'date',
    ];

    public function event()
    {
        return $this->hasMany(Event::class, 'event_id');
    }
}
