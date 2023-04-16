<?php

namespace Dystcz\LunarApi\Domain\Countries\JsonApi\V1;

use Dystcz\LunarApi\Domain\JsonApi\Eloquent\Schema;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Str;
use Lunar\Models\Country;

class CountrySchema extends Schema
{
    /**
     * {@inheritDoc}
     */
    public static string $model = Country::class;

    /**
     * {@inheritDoc}
     */
    public function fields(): array
    {
        return [
            ID::make(),
            Str::make('name'),
            Str::make('iso2'),
            Str::make('iso3'),
            Str::make('phonecode'),
            Str::make('capital'),
            Str::make('currency'),
            Str::make('native'),
            Str::make('emoji'),
            Str::make('emoji_u'),

            ...parent::fields(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function authorizable(): bool
    {
        return false; // TODO: create policies
    }

    /**
     * {@inheritDoc}
     */
    public static function type(): string
    {
        return 'countries';
    }
}
