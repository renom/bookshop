<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(required={"name", "address"})
 */
class Shop extends Model
{
/**
 * @OA\Property(property="id", ref="#/components/schemas/id")
 * @OA\Property(property="name", ref="#/components/schemas/name")
 * @OA\Property(property="address", ref="#/components/schemas/address")
 * @OA\Property(property="created_at", ref="#/components/schemas/created_at")
 * @OA\Property(property="updated_at", ref="#/components/schemas/updated_at")
 */
    protected $fillable = ['name', 'address'];

    public function books()
    {
        return $this->belongsToMany('App\Book')->withTimestamps();
    }
}
/**
 * @OA\Schema(
 *     schema="ShopForm",
 *     type="object",
 *     required={"name", "address"},
 *     @OA\Property(property="name", ref="#/components/schemas/name"),
 *     @OA\Property(property="address", ref="#/components/schemas/address")
 * )
 */
