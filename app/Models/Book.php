<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use OpenApi\Annotations as OA;

/**
 * Class Book.
 * 
 * @OA\Schema(
 *      description="Book model",
 *      title="Book model",
 *      required={"title", "author"},
 *      @OA\Xml(
 *          name="Book"
 *      )
 * )
 */
class Book extends Model
{
    // use HasFactory;
    use SoftDeletes;

    protected $table = 'books';

    public $timestamps = false; // Nonaktifkan timestamps

    protected $fillable = [
        'title',
        'author',
        'publisher',
        'publication_year',
        'cover',
        'description',
        'price',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function data_adder()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}