<?php

namespace Tienda\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;

use Laminas\Db\Sql\Select;
use Tienda\Model\Productos;
use Laminas\Db\Sql\Where;

class ProductosTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($findByName = '')
    {        
        $where = new Where();
        
        $where->like('nombre', '%'.$findByName.'%');
        
        return $this->tableGateway->select($where);
    }

    public function getProducto($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveProducto(Productos $producto)
    {
        $data = [
            'nombre' => $producto->nombre,
            'precio' => $producto->precio,
            'cantidad' => $producto->cantidad,
            'marca' => $producto->marca,
        ];

        $id = (int) $producto->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getProducto($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update Producto with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteProducto($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}