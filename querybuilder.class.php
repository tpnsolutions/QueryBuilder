<?php

/**
 * @author  Peter Knowles <pknowles@tpnsolutions.com>
 * @version 25.7.14
 */

// declare
declare(strict_types=1);

// namespace
namespace tpnSolutions;

// class
class QueryBuilder
{
    private string $from = '';
    private string $join = '';
    private string $limit = '';
    private string $order = '';
    private string $select = '';
    private string $where = '';

    public function build()
    {
        (array) $query = [];

        try {
            if (empty($this->select)) {
                throw new \Error('missing "select"');
            }

            $query[] = $this->select;

            if (empty($this->from)) {
                throw new \Error('missing "from"');
            }

            $query[] = $this->from;

            if (!empty($this->join)) {
                $query[] = $this->join;
            }

            if (!empty($this->where)) {
                $query[] = $this->where;
            }

            if (!empty($this->order)) {
                $query[] = $this->order;
            }

            if (!empty($this->limit)) {
                $query[] = $this->limit;
            }

            return (object) [
                'status' => 'success',
                'query' => implode(' ', $query)
            ];
        } catch (\Error | \Exception $e) {
            return (object) [
                'status' => 'error',
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ];
        }
    }

    public function from(array $tables = [])
    {
        if (empty($this->from)) {
            if (!empty($tables) && count($tables) > 0) {
                $this->from = 'FROM ' . implode(', ', $tables);
            }
        }

        return $this;
    }

    public function join(array $joins = [])
    {
        if (empty($this->join)) {
            if (!empty($joins) && count($join) > 0) {
                $this->join = implode(' ', $joins);
            }
        }

        return $this;
    }

    public function limit(int $max = 0, int $min = 0)
    {
        if (empty($this->limit)) {
            if (!empty($max) && $max > 0) {
                if (!empty($min) && $min > 0) {
                    $this->limit = 'LIMIT ' . $min . ',' . $max;
                } else {
                    $this->limit = 'LIMIT ' . $max;
                }
            }
        }

        return $this;
    }

    public function order(array $columns = [])
    {
        if (empty($this->order)) {
            if (!empty($columns) && count($columns) > 0) {
                $this->order = 'ORDER BY ' . implode(', ', $columns);
            }
        }

        return $this;
    }

    public function where(array $conditions = [])
    {
        if (empty($this->where)) {
            if (!empty($conditions) && count($conditions) > 0) {
                $this->where = 'WHERE ' . implode(' AND ', $conditions);
            }
        }

        return $this;
    }
}
