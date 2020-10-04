<?php

namespace Tienda\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Tienda\Model\Productos;

class ProductosTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
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