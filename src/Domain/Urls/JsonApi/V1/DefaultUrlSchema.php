<?php

namespace Dystcz\LunarApi\Domain\Urls\JsonApi\V1;

use Dystcz\LunarApi\Domain\JsonApi\Eloquent\Schema;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\Where;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use Lunar\Models\Url;

class DefaultUrlSchema extends Schema
{
    /**
     * The resource type as it appears in URIs.
     */
    protected ?string $uriType = 'default_urls';

    /**
     * {@inheritDoc}
     */
    public static string $model = Url::class;

    /**
     * {@inheritDoc}
     */
    public function fields(): array
    {
        return [
            $this->idField(),

            Str::make('slug'),

            ...parent::fields(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function filters(): array
    {
        return [
            WhereIdIn::make($this),

            Where::make('slug'),

            ...parent::filters(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function type(): string
    {
        return 'default-urls';
    }
}
