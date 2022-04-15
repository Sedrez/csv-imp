<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id','first_name','last_name','email','gender','ip_address','company','city','title','website'
    ];
    
    protected $hidden = [
        "created_at", "updated_at"
    ];
}