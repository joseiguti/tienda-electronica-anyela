<?php 

namespace Tienda\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use function GuzzleHttp\json_decode;
use Laminas\View\Model\ViewModel;

class BdController extends AbstractActionController {

    private $adapter;
    
    public function __construct(\Laminas\Db\Adapter\Adapter $dbController)
    {
        $this->adapter = $dbController;        
    }
    
    public function indexAction ()
    {
        
        $success = false;
        
        $dbname = 'bdunad301127_1';
        
        $qstment = $this->adapter->createStatement("SHOW DATABASES LIKE '$dbname'");
        
        $res = $qstment->execute();

        if (!count($res)){
         
            $cstment = $this->adapter->createStatement('CREATE DATABASE IF NOT EXISTS '.$dbname);
            
            $res = $cstment->execute();
            
            $success = $res->getAffectedRows()>0?true:false;
        }        
        
        return new ViewModel([

            'form' => '',
            
            'success' => $success
        ]);
    }

    public function index2Action ()
    {

        $success = false;

        $dbname = 'bdunad301127_1';

        $qstment = $this->adapter->createStatement("SHOW DATABASES LIKE '$dbname'");

        $res = $qstment->execute();

        if (!count($res)){

            $cstment = $this->adapter->createStatement('CREATE DATABASE IF NOT EXISTS '.$dbname);

            $res = $cstment->execute();

            $success = $res->getAffectedRows()>0?true:false;
        }

        return new ViewModel([

            'form' => '',

            'success' => $success
        ]);
    }
    
}

