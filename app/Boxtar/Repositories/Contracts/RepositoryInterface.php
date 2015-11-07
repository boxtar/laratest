<?php
/**
 * Created by PhpStorm.
 * User: johnpaul
 * Date: 29/10/2015
 * Time: 18:46
 */

namespace App\Boxtar\Repositories\Contracts;


interface Repository
{
    public function all($columns = ['*']);
    public function paginate($per_page = 15, $columns = ['*']);
    public function create(array $data);
    public function update(array $data, $id);
    public function delete($id);
    public function find($id, $columns = ['*']);
    public function findBy($field, $value, $columns = ['*']);
}