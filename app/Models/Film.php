<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\FilmObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Film
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property bool $published
 * @property ?string $poster
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Collection|Genre[] $genres
 */

#[ObservedBy([FilmObserver::class])]
class Film extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'published',
        'poster',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'published' => 'boolean',
    ];

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }
}
