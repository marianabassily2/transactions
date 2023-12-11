<?php

namespace App\Repositories;
 
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Throwable;

abstract class BaseRepository implements RepositoryInterface
{
    /**
     * @var App
     */
    private $app;

    /**
     * @var
     */
    protected $model;

    /**
     * @param  App  $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    // abstract function model();

    /**
     * Make Model instance
     *
     * @return Model
     *
     * @throws Exception
     */
    public function makeModel()
    {
        $model = App::make($this->model());

        if (! $model instanceof Model) {
            throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * Build a query for retrieving all records.
     *
     * @param  array  $search
     * @param  int|null  $skip
     * @param  int|null  $limit
     * @return Builder
     */
    public function allQuery($search = [], $skip = null, $limit = null)
    {
        $query = $this->model->newQuery();

        if (count($search)) {
            foreach ($search as $key => $value) {
                if (in_array($key, $this->model->getFieldsSearchable())) {
                    $query->where($key, $value);
                }
            }
        }

        if (! is_null($skip)) {
            $query->skip($skip);
        }

        if (! is_null($limit)) {
            $query->limit($limit);
        }

        return $query;
    }

    /**
     * Retrieve all records with given filter criteria
     *
     * @param  array  $search
     * @param  int|null  $skip
     * @param  int|null  $limit
     * @param  array  $columns
     * @return LengthAwarePaginator|Builder[]|Collection
     */
    public function all($search = [], $skip = null, $limit = null, $columns = ['*'])
    {
        $query = $this->allQuery($search, $skip, $limit);

        return $query->get($columns);
    }

    /**
     * Create model record
     *
     * @param  array  $input
     * @return Model
     */
    public function create($input = [])
    {
        try {
            $model = $this->model->newInstance($input);
            $model->save();

            return $model;
        } catch (Throwable $e) {
            throw $e;
        }
    }

    /**
     * Insert model records
     *
     * @param  array  $input
     * @return bool
     */
    public function insert($input = [])
    {
        try {
            return $this->model->insert($input);
        } catch (Throwable $e) {
            throw $e;
        }
    }


    /**
     * Find model record for given id
     *
     * @param  int  $id
     * @param  array  $columns
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function find($id, $columns = ['*'])
    {
        $query = $this->model->newQuery();

        return $query->find($id, $columns);
    }

    /**
     * Update model record for given id
     *
     * @param  array  $input
     * @param  int  $id
     * @return Model
     */
    public function update($input, $id)
    {
        $query = $this->model->newQuery();

        $model = $query->findOrFail($id);

        if (empty($input)) {
            $input = [];
        }

        $model->fill($input);

        $model->save();

        return $model;
    }

    /**
     * @param  int  $id
     * @return bool|mixed|null
     *
     * @throws Exception
     */
    public function delete($id)
    {
        $query = $this->model->newQuery();

        $model = $query->findOrFail($id);

        return $model->delete();
    }
 
}
