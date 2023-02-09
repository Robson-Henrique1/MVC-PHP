<?php

require '../model/entradas_model.php';

date_default_timezone_set('America/Sao_Paulo');

class Entrada
{

    private $entradaModel;

    public function __construct()
    {
        $this->entradaModel = new EntradasModel();
    }
    public function salvarEntrada()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            echo 'Metodo invalido';
            return;
        }
        $data = json_decode(file_get_contents('php://input'), true);
        $id_tipo = $data['id2'];
        $date = date("Y-m-d H:i:s");
        $descricao = $data['descricao'];
        $valor = $data['valor'];

        if (trim($descricao) == null) {
            echo 'error nulo';
        } else if (is_numeric($descricao)) {
            echo 'e numeros';
        } else if (strlen($descricao) > 15) {
            echo 'error';
        } else {
            $resposta = $this->entradaModel->salvarModel($id_tipo, $descricao, $date, $valor);
            $arrayz['descricao'] = $data['descricao'];
            $arrayz['date'] = date("Y/m/d");
            $arrayz['id'] =  $resposta;
            $arrayz['id2'] =  $data['id2'];
            $arrayz['valor'] =  $data['valor'];
            echo json_encode($arrayz);
        }

        // header("Location: http://localhost:3000/view/tipos/tipo_view.html#");
    }
    public function listarEntrada()
    {
        if($_SERVER['REQUEST_METHOD'] != 'GET'){
            echo 'Metodo invalido';
            return;
        }
        $entradas = $this->entradaModel->listarModel();
        $total = $this->entradaModel->pegarTotal();
        $resultado['entradas'] = $entradas;
        $resultado['total'] = $total[0]['total'];
        echo json_encode($resultado);
    }
    public function deletEntrada()
    {
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            echo 'Metodo invalido';
            return;
        }
        $data = json_decode(file_get_contents('php://input'), true);
        $del = $this->entradaModel->deletarModel($data['id']);
        $arrayz['id'] = $data['id'];
        $arrayz['status'] = $del;
        $arrayz['msg'] = "DELETEI";
        echo json_encode($arrayz);
    }
    public function editarEntrada()
    {
        if($_SERVER['REQUEST_METHOD'] != 'PUT'){
            echo 'Metodo invalido';
            return;
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'];
        $id2 = $data['id2'];
        $descricao = $data['descricao'];
        $valor = $data['valor'];
        $resposta = $this->entradaModel->editarModel($id, $id2, $descricao, $valor);
        $arrayz['id'] = $id;
        $arrayz['descricao'] = $data['descricao'];
        $arrayz['status'] =  $resposta;
        $arrayz['valor'] =  $valor;
        echo json_encode($arrayz);
    }
}
$funcao = $_GET['funcao'];
$classe = new Entrada();

$classe->$funcao();
