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

        //Condição de ifs
        if (trim($id_tipo == null)) {
            echo 'O id_tipo e nulo';
            return;
        } else if (is_string($id_tipo)) {
            echo 'O id_tipo não pode ser string';
            return;
        } else if (trim($descricao) == null) {
            echo 'error nulo';
            return;
        } else if (is_numeric($descricao)) {
            echo 'Não pode ser um numero';
            return;
        } else if (strlen($descricao) > 90) {
            echo 'Limite Ultrapassado';
            return;
        } else if ($valor == null) {
            echo 'o valor não pode ser nulo';
            return;
        } else if (is_string($valor)) {
            echo 'o valor não pode ser string';
            return;
        }

        $resposta = $this->entradaModel->salvarModel($id_tipo, $descricao, $date, $valor);
        $arrayz['descricao'] = $data['descricao'];
        $arrayz['date'] = date("Y/m/d");
        $arrayz['id'] =  $resposta;
        $arrayz['id2'] =  $data['id2'];
        $arrayz['valor'] =  $data['valor'];
        echo json_encode($arrayz);


        // header("Location: http://localhost:3000/view/tipos/tipo_view.html#");
    }
    public function listarEntrada()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
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
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            echo 'Metodo invalido';
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'];
        
        if(trim($id == null)){
            echo 'O id_tipo e nulo';
            return;
        }
        else if (is_string($id)){
            echo 'O id_tipo não pode ser string';
            return;
        }
        
        $del = $this->entradaModel->deletarModel($id);
        $arrayz['id'] = $id;
        $arrayz['status'] = $del;
        $arrayz['msg'] = "DELETEI";
        echo json_encode($arrayz);
    }

    public function editarEntrada()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'PUT') {
            echo 'Metodo invalido';
            return;
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'];
        $id2 = $data['id2'];
        $descricao = $data['descricao'];
        $valor = $data['valor'];

        if(trim($id == null)){
            echo 'O id_tipo e nulo';
            return;
        }
        else if (is_string($id)){
            echo 'O id_tipo não pode ser string';
            return;
        }
        else if(trim($id2 == null)){
            echo 'O id_tipo e nulo';
            return;
        }
        else if (is_string($id2)){
            echo 'O id_tipo não pode ser string';
            return;
        }
        else if (trim($descricao) == null) {
            echo 'error nulo';
            return;
        } else if (is_numeric($descricao)) {
            echo 'Não pode ser um numero';
            return;
        } else if (strlen($descricao) > 90) {
            echo 'Limite Ultrapassado';
            return;
        } else if ($valor == null){
            echo 'o valor não pode ser nulo';
            return;
        }else if (is_string($valor)){
            echo 'o valor não pode ser string';
            return;
        }

        $resposta = $this->entradaModel->editarModel($id, $id2, $descricao, $valor);
        $arrayz['id'] = $id;
        $arrayz['descricao'] = $descricao;
        $arrayz['status'] =  $resposta;
        $arrayz['valor'] =  $valor;
        echo json_encode($arrayz);
    }
}
$funcao = $_GET['funcao'];
$classe = new Entrada();

$classe->$funcao();
