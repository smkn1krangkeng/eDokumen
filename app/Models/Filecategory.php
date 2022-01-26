<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filecategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_public',
        'user_id'
    ];
    
    public function filecategory()
    {
        return $this->hasMany(Filecategory::class);
    }
}
