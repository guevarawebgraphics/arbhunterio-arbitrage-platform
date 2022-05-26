<?php

namespace App\Services\Base;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class RepositoryInterface
 * @package App\Servicess\Base
 * @author Richard Guevara
 */

interface RepositoryInterface
{
    /**
     * Paginate with relations returned by this method
     *
     * @return array
     */
    public function withRelations(): array;

    /**
     * Paginate only with relations returned by this method
     *
     * @return array
     */
    public function hasRelations(): array;

    /**
     * Get all data
     *
     * @param  bool $onlyTrashed filter for `deleted_at` column
     * @return mixed
     */
    public function all(bool $onlyTrashed = false);

    /**
     * Get single data by id
     *
     * @param  string $id unique id of the item
     * @return mixed
     */
    public function get(string $id);

    /**
     * Get paginated results
     *
     * @param  int $page current page
     * @param  int $perPage max item per page
     * @param  bool $onlyTrashed filter for `deleted_at` column
     * @return mixed
     */
    public function paginate(int $page = 1, int $perPage = 10, bool $onlyTrashed = false);

    /**
     * Get paginated results
     *
     * @param  array $filter filter data for column
     * @param  int $page current page
     * @param  int $perPage max item per page
     * @param  bool $onlyTrashed filter for `deleted_at` column
     * @return mixed
     */
    public function paginateWithFilter(
        array $filter,
        int $page = 1,
        int $perPage = 10,
        array $sorting = [],
        bool $onlyTrashed = false
    ): LengthAwarePaginator;

    /**
     * Create new data entry
     *
     * @param  array $data array of data to be created, usually same as db table columns
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update data entry
     *
     * @param  string $id unique id of the item
     * @param  array $data array of data to be updated, usually same as db table columns
     * @return mixed
     */
    public function update(string $id, array $data);

    /**
     * Delete data entry
     *
     * @param  string $id unique id of the item
     * @return mixed
     */
    public function delete(string $id);

    /**
     * Restore data entry. Used by soft deletes
     *
     * @param  string $id unique id of the item
     * @return mixed
     */
    public function restore(string $id);
    
    /**
     * Remove Duplicates on Array
     *
     * @param  mix 
     * @return array
     */
    public function arrayUnique($array, $key);
}
