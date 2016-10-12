<?php

namespace App;

use DB;

trait EnumTrait {

    /**
     * Retrieves the acceptable enum fields for a column
     *
     * @param string $column Column name
     *
     * @return array
     */
    public static function getEnumValues($column) 
    {
        // Create an instance of the model to be able to get the table name
        $instance = new static;

        // Pulls column string from DB
        $enumStr = DB::select(DB::raw('SHOW COLUMNS FROM '.$instance->getTable().' WHERE Field = "'.$column.'"'))[0]->Type;

        // Parse string
        preg_match_all("/'([^']+)'/", $enumStr, $matches);

        // Return matches
        return isset($matches[1]) ? $matches[1] : [];
    }

    public static function getEnumValuesExcept($column, $except) 
    {
        $instance = new static;
        $enumStr  = DB::select(DB::raw('SHOW COLUMNS FROM '.$instance->getTable().' WHERE Field = "'.$column.'"'))[0]->Type;
        preg_match_all("/'([^']+)'/", $enumStr, $matches);
        $values   = isset($matches[1]) ? $matches[1] : [];

        if (($key = array_search($except, $values)) !== false) {
            unset($values[$key]);
        }

        return $values;
    }
}

