<?php

abstract class Model {

    protected $db;

    public function __construct()
    {
        global $APP;
        $this->db = $APP['DB'];
    }

    public function create($fieldList)
    {
        return $this->db->create($this->tableName, $fieldList);

    }

    // public function read($tableName, $column = '*', $where = [], $sort_column = []) {
    public function read()
    {
        return $this->db->read($this->tableName);
    }

    public function update($id, $fieldList)
    {
        return $this->db->update($id, $this->tableName, $fieldList);
    }

    public function delete($id)
    {
        return $this->db->delete($id, $this->tableName);
    }

}
