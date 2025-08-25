<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;
    protected $table='tasks';
 protected $fillable=['title','description','status','classification_id','user_id'];
 public function user()
    {
        return $this->belongsTo(User::class);
    }

public function classification()
{
    return $this->belongsTo(Classification::class);
}

public function attachments()
{
    return $this->hasMany(Attachment::class);
}

}
