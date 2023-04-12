<?php

namespace Dystcz\LunarApi\Domain\ProductVariants\JsonApi\V1;

use Dystcz\LunarApi\Domain\JsonApi\Eloquent\Fields\AttributeData;
use Dystcz\LunarApi\Domain\JsonApi\Eloquent\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Fields\Relations\HasMany;
use LaravelJsonApi\Eloquent\Fields\Relations\HasOne;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use Lunar\Models\ProductVariant;

class ProductVariantSchema extends Schema
{
    /**
     * The default paging parameters to use if the client supplies none.
     */
    protected ?array $defaultPagination = ['number' => 1];

    /**
     * The model the schema corresponds to.
     */
    public static string $model = ProductVariant::class;

    /**
     * Build an index query for this resource.
     */
    public function indexQuery(?Request $request, Builder $query): Builder
    {
        return $query;
    }

    /**
     * Build a "relatable" query for this resource.
     */
    public function relatableQuery(?Request $request, Relation $query): Relation
    {
        return $query;
    }

    /**
     * The relationships that should always be eager loaded.
     */
    public function with(): array
    {
        return [
            ...parent::with(),
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
            ...parent::includePaths(),

            'images',
            // 'thumbnail',

            'prices',
            'product',
            'product.thumbnail',
        ];
    }

    /**
     * Get the resource fields.
     */
    public function fields(): array
    {
        return [
            ...parent::fields(),

            ID::make(),

            AttributeData::make('attribute_data')
                ->groupAttributes(),

            BelongsTo::make('product'),

            HasOne::make('lowest_price', 'lowestPrice')->type('prices'),

            HasMany::make('images')
                ->canCount()
                ->type('media'),

            HasMany::make('prices'),

            // HasOne::make('thumbnail'),
        ];
    }

    /**
     * Get the resource filters.
     */
    public function filters(): array
    {
        return [
            ...parent::filters(),

            WhereIdIn::make($this),
        ];
    }

    /**
     * Get the resource paginator.
     */
    public function pagination(): ?Paginator
    {
        return PagePagination::make()
            ->withDefaultPerPage(
                Config::get('lunar-api.domains.variants.pagination', 12)
            );
    }

    /**
     * Determine if the resource is authorizable.
     */
    public function authorizable(): bool
    {
        return false; // TODO create policies
    }

    /**
     * Get the JSON:API resource type.
     */
    public static function type(): string
    {
        return 'variants';
    }
}
