<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Member extends Model
{
    use HasFactory;
    protected $fillable=['email', 'first_name', 'last_name', 'phone_no', 'add_to_group'];
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }
}
