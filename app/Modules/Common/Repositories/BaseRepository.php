<?php

namespace App\Modules\Common\Repositories;

use App\Modules\Common\Contracts\Repositories\BaseRepository as BaseRepositoryContract;
use App\Modules\Common\Traits\TransformerTrait;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter as Filter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\DB;

class BaseRepository implements BaseRepositoryContract
{
    use TransformerTrait;

    /**
     * @var Model
     */
    protected Model $model;

    /**
     * @var array
     */
    protected array $allowedIncludes = [];

    /**
     * @var array
     */
    protected array $allowedFilters = [];

    /**
     * @var array
     */
    protected array $exactFilters = [
        'id',
    ];

    /**
     * @var array
     */
    protected array $allowedSorts = [];

    /**
     * @var array
     */
    protected array $allowedFields = [];

    /**
     * @var bool
     */
    protected bool $queryBuilderEnabled = true;

    protected array $exactDateFilters = [];

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->makeFillableFiltersAndSorts();
    }

    /**
     * Set model.
     *
     * @param Model|null $model
     */
    public function setModel(?Model $model)
    {
        $this->model = $model;
    }

    /**
     * Set the allowed filters and sorts to the model's fillable.
     */
    protected function makeFillableFiltersAndSorts()
    {
        // get fillable
        $fillable = $this->model->getFillable();
        $fillable[] = $this->model->getCreatedAtColumn();
        $fillable[] = $this->model->getUpdatedAtColumn();

        // add default filters
        foreach ($fillable as $field) {
            if (! in_array($field, $this->exactFilters)) {
                $this->allowedFilters[] = $field;
            }
        }

        // add exact filters
        foreach ($this->exactFilters as $filter) {
            $this->allowedFilters[] = Filter::exact($filter);
        }

        // configure sorts
        $this->allowedSorts = $fillable;
        $this->allowedSorts[] = 'id';
        $this->allowedFields = $this->allowedSorts;
    }

    /**
     * Create model.
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->newQuery()
            ->create($data);
    }

    /**
     * Find model by id.
     *
     * @param int $id
     * @return Model
     */
    public function findById(int $id): Model
    {
        return $this->newQuery()
            ->findOrFail($id);
    }

    /**
     * Find model by params.
     *
     * @param array $params
     * @return Model
     */
    public function findByParams(array $params): Model
    {
        return $this->newQuery()
            ->where($params)
            ->firstOrFail();
    }

    public function findByParam(array $param): Builder|QueryBuilder
    {
        return $this->newQuery()
            ->where($param);
    }

    /**
     * Find list by params.
     *
     * @param array $params
     * @return Collection
     */
    public function getByParams(array $params): Collection
    {
        return $this->getQueryBuilderFor($this->getBasicQuery()
            ->where($params))->get();
    }

    /**
     * @param Builder $query
     * @param bool $simple
     * @param int $perPage
     * @return Paginator
     */
    protected function doPaginate(Builder $query, bool $simple = false, int $perPage = 15): Paginator
    {
        $simple = $simple || request()->input('paginator') === 'simple';

        return $simple ? $query->simplePaginate() : $query->paginate($perPage);
    }

    /**
     * @param array $params
     * @return LengthAwarePaginator|Paginator
     */
    public function paginateByParams(array $params): LengthAwarePaginator|Paginator
    {
        return $this->doPaginate(
            $this->getBasicQuery()->where($params)
        );
    }

    /**
     * @return QueryBuilder|Builder
     */
    public function getBasicQuery(): QueryBuilder|Builder
    {
        $query = $this->newQuery();

        // check if search is performed
        if (request()->has('q') && $this->canSearch()) {
            $items = $this->getScoutQuery(
                (get_class($this->model))::search(request()->input('q'))
            )->get();
            $primaryKeys = $items->pluck($this->getPrimaryKey())->toArray();
            $query->whereIn($this->getPrimaryKey(), $primaryKeys);
        }

        return $query;
    }

    /**
     * Find model collection.
     *
     * @return Collection
     */
    public function get(): Collection
    {
        return $this->getBasicQuery()
            ->get();
    }

    /**
     * Paginate model collection.
     * @param int $perPage
     * @return LengthAwarePaginator|Paginator
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator|Paginator
    {
        return $this->doPaginate($this->getBasicQuery(), perPage: $perPage);
    }

    /**
     * Simple paginate model collection.
     *
     * @return Paginator
     */
    public function simplePaginate(): Paginator
    {
        return $this->doPaginate($this->getBasicQuery(), true);
    }

    /**
     * Update model.
     *
     * @param array $data
     * @return bool
     */
    public function update(array $data): bool
    {
        return $this->model->update($data);
    }

    /**
     * Delete model.
     *
     * @return bool
     * @throws Exception
     */
    public function delete(): bool
    {
        return $this->model->delete();
    }

    public function deleteMultiple(array $data): int
    {
        return $this->newQuery()->whereIn('uuid', $data)->delete();
    }

    /**
     * @throws Exception
     */
    public function updateMultiple(array $data): int
    {
        $random16Digit = '-' . random_int(1000000000000000, 9999999999999999);

        return $this->newQuery()->whereIn('uuid', $data)
            ->update([
                'email' => DB::raw("CONCAT(`email`, '${random16Digit}')"),
            ]);
    }

    /**
     * @param array $includes
     * @return array
     */
    public function transformItem(array $includes = []): array
    {
        return $this->processItemTransformer($this->model, $this->getTransformer(), $this->getResourceKey(), $includes);
    }

    /**
     * @param $data
     * @param array $includes
     * @return array
     */
    public function transformCollection($data, array $includes = []): array
    {
        return $this->processCollectionTransformer($data, $this->getTransformer(), $this->getResourceKey(), $includes);
    }

    /**
     * Get query builder.
     *
     * @param $query
     * @param null $request
     * @return QueryBuilder|Builder
     */
    protected function getQueryBuilderFor($query, $request = null): QueryBuilder|Builder
    {
        if ($this->queryBuilderEnabled && ! $query instanceof QueryBuilder) {
            return QueryBuilder::for($query, $request)
                ->allowedFilters($this->allowedFilters)
                ->allowedSorts($this->allowedSorts)
                ->allowedFields($this->allowedFields)
                ->allowedIncludes($this->allowedIncludes);
        } elseif (is_string($query)) {
            $query = ($query)::query();
        }

        return $query;
    }

    /**
     * @return QueryBuilder|Builder
     */
    public function newQuery(): QueryBuilder|Builder
    {
        return $this->getQueryBuilderFor(
            $this->model->newQuery()
        );
    }

    /**
     * @param $relationships
     * @return Builder
     */
    public function with($relationships)
    {
        return $this->newQuery()->with($relationships);
    }

    /**
     * @return BaseRepositoryContract
     */
    public function withQueryBuilder(): BaseRepositoryContract
    {
        $this->queryBuilderEnabled = true;

        return $this;
    }

    /**
     * @return BaseRepositoryContract
     */
    public function withoutQueryBuilder(): BaseRepositoryContract
    {
        $this->queryBuilderEnabled = false;

        return $this;
    }

    /**
     * @return bool
     */
    protected function canSearch(): bool
    {
        return false;
    }

    /**
     * @return string
     */
    protected function getPrimaryKey(): string
    {
        return 'id';
    }

    /**
     * @param \Laravel\Scout\Builder $builder
     * @return \Laravel\Scout\Builder
     */
    protected function getScoutQuery(\Laravel\Scout\Builder $builder): \Laravel\Scout\Builder
    {
        return $builder;
    }

    public function whereIn(string $column, array $condition): Collection
    {
        return $this->newQuery()->whereIn($column, $condition)->get();
    }

    public function whereHas(string $relation, $callback): Builder|QueryBuilder
    {
        return $this->newQuery()->whereHas($relation, $callback);
    }

    public function where(string $column, string $value, string $operator = '='): Builder|QueryBuilder
    {
        return $this->newQuery()->where($column, $operator, $value);
    }
}
