<?php

namespace App\Modules\Common\Service;
use App\Modules\Common\Contratct\BaseService as BaseServiceContract;
use App\Modules\Common\Trait\TransformerTrait;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class BaseService implements BaseServiceContract
{
    use TransformerTrait;
    /**
     * @var string
     */
    protected string $module;
    /**
     * @var Model
     */
    protected Model $model;
    /**
     * @var bool
     */
    protected bool $queryBuilderEnabled = true;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
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
     * @return Builder
     */
    public function newQuery(): Builder
    {
        return $this->model->newQuery();
    }
    /**
     * @param $relationships
     * @return Builder
     */
    public function with($relationships): Builder
    {
        return $this->newQuery()->with($relationships);
    }
    /**
     * Find model by id
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
     * Find model by params
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
    /**
     * Find list by params
     *
     * @param array $params
     * @return Collection
     */
    public function getByParams(array $params): Collection
    {
        return $this->newQuery()
            ->where($params)
            ->get();
    }
    /**
     * @return BaseService
     */
    public function withQueryBuilder(): BaseService
    {
        $this->queryBuilderEnabled = true;
        return $this;
    }
    /**
     * @return BaseService
     */
    public function withoutQueryBuilder(): BaseService
    {
        $this->queryBuilderEnabled = false;
        return $this;
    }
    /**
     * Find model collection
     *
     * @return Collection
     */
    public function get(): Collection
    {
        return $this->newQuery()
            ->get();
    }
    /**
     * Update model
     *
     * @param array $data
     * @return bool
     */
    public function update(array $data): bool
    {
        return $this->model->update($data);
    }
    /**
     * Delete model
     *
     * @return bool
     * @throws Exception
     */
    public function delete(): bool
    {
        return $this->model->delete();
    }

    /**
     * @param string $pageName
     * @param callable|array $callback
     * @return View
     */
    public function showPage(string $pageName, callable|array $callback): View
    {
        if(is_callable($callback)){
            return view("pages.{$pageName}",$callback());
        }
        return view("pages.{$pageName}",$callback);
    }

    /**
     * Paginate model collection
     *
     * @param int $numberOfPages
     * @return LengthAwarePaginator
     */
    public function paginate(int $numberOfPages): LengthAwarePaginator
    {
        return $this->newQuery()->paginate($numberOfPages);
    }

    /**
     * @return array
     */
    public function transformItem(): array
    {
        return $this->processItemTransformer($this->model, $this->getTransformer(), $this->getResourceKey());
    }

    /**
     * @param $data
     * @return array
     */
    public function transformCollection($data): array
    {
        return $this->processCollectionTransformer($data, $this->getTransformer(), $this->getResourceKey());
    }
    /**
     * Set model
     *
     * @param Model|null $model
     */
    public function setModel(?Model $model)
    {
        $this->model = $model;
    }
}
