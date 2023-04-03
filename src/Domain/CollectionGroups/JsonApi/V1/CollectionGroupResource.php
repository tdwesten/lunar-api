<?php

namespace Dystcz\LunarApi\Domain\CollectionGroups\JsonApi\V1;

use Illuminate\Http\Request;
use Dystcz\LunarApi\Domain\JsonApi\Extensions\Resource\ResourceManifest;
use Dystcz\LunarApi\Domain\JsonApi\Resources\JsonApiResource;
use Lunar\Models\CollectionGroup;

class CollectionGroupResource extends JsonApiResource
{
    /**
     * Get the resource's attributes.
     *
     * @param Request|null $request
     */
    public function attributes($request): iterable
    {
        /** @var CollectionGroup */
        $model = $this->resource;

        return [
            'name' => $model->name,
            ...ResourceManifest::for(static::class)->attributes()->toResourceArray($this),
        ];
    }

    /**
     * Get the resource's relationships.
     *
     * @param Request|null $request
     */
    public function relationships($request): iterable
    {
        return [
            ...ResourceManifest::for(static::class)->relationships()->toResourceArray($this),
        ];
    }
}
