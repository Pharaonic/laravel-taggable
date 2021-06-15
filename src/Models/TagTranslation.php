<?php

namespace Pharaonic\Laravel\Taggable\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $tag_id
 * @property string $locale
 * @property string $name
 * 
 * @author Moamen Eltouny (Raggi) <raggi@raggitech.com>
 */
class TagTranslation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['locale', 'tag_id', 'name'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
