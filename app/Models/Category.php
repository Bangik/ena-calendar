<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\UsesUuid;

class Category extends Model
{
    use HasFactory;
    use UsesUuid;
    protected $table = 'categories';
    protected $fillable = [
        'created_by',
        'updated_by',
        'name',
        'type',
        'icon',
        'color',
    ];

    public function events()
    {
        return $this->hasMany(Event::class, 'category_id');
    }

    public function getCreatedByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getUpdatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
