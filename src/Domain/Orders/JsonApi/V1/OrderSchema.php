<?php

namespace Dystcz\LunarApi\Domain\Orders\JsonApi\V1;

use Dystcz\LunarApi\Domain\JsonApi\Eloquent\Schema;
use LaravelJsonApi\Eloquent\Fields\ArrayHash;
use LaravelJsonApi\Eloquent\Fields\Boolean;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Map;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Fields\Relations\HasMany;
use LaravelJsonApi\Eloquent\Fields\Relations\HasOne;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\Where;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use Lunar\Models\Order;

class OrderSchema extends Schema
{
    /**
     * {@inheritDoc}
     */
    public static string $model = Order::class;

    /**
     * Get the include paths supported by this resource.
     *
     * @return string[]|iterable
     */
    public function includePaths(): iterable
    {
        return [
            // Addresses
            'addresses',
            'addresses.country',

            // Shipping address
            'shipping_address',
            'shipping_address.country',

            // Billing address
            'billing_address',
            'billing_address.country',

            // Currency
            'currency',

            // Customer
            'customer',

            // Digital product lines
            'digital_lines',
            'digital_lines.currency',
            'digital_lines.purchasable',
            'digital_lines.purchasable.prices',
            'digital_lines.purchasable.images',
            'digital_lines.purchasable.product',
            'digital_lines.purchasable.product.thumbnail',

            // Order Lines
            'lines',
            'lines.currency',

            // Physical product lines
            'physical_lines',
            'physical_lines.currency',
            'physical_lines.purchasable',
            'physical_lines.purchasable.prices',
            'physical_lines.purchasable.images',
            'physical_lines.purchasable.product',
            'physical_lines.purchasable.product.thumbnail',

            // Product lines
            'product_lines',
            'product_lines.currency',
            'product_lines.purchasable',
            'product_lines.purchasable.prices',
            'product_lines.purchasable.images',
            'product_lines.purchasable.product',
            'product_lines.purchasable.product.thumbnail',

            // Shipping lines
            'shipping_lines',
            'shipping_lines.currency',

            // Transactions
            'transactions',
            'transactions.currency',

            // User
            'user',

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
            Boolean::make('new_customer'),
            Str::make('status'),
            Str::make('reference'),
            Str::make('notes'),
            Str::make('currency_code'),
            Str::make('compare_currency_code'),
            Map::make('prices', [
                Number::make('sub_total')
                    ->serializeUsing(
                        static fn ($value) => $value?->decimal,
                    ),
                Number::make('total', 'total')
                    ->serializeUsing(
                        static fn ($value) => $value?->decimal,
                    ),
                Number::make('tax_total', 'tax_total')
                    ->serializeUsing(
                        static fn ($value) => $value?->decimal,
                    ),
                Number::make('discount_total', 'discount_total')
                    ->serializeUsing(
                        static fn ($value) => $value?->decimal,
                    ),
                Number::make('shipping_total', 'shipping_total')
                    ->serializeUsing(
                        static fn ($value) => $value?->decimal,
                    ),
                ArrayHash::make('tax_breakdown'),
                ArrayHash::make('discount_breakdown'),
                ArrayHash::make('shipping_breakdown')
                    ->serializeUsing(
                        static fn ($value) => $value?->items,
                    ),
                Number::make('exchange_rate'),
            ]),
            DateTime::make('placed_at'),
            DateTime::make('created_at'),
            DateTime::make('updated_at'),

            Str::make('payment_method')
                ->hidden(),

            ArrayHash::make('meta')
                ->hidden(),

            HasMany::make('lines')
                ->type('order-lines'),

            HasMany::make('product_lines', 'productLines')
                ->type('order-lines'),

            HasMany::make('digital_lines', 'digitalLines')
                ->type('order-lines'),

            HasMany::make('physical_lines', 'physicalLines')
                ->type('order-lines'),

            HasMany::make('shipping_lines', 'shippingLines')
                ->type('order-lines'),

            BelongsTo::make('customer')
                ->serializeUsing(
                    static fn ($relation) => $relation->withoutLinks(),
                ),

            BelongsTo::make('user')
                ->serializeUsing(
                    static fn ($relation) => $relation->withoutLinks(),
                ),

            BelongsTo::make('currency')
                ->serializeUsing(
                    static fn ($relation) => $relation->withoutLinks(),
                ),

            HasMany::make('addresses')
                ->type('order-addresses')
                ->serializeUsing(
                    static fn ($relation) => $relation->withoutLinks(),
                ),

            HasOne::make('shipping_address', 'shippingAddress')
                ->type('order-addresses')
                ->serializeUsing(
                    static fn ($relation) => $relation->withoutLinks(),
                ),

            HasOne::make('billing_address', 'billingAddress')
                ->type('order-addresses')
                ->serializeUsing(
                    static fn ($relation) => $relation->withoutLinks(),
                ),

            HasOne::make('latest_transaction', 'latestTransaction')
                ->type('transactions')
                ->serializeUsing(
                    static fn ($relation) => $relation->withoutLinks(),
                ),

            HasMany::make('transactions')
                ->type('transactions')
                ->serializeUsing(
                    static fn ($relation) => $relation->withoutLinks(),
                ),

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

            Where::make('user_id'),
            Where::make('reference')->singular(),

            ...parent::filters(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function type(): string
    {
        return 'orders';
    }
}
