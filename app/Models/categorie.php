<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categorie extends Model
{
    use HasFactory;
    protected $fillable=['nom','description'];

    public function plants(): HasMany
    {
        return $this->hasMany(plant::class);
    }
    

}
