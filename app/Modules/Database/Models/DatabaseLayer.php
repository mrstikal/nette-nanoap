<?php

declare(strict_types=1);

namespace App\Modules\Database\Models;

use Nette\Database\Explorer;
use Nette\SmartObject;

/**
 * Layer for database connection.
 * It uses Nette\Database\Explorer now.
 * If you want to change database provider, 
 * please change all methods in this class.
 */
class DatabaseLayer
{
    use SmartObject;

    /**
     * @var Nette\Database\Explorer
     */
    public $database;

    /**
     * Service layer for database connection.
     * @param Explorer $database
     */
    public function __construct(Explorer $database)
    {
        $this->database = $database;
    }

    /**
     * Simple helper method.
     * Fetches one row from database.
     *
     * @param string $tableName name of sql table
     * @param array $whereCondition array of arrays of where contditions, format [['key' => 'my_key_name', 'value' => 'my_value']]
     * @param string $fields field to inculde in select query
     * @return mixed query result or false if no rows found
     */
    public function fetchOneRow(string $tableName, array $whereCondition = [], string $fields = '*')
    {
        $query = $this->database->table($tableName);
        $query->select($fields);

        if (!empty($whereCondition)) {
            foreach ($whereCondition as $condition) {
                $query->where($condition['key'], $condition['value']);
            }
        }

        $fetch = $query->fetch();

        if (empty($fetch)) return false;

        return $fetch->toArray();
    }

    /**
     * Simple helper method.
     * Updates one row in database.
     *
     * @param string $tableName
     * @param array $whereCondition
     * @param array $updateParams
     * @return boolean
     */
    public function updateOneRow(string $tableName, array $whereCondition, array $updateParams): bool
    {
        if (empty($whereCondition) || empty($updateParams)) {
            return false;
        }

        $query = $this->database->table($tableName);

        foreach ($whereCondition as $condition) {
            $query->where($condition['key'], $condition['value']);
        }

        $query->update($updateParams);

        return true;
    }
}
