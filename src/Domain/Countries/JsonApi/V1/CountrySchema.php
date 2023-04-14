<?php

namespace Dystcz\LunarApi\Domain\Countries\JsonApi\V1;

use Dystcz\LunarApi\Domain\JsonApi\Eloquent\Schema;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Str;
use Lunar\Models\Country;

class CountrySchema extends Schema
{
    /**
     * The model the schema corresponds to.
     */
    public static string $model = Country::class;

    /**
     * The relationships that should always be eager loaded.
     */
    public function with(): array
    {
        return [
            
        ];
    }

    /**
     * Get the include paths supported by this resource.
     *
     * @return string[]|iterable
     */
    public function includePaths(): iterable
    {
        return [
            
        ];
    }

    /**
     * Get the resource fields.
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
        ];
    }

    public function authorizable(): bool
    {
        return false;
    }

    /**
     * Get the JSON:API resource type.
     */
    public static function type(): string
    {
        return 'countries';
    }
}
