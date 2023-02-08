<?php
require '../model/saida_model.php';

class Saida
{
    private $saidaModel;
    public function __construct()
    {
        $this->saidaModel = new SaidaModel();
    }
    public function salvarEntrada()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'];
        $id_tipo = $data['id2'];
        $date = date("Y-m-d H:i:s");
        $descricao = $data['descricao'];
        if (trim($descricao) == null) {
            echo 'error nulo';
        } else if (is_numeric($descricao)) {
            echo 'e numeros';
        } else if (strlen($descricao) > 15) {
            echo 'error';
        } else {
           $resposta = $this->saidaModel->salvarModel($id,$id_tipo,$descricao,$date);
           $arrayz['descricao'] = $data['descricao'];
           $arrayz['date'] = date("Y/m/d");
           $arrayz['id'] =  $data['id'];
           $arrayz['id2'] =  $data['id2'];
           echo json_encode($resposta);
           
        }

        // header("Location: http://localhost:3000/view/tipos/tipo_view.html#");
    }
    public function listarEntrada()
    {
        $saidas = $this->saidaModel->listarModel();
        $teste = $saidas[0]['total'];
        echo json_encode($saidas);
    }
    public function delet()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $del = $this->saidaModel->deletarModel($data['id']);
        $arrayz['id'] = $data['id'];
        $arrayz['status'] = $del;
        $arrayz['msg'] = "DELETEI";
        echo json_encode($arrayz);
    }
    public function editar(){
        $data = json_decode(file_get_contents('php://input'), true);
        $resposta = $this->saidaModel->editarModel( $data['id'],$data['id2'],$data['descricao'],$data['date']);
        $arrayz['id'] = $data['id'];
        $arrayz['descricao'] = $data['descricao'];
        echo json_encode($arrayz);
    }
    
}
$funcao = $_GET['funcao'];
$classe = new Saida();

$classe->$funcao();