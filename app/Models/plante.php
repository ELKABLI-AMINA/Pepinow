<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class plante extends Model
{
    use HasFactory;
    protected $fillable=['nom','description','image','prix','categorie_id','user_id'];

    public function categories(): BelongsTo
    {
        return $this->belongsTo(categories::class);
    }
    public function users(){
        return $this->belongsTo(User::class);
    }
}
