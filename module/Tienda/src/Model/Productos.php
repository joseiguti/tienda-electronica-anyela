<?php

namespace Tienda\Model;

class Productos
{
    public $id;

    public $nombre;

    public $precio;

    public $cantidad;

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;

        $this->nombre = !empty($data['nombre']) ? $data['nombre'] : null;

        $this->precio = !empty($data['precio']) ? $data['precio'] : null;

        $this->cantidad = !empty($data['cantidad']) ? $data['cantidad'] : null;
    }
}