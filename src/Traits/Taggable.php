<?php

namespace Pharaonic\Laravel\Taggable\Traits;

use Illuminate\Database\Eloquent\Model;
use Pharaonic\Laravel\Taggable\Models\Tag;

trait Taggable
{
    /**
     * Boot the taggable trait for the model.
     *
     * @return void
     */
    public static function bootTaggable()
    {
        static::deleting(function (self $model) {
            $model->tags()->detach();
        });
    }

    /**
     * Prepare Tags IDs
     *
     * @param mixed ...$tags
     * @return array
     */
    private function prepareTagsIds(...$tags)
    {
        $tags = $tags[0];

        if ($tags[0] instanceof \Illuminate\Database\Eloquent\Collection) {
            return $tags[0]->modelKeys();
        } elseif (is_array($tags[0])) {
            $tags = $tags[0];
        }

        foreach ($tags as $k => &$tag) {
            if (is_int($tag)) {
                continue;
            } elseif ($tag instanceof Model) {
                $tag = $tag->getKey();
            } else {
                throw new \Exception('You have to pass Keys or Models or Eloquent Collection');
            }
        }

        return $tags;
    }

    /**
     * Attach the model to Ta
     *
     * @param array|model|int ...$tags
     * @return void
     */
    public function tag(...$tags)
    {
        $ids = $this->prepareTagsIds($tags);
        $this->tags()->sync($ids, false);

        return $this;
    }

    /**
     * Detach the model from Tags
     *
     * @param array|model|int ...$tags
     * @return void
     */
    public function detag(...$tags)
    {
        $ids = $this->prepareTagsIds($tags);
        $this->tags()->detach($ids);

        return $this;
    }

    /**
     * Sync the model to Tags
     *
     * @param array|model|int ...$tags
     * @return void
     */
    public function syncTags(...$tags)
    {
        $ids = $this->prepareTagsIds($tags);
        $this->tags()->sync($ids);

        return $this;
    }

    /**
     * Get all attached tags to the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable', 'taggables', 'taggable_id', 'tag_id');
    }
}
