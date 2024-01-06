<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chirp extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'mensaje',
        
    ];

    public function user(): BelongsTo
    {
        return $this ->belongsTo(User::class);
    }


}
