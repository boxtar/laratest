<?php
namespace App\Contracts;

interface Search{

    public function in($table);

    public function find($query);

    public function inColumn($column, $table);

    public function setQueryOperator($operator);

    public function go();

}