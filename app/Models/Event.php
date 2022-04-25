<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\UsesUuid;

class Event extends Model
{
    use HasFactory;
    use UsesUuid;
    protected $table = 'events';
    protected $fillable = [
        'category_id',
        'created_by',
        'updated_by',
        'recurring_id',
        'title',
        'description',
        'location',
        'start',
        'end',
        'color',
        'is_active',
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getCreatedByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getUpdatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function recurring()
    {
        return $this->belongsTo(RecurringPattern::class, 'recurring_id');
    }
}
