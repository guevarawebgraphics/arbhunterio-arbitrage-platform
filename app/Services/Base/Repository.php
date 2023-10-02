<?php

namespace App\Services\Base;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator as PaginationLengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class Repository
 * @package App\Servicess\Base
 * @author Guevara Web Graphics Studio
 */

class Repository implements RepositoryInterface
{
    protected $model;

    /**
     * Repository constructor.
     *
     * @param  Model|null $model the data model to initialized
     */
    public function __construct(?Model $model)
    {
        $this->model = $model;
    }

    public function withRelations(): array
    {
        return [];
    }

    public function hasRelations(): array
    {
        return [];
    }

    public function all(bool $onlyTrashed = false)
    {
        $query = $this->model->newQuery()->with($this->withRelations());

        foreach ($this->hasRelations() as $hasRelation) {
            $query->has($hasRelation);
        }

        if ($onlyTrashed) {
            $query->onlyTrashed();
        }

        return $query->get();
    }

    public function get(string $id)
    {
        $query = $this->model->newQuery()->with($this->withRelations());

        foreach ($this->hasRelations() as $hasRelation) {
            $query->has($hasRelation);
        }

        $result = $query->find($id);
        if ($result) {
            return $result;
        } else {
            abort('404', '404');
        }
    }

    public function paginate(int $page = 1, int $perPage = 10, bool $onlyTrashed = false, bool $withTrashed = false): LengthAwarePaginator
    {
        $query = $this->model->newQuery()->with($this->withRelations());

        foreach ($this->hasRelations() as $hasRelation) {
            $query->has($hasRelation);
        }

        if ($onlyTrashed) {
            $query->onlyTrashed();
        }

        if ($withTrashed) {
            $query->withTrashed();
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function paginateWithFilter(
        array $filter,
        int $page = 1,
        int $perPage = 10,
        array $sorting = [],
        bool $onlyTrashed = false
    ): LengthAwarePaginator {
        $query = $this->model->newQuery()->with($this->withRelations());

        foreach ($this->hasRelations() as $hasRelation) {
            $query->has($hasRelation);
        }

        foreach ($filter as $key => $value) {
            $key = explode('.', $key);
            $values = explode('|', $value);
            if (count($key) === 2) {
                $query->whereHas($key[0], function (Builder $query) use ($value, $key) {
                    $query->where($key[1], $value);
                });
            } else {
                if (count($values) > 1) {
                    $query->where(function ($q) use ($key, $values) {
                        foreach ($values as $value) {
                            $q->orWhere($key[0], $value);
                        }
                    });
                } else {
                    $query->where($key[0], $value);
                }
            }
        }

        foreach ($sorting as $key => $value) {
            $key = explode('->', $key);
            if (count($key) === 2) {
                $tableSnakeCase = Str::snake($key[0]);
                $tableSnakeCase = Str::plural($tableSnakeCase);
                $modelTable = $this->model->getTable();

                $query->join("$tableSnakeCase as table2", function ($join) use ($tableSnakeCase, $modelTable, $key, $value) {
                    $join->on("table2." . Str::singular($modelTable) . "_id", '=', "$modelTable.id")->select("$key[1]")->orderBy("$tableSnakeCase.$key[1]", $value);
                })->select("$modelTable.*", "table2.$key[1] as sortRow");
                $query->orderBy('sortRow', $value);
            } else {
                $query->orderBy($key[0], $value);
            }
        }

        if ($onlyTrashed) {
            $query->onlyTrashed();
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function create(array $data)
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(string $id, array $data)
    {
        $model = $this->get($id);

        if (!$model) {
            return false;
        }

        $model->fill($data);

        return $model->save();
    }

    public function delete(string $id)
    {
        return $this->model->destroy($id);
    }

    public function restore(string $id)
    {
        return $this->model->onlyTrashed()->findOrFail($id)->restore();
    }

    public function paginateArray($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new PaginationLengthAwarePaginator($items->forPage($page, $perPage)->values(), $items->count(), $perPage, $page, $options);
    }

    public function arrayUnique($array, $key)
    {
        $temp_array = [];

        foreach ($array as &$v) {
            if (!isset($temp_array[$v[$key]]))
            $temp_array[$v[$key]] =& $v;
        }

        $array = array_values($temp_array);
        
        return $array;
    }


}
