<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bill extends Model
{
    use HasFactory;

    private $fillable = ['user_id', 'title', 'description', 'cost', 'recurrance', 'start'];

    public function user() {
        return $this->hasOne(User::class, 'user_id');
    }
}
