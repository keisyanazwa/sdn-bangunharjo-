<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Teacher extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'position',
        'image_url',
        'public_id'
    ];

    /**
     * Get the URL for the teacher's photo.
     *
     * @return string
     */
    public function getPhotoUrl()
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        
        // Return a default image if no photo is set
        return asset('images/default-teacher.png');
    }

    /**
     * Delete the teacher's photo from storage when the teacher is deleted.
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($teacher) {
            if ($teacher->photo && Storage::disk('public')->exists($teacher->photo)) {
                Storage::disk('public')->delete($teacher->photo);
            }
        });
    }
}