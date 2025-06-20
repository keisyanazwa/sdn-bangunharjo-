<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class News extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'news';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'image_url',
        'public_id',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    /**
     * Get the URL for the image.
     *
     * @return string
     */
    public function getImageUrlAttribute($value)
    {
        // If the value already contains a full URL, return it
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }
        
        // If public_id contains a local path, use it to generate the URL
        if ($this->public_id) {
            return asset('storage/' . $this->public_id);
        }
        
        // Fallback to the stored image_url or a default image
        return $value ?: asset('images/no-image.png');
    }
    
    /**
     * Get the URL for the image.
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->image_url;
    }
}