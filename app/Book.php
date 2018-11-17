<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(required={"name", "description", "pages", "price", "genre_id"})
 */
class Book extends Model
{
/**
 * @OA\Property(property="id", ref="#/components/schemas/id")
 * @OA\Property(property="name", ref="#/components/schemas/name")
 * @OA\Property(property="description", ref="#/components/schemas/description")
 * @OA\Property(property="pages", ref="#/components/schemas/pages")
 * @OA\Property(property="price", ref="#/components/schemas/price")
 * @OA\Property(property="genre_id", ref="#/components/schemas/id")
 * @OA\Property(property="created_at", ref="#/components/schemas/created_at")
 * @OA\Property(property="updated_at", ref="#/components/schemas/updated_at")
 */
    protected $fillable = ['name', 'description', 'pages', 'price', 'genre_id'];

    public function genre()
    {
        return $this->belongsTo('App\Genre');
    }

    public function shops()
    {
        return $this->belongsToMany('App\Shop')->withTimestamps();
    }
}
/**
 * @OA\Schema(
 *     schema="BookForm",
 *     type="object",
 *     required={"name", "description", "pages", "price", "genre_id"},
 *     @OA\Property(property="name", ref="#/components/schemas/name"),
 *     @OA\Property(property="description", ref="#/components/schemas/description"),
 *     @OA\Property(property="pages", ref="#/components/schemas/pages"),
 *     @OA\Property(property="price", ref="#/components/schemas/price"),
 *     @OA\Property(property="genre_id", ref="#/components/schemas/id")
 * )
 */
