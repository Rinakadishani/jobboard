<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id',
        'category_id',
        'title',
        'description',
        'salary_min',
        'salary_max',
        'location',
        'experience',
        'type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static array $experience = ['entry', 'intermediate', 'senior'];
    public static array $types = ['full-time', 'part-time', 'remote', 'internship'];

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['search'] ?? null, function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%")
                        ->orWhereHas('employer', fn ($q) => $q->where('company_name', 'like', "%$search%"));
                });
            })
            ->when($filters['category'] ?? null, fn ($q, $v) => $q->where('category_id', $v))
            ->when($filters['experience'] ?? null, fn ($q, $v) => $q->where('experience', $v))
            ->when($filters['type'] ?? null, fn ($q, $v) => $q->where('type', $v))
            ->when($filters['min_salary'] ?? null, fn ($q, $v) => $q->where('salary_min', '>=', $v))
            ->when($filters['max_salary'] ?? null, fn ($q, $v) => $q->where('salary_max', '<=', $v));
    }
}
