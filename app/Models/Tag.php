<?php

namespace App\Models;

use App\Models\Course\CourseTag;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Tag extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $guarded = [];
    protected $hidden = ['id', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $user = Auth::user();
            $model->created_by = $user->id;
        });
        static::updating(function ($model) {
            $user = Auth::user();
            $model->updated_by = $user->id;
        });
        static::deleting(function ($model) {
            $user = Auth::user();
            $model->deleted_by = $user->id;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courseTags()
    {
        return $this->hasMany(CourseTag::class);
    }
}
