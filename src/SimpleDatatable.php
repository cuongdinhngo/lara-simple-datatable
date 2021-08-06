<?php

namespace Cuongnd88\LaraSimpleDatatable;

use Illuminate\Database\Eloquent\Model;

class SimpleDatatable
{
    /**
     * Query Builder
     *
     * @var object
     */
    protected $query;

    /**
     * Quantity of items per page
     *
     * @var int
     */
    protected $perPage;

    /**
     * Items Collection
     *
     * @var Collection
     */
    protected $items;

    /**
     * Add/Edit columns
     *
     * @var array
     */
    protected $columns = [];

    /**
     * Edit columns
     *
     * @var array
     */
    protected $editColumns = [];

    /**
     * Current page number
     *
     * @var int
     */
    protected $currentPage;

    /**
     * Set Query builder
     *
     * @param  object $query Query builder
     *
     * @return this
     */
    public function buildQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     * Set quantity of items per page
     *
     * @param int $perPage
     */
    public function setPerPage(int $perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }

    /**
     * Add Column
     *
     * @param string $key       Column name
     * @param mixed  $operation Column operation
     */
    public function addColumn(string $key, $operation = null)
    {
        $this->columns[$key] = $operation;
        return $this;
    }

    /**
     * Add increment number
     *
     * @param mixed $operation Column operation
     */
    public function addIncrement($operation = null)
    {
        $this->columns['increment'] = $operation;
        return $this;
    }

    /**
     * Edit column
     *
     * @param string $key       Column name
     * @param mixed  $operation Column operation
     *
     * @return this
     */
    public function editColumn(string $key, $operation = null)
    {
        $this->editColumns[$key] = $operation;
        return $this;
    }

    /**
     * Make simple datatable
     *
     * @return object
     */
    public function make()
    {
        $items = $this->query->paginate($this->perPage);
        $this->currentPage = $items->currentPage();
        foreach ($items as $index => $item) {
            $items[$index] = $this->combineData($item, $index);
        }
        return $items;
    }

    /**
     * Combine data
     *
     * @param  mixed $row   [description]
     * @param  int $index [description]
     *
     * @return array
     */
    public function combineData($row, $index)
    {
        if ($row instanceof Model) {
            $row = $row->toArray();
        }
        if (gettype($row) === "object") {
            $row = (array)$row;
        }
        if (false === $this->checkEditColumns($row)) {
            throw new \Exception("Edit Columns Are Not Existed");
        }
        $result = $row;
        $this->columns = array_merge($this->columns, $this->editColumns);
        foreach ($this->columns as $key => $operation) {
            if ($key == 'increment') {
                $row[$key] = ($this->currentPage - 1) * $this->perPage + $index + 1;
            }
            if (empty($operation)) {
                $result[$key] = $row[$key];
                continue;
            }
            if (is_callable($operation)) {
                $result[$key] = $operation($row, $index);
                continue;
            }
            $result[$key] = view($operation, $row);
        }
        return $result;
    }

    /**
     * Check edit columns
     *
     * @param  array  $row [description]
     *
     * @return boolean
     */
    public function checkEditColumns(array $row)
    {
        return empty(array_diff_key($this->editColumns, $row));
    }
}
