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
    
    /**
     * @var \TCPDF
     */
    protected $tcpdf;
    
    /**
     * @var RendererInterface
     */
    protected $renderer;

    public function __construct(ProductosTable $table, $tspdf, $renderer)
    {
        $this->table = $table;
        
        $this->tcpdf = $tspdf;
        
        $this->renderer = $renderer;
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

    public function creacionAction (){
        
        return new ViewModel([

            'productos' => $this->table->fetchAll(),
        ]);
    }

    public function indexAction ()
    {
        
        $buscar = '';
        
        if ($this->getRequest()->isPost()) {
            
            $buscar = $this->params()->fromPost()['texto_buscar'];
            
        }
        
        return new ViewModel([

            'productos' => $this->table->fetchAll($buscar),
            
        ]);
    }


    public function pdfAction ()
    {
        
        $pdf = $this->tcpdf;
        
        $view = new ViewModel();
        
        $renderer = $this->renderer;
        
        $view->setTemplate('layout/pdf.phtml');
        
        $view->setVariable('productos', $this->table->fetchAll());
        
        $html = $renderer->render($view);
        
        $pdf->AddPage('LANDSCAPE');
        
        $pdf->writeHTML(($html), true, false, true, false, '');
        
        $pdf->Output(dirname(__FILE__) .'../../../../../data/registros.pdf',"FD");
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

    public function crearAction ()
    {
        return new ViewModel([

            'productos' => $this->table->fetchAll(),
        ]);
    }

  /*  public function calculadoraAction(){

        $form = new MainForm();

        $form->get('submit')->setValue("Generar");

        return [
            'form' => $form
        ];
    }*/

    public function generarAction(){

        $postData = $this->getRequest()->getPost();

        $calculadora = new Calculadora($postData);

        $pdf = $this->tcpdf;

        $view = new ViewModel();

        $renderer = $this->renderer;

        $view->setTemplate('layout/pdf.phtml');

        $view->setVariable('nombre_completo', $_POST['nombres']);

        $view->setVariable('identificacion', $_POST['precio']);

        $view->setVariable('valor_solicitado', $_POST['cantidad']);

        $view->setVariable('plazo', $_POST['marca']);


        $html = $renderer->render($view);

        $viewTable = new ViewModel();

        $viewTable->setTemplate('layout/table_pdf.phtml');

        if ($_POST['periodo_gracia'] == 0)

            $viewTable->setVariable('tableTittle', 'Cuadro de amortización cuota fija');

        else

            $viewTable->setVariable('tableTittle', 'Cuadro de amortización cuota fija con periodo de gracia');

        $viewTable->setVariable('tableContent', $calculadora->getTableAmortizacionCuotaFija());

        $htmlTable = $renderer->render($viewTable);

        $pdf->SetFont('arialnarrow', '', 12, '', false);

        $pdf->AddPage('LANDSCAPE');

        $pdf->writeHTML(($html.$htmlTable), true, false, true, false, '');

        $pdf->Output(dirname(__FILE__) .'../../../../../data/pdf/reportes_productos_'.$_POST['identificacion'].'.pdf',"FD");
    }
    
}

