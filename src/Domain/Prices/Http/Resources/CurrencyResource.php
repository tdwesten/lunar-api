<?php

namespace Dystcz\LunarApi\Domain\Prices\Http\Resources;

use Illuminate\Support\Facades\App;
use Dystcz\LunarApi\Domain\JsonApi\Builders\CurrencyJsonApiBuilder;
use Dystcz\LunarApi\Domain\JsonApi\Http\Resources\JsonApiResource;
use Illuminate\Http\Request;

class CurrencyResource extends JsonApiResource
{
    protected function toAttributes(Request $request): array
    {
        return [
            'name' => $this->name,
            'code' => $this->code,
        ];
    }

    protected function toRelationships(Request $request): array
    {
        return App::get(CurrencyJsonApiBuilder::class)->toRelationships($this->resource);
    }
}
