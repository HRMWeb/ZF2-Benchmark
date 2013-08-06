<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class BenchTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getBench($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveBench(Bench $bench)
    {
        $data = array(
            'title'  => $bench->title,
        );

        $id = (int)$bench->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
            return $this->tableGateway->lastInsertValue;
        } else {
            if ($this->getBench($id)) {
                $this->tableGateway->update($data, array('id' => $id));
                return $id;
            } else {
                throw new \Exception('Bench id does not exist');
            }
        }
    }

    public function deleteBench($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}