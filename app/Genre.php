<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(required={"name"})
 */
class Genre extends Model
{
/**
 * @OA\Property(property="id", ref="#/components/schemas/id")
 * @OA\Property(property="name", ref="#/components/schemas/name")
 * @OA\Property(property="created_at", ref="#/components/schemas/created_at")
 * @OA\Property(property="updated_at", ref="#/components/schemas/updated_at")
 */
    protected $fillable = ['name'];

    public function books()
    {
        return $this->hasMany('App\Book');
    }
}
/**
 * @OA\Schema(
 *     schema="GenreForm",
 *     type="object",
 *     required={"name"},
 *     @OA\Property(property="name", ref="#/components/schemas/name")
 * )
 */
