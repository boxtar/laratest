<?php
namespace App\Services;

use App\Contracts\Search;

class EloquentSearch implements Search{

    /**
    |--------------------------------------
    | the query string to be searched for
    |--------------------------------------
     */

    protected $query_string = '';

    /**
    |--------------------------------------
    | the operator to be used in the where
    | clause
    |--------------------------------------
     */

    protected $query_operator = '=';

    /**
    |--------------------------------------
    | an array which holds the models to be
    | searched upon and the fields to be
    | searched in within each model
    |--------------------------------------
     */

    protected $search_settings = [];

    /**
     * |--------------------------------------
     * | set the models that are to be
     * | searched in
     * |--------------------------------------
     * @param $models
     * @return $this
     */

    public function in($models){

        if(is_array($models)){

            foreach($models as $model)

                $this->in($model);

        }
        elseif(is_string($models)){

            $this->search_settings[$models] = array(
                'model' 	=> new $models(),
                'columns'  	=> array()
			);

		}
        else{

            // Internal Server Error
            abort(500);

        }

        return $this;

    }

    /**
     * |--------------------------------------
     * | set the string to be searched for
     * |--------------------------------------
     * @param $query
     * @return $this
     */

    public function find($query){

        $this->query_string = $query;

        return $this;

    }

    /**
     * |--------------------------------------
     * | Set the columns
     * |--------------------------------------
     * @param $columns
     * @param null $table
     * @return $this
     */

    public function inColumn($columns, $table=null){

        if(! $table){
            if(is_array($columns)){
                foreach($columns as $column)
                    $this->inColumn($column);
            }
            elseif(is_string($columns)){
                foreach($this->search_settings as &$model){
                    array_push($model['columns'], $columns);
                }
            }
        }
        else{
            if(is_array($columns)){
                foreach($columns as $column)
                    $this->inColumn($column, $table);
            }
            elseif(is_string($columns)){
                array_push($this->search_settings[$table]['columns'], $columns);
			}
        }
        return $this;
    }

    /**
    |--------------------------------------
    | process the search
    |--------------------------------------
     */

    public function go(){

        // Create the collection to store all results
        $results = app(\Illuminate\Support\Collection::class);

        // Prepend and Append Wildcards to Query String if using Operator "LIKE"
        if($this->query_operator == 'like') $this->query_string = '%' . $this->query_string . '%';

        foreach($this->search_settings as $setting){
            foreach($setting['columns'] as $column){
                $results = $results->merge(
                        $setting['model']
                            ->where($column, $this->query_operator, "$this->query_string")
                            ->get()
                    );
            }
        }
        return $results;
    }

    public function setQueryOperator($query_op)
    {
        $this->query_operator = strtolower($query_op);
        return $this;
    }

    public function usingLike()
    {
        return $this->setQueryOperator('like');
    }

}