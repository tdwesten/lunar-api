<?php

namespace Dystcz\LunarApi\Domain\Addresses\JsonApi\V1;

use Dystcz\LunarApi\Domain\Addresses\Models\Address;
use Dystcz\LunarApi\Domain\JsonApi\Eloquent\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LaravelJsonApi\Eloquent\Fields\ArrayHash;
use LaravelJsonApi\Eloquent\Fields\Boolean;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Fields\Str;

class AddressSchema extends Schema
{
    /**
     * {@inheritDoc}
     */
    public function indexQuery(?Request $request, Builder $query): Builder
    {
        return $query->whereIn('customer_id', Auth::user()->customers->pluck('id'));
    }

    /**
     * {@inheritDoc}
     */
    public static string $model = Address::class;

    /**
     * {@inheritDoc}
     */
    public function includePaths(): iterable
    {
        return [
            'country',
            'customer',

            ...parent::includePaths(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function fields(): array
    {
        return [
            ID::make(),

            Str::make('title'),
            Str::make('first_name'),
            Str::make('last_name'),
            Str::make('company_name'),
            Str::make('line_one'),
            Str::make('line_two'),
            Str::make('line_three'),
            Str::make('city'),
            Str::make('state'),
            Str::make('postcode'),
            Str::make('delivery_instructions'),
            Str::make('contact_email'),
            Str::make('contact_phone'),

            Boolean::make('shipping_default'),
            Boolean::make('billing_default'),

            ArrayHash::make('meta')
                ->serializeUsing(fn ($value) => ! $value ? null : ((array) $value)),

            BelongsTo::make('customer'),
            BelongsTo::make('country'),

            ...parent::fields(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function type(): string
    {
        return 'addresses';
    }
}
