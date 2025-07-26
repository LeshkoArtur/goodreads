<?php

namespace App\Models;

use App\Enums\ReportStatus;
use App\Enums\ReportType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperReport
 */
class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'report_type',
        'description',
        'status',
    ];

    protected $casts = [
        'report_type' => ReportType::class,
        'status' => ReportStatus::class,
    ];

    public function user(){ return $this->belongsTo(User::class); }

    public function reportable(){ return $this->morphTo();  }
}
