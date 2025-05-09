<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class SearchEngine
{

    private static $instance;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new SearchEngine();
        }

        return self::$instance;
    }

    public function search(Model $model, $query, array $searchColumns)
    {
        $results = $model::where(function (Builder $queryBuilder) use ($searchColumns, $query) {
            foreach ($searchColumns as $column) {
                $queryBuilder->orWhere($column, 'LIKE', '%' . $query . '%');
            }
        })->get();

        return $results;
    }
}
