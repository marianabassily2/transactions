<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    /**
     * @param  array  $attributes
     * @return Model
     */
    public function create(array $attributes);

    /**
     * Configure the Model
     *
     * @return string
     */
    public function model();

    /**
     * @param $id
     * @return Model
     */
    public function find($id);

    /**
     * @param $id
     * @return bool
     */
    public function delete($id);

    /**
     * Update model record for given id
     *
     * @param  array  $input
     * @param  int  $id
     * @return Model
     */
    public function update($input, $id);

}
