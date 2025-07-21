<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperReport
 */
class Report extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'reportable_id', 'reportable_type', 'report_type', 'description', 'status',];

    public function user(){ return $this->belongsTo(User::class); }

    public function reportable(){ return $this->morphTo();  }
}
