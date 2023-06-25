<?php

namespace App\Modules\Common\Contratct;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use League\Fractal\TransformerAbstract;

interface BaseService
{
    public function create(array $data): Model;
    public function findById(int $id): Model;
    public function findByParams(array $params): Model;
    public function getByParams(array $params): Collection;
    public function get(): Collection;
    public function update(array $data): bool;
    public function delete(): bool;
    public function newQuery();
    public function with($relationships);
    public function withQueryBuilder(): self;
    public function withoutQueryBuilder(): self;
    public function paginate(int $numberOfPages): LengthAwarePaginator;
    public function transformNull(): array;

    public function transformItem(): array;

    public function transformCollection($data): array;

    public function getTransformer(): TransformerAbstract;

    public function getResourceKey(): string;
    public function setModel(?Model $model);

}
