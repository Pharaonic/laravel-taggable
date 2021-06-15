<?php

namespace Pharaonic\Laravel\Taggable\Models;

use Illuminate\Database\Eloquent\Model;
use Pharaonic\Laravel\Translatable\Translatable;

/**
 * @property integer $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property TagTranslation $translations
 * 
 * @author Moamen Eltouny (Raggi) <raggi@raggitech.com>
 */
class Tag extends Model
{
    use Translatable;

    /**
     * Translatable attributes names.
     *
     * @var array
     */
    protected $translatableAttributes = ['name'];

    /**
     * Setting Relationships
     *
     * @return void
     */
    public static function booted()
    {
        foreach(config('Pharaonic.taggable.children') as $name => $modelNamespace) {
            static::resolveRelationUsing($name, function ($model) use ($modelNamespace) {
                return $model->morphedByMany($modelNamespace, 'taggable');
            });
        }
    }

    /**
     * Scope a query to only include popular tags.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopular($query)
    {
        return $query->join('taggables', 'taggables.tag_id', 'tags.id')->groupBy('tags.id')->orderBy('count', 'DESC')->selectRaw('tags.*, count(tag_id) as "count"');
    }
}
