<?php

namespace App\Modules\Common\Contracts\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use League\Fractal\TransformerAbstract;
use Spatie\QueryBuilder\QueryBuilder;
interface BaseRepository
{
    public function setModel(?Model $model);

    public function processItemTransformer($item, TransformerAbstract $transformer, string $resourceKey, array $includes = []): array;

    public function processCollectionTransformer($data, TransformerAbstract $transformer, string $resourceKey, array $includes = []): array;

    public function create(array $data): Model;

    public function findById(int $id): Model;

    public function findByParams(array $params): Model;

    public function findByParam(array $param): Builder|QueryBuilder;

    public function getByParams(array $params): Collection;

    public function whereIn(string $column, array $condition): Collection;

    public function paginateByParams(array $params): LengthAwarePaginator|Paginator;

    public function get(): Collection;

    public function paginate(int $perPage = 15): LengthAwarePaginator|Paginator;

    public function simplePaginate(): Paginator;

    public function update(array $data): bool;

    public function delete(): bool;

    public function deleteMultiple(array $data): int;

    public function newQuery();

    public function getBasicQuery();

    public function with($relationships);

    public function transformNull(): array;

    public function transformItem(array $includes = []): array;

    public function transformCollection($data, array $includes = []): array;

    public function getTransformer(): TransformerAbstract;

    public function getResourceKey(): string;

    public function withQueryBuilder(): self;

    public function withoutQueryBuilder(): self;

    public function whereHas(string $relation, $callback): Builder|QueryBuilder;
}
