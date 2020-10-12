<?php 

namespace Tienda\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Tienda\Model\Productos;
use Tienda\Model\ProductosTable;
use function GuzzleHttp\json_decode;
use Laminas\View\Model\ViewModel;
use Tienda\Form\ProductosForm;

class TiendaController extends AbstractActionController {

    // Add this property:
    private $table;

    public function __construct(ProductosTable $table)
    {
        $this->table = $table;
    }

    public function saludarAction (){

        $producto = $this->table->getProducto(3);

        return new ViewModel(['nombre' => $producto->nombre]);
    }
    public function calcularAction (){
        return new ViewModel([

            'productos' => $this->table->fetchAll(),
        ]);
    }

    public function indexAction ()
    {
        return new ViewModel([

            'productos' => $this->table->fetchAll(),
        ]);
    }


    public function recordAction ()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        // Nuevo producto
        if ($id == 0){

            $form = new ProductosForm();

            $form->get('submit')->setValue('Agregar');

            if (! $this->getRequest()->isPost()) {

                return ['form' => $form];
            }

            $data = $this->params()->fromPost();

            $form->setData($data);

            if (! $form->isValid()) {

                return ['form' => $form];
            }

            $producto = new Productos();

            $producto->exchangeArray($data);

            $this->table->saveProducto($producto);

            return $this->redirect()->toRoute('tienda');

            // Editar producto
        }else{

            try {

                $producto = $this->table->getProducto($id);

            } catch (\Exception $e) {

                return $this->redirect()->toRoute('tienda', ['action' => 'index']);
                          }

            catch (\Exception $e) {

                 return $this->redirect()->toRoute('calcular', ['action' => 'calcular']);
            }



            $form = new ProductosForm($producto);

            if (! $this->getRequest()->isPost()) {

                return ['id' => $id, 'form' => $form];
            }

            $data = $this->params()->fromPost();

            $form->setData($data);

            if (! $form->isValid()) {

                return ['form' => $form];
            }

            $producto = new Productos();

            $producto->exchangeArray($data);

            $this->table->saveProducto($producto);

            return $this->redirect()->toRoute('tienda');
        }

    }

    public function deleteAction (){

        $id = (int) $this->params()->fromRoute('id', 0);

        $this->table->deleteProducto($id);

        return $this->redirect()->toRoute('tienda');
    }


    
}

