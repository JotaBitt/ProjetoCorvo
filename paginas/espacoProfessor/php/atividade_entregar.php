<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once '../../../session.php';


    try {
        
        //var_dump($_POST);
        //var_dump($_FILES);

        if(!isset($_POST['turma'], $_POST['atividade'], $_POST['observacoes'])) {
            echo 'Turma e/ou atividade não informada.';
            exit;
        }

        $stmt = $conn->prepare("SELECT * FROM corvo_atividades WHERE id = :atividade");
        $stmt->bindParam(':atividade', $_POST['atividade']);
        $stmt->execute();

        $atividade = $stmt->fetch();

        if(!$atividade) {
            echo 'Atividade não encontrada.';
            exit;
        }

        $stmt = $conn->prepare("SELECT * FROM corvo_turmas WHERE id = :turma");
        $stmt->bindParam(':turma', $_POST['turma']);
        $stmt->execute();

        $turma = $stmt->fetch();

        if(!$turma) {
            echo 'Turma não encontrada.';
            exit;
        }

        $stmt = $conn->prepare("SELECT * FROM corvo_usuarios WHERE matricula = :matricula");
        $stmt->bindParam(':matricula', $_SESSION['matricula']);
        $stmt->execute();

        $usuarios = $stmt->fetch();

        if(!$usuarios) {
            echo 'Aluno não encontrado.';
            exit;
        }

        // email do professor
        $stmt = $conn->prepare("SELECT * FROM corvo_usuarios WHERE matricula = :matricula");
        $stmt->bindParam(':matricula', $turma['professor']);
        $stmt->execute();

        $professor = $stmt->fetch();

        if(!$professor) {
            echo 'Professor não encontrado.';
            exit;
        }


        if(isset($_FILES)) {

            include '../../../vendor/autoload.php';

            // Criando um novo cliente do Google
            $client = new Google\Client();

            // Adicionando as configurações de autenticação para a Google API
            $client->setAuthConfig('../../../credenciais.json');

            // Adicionando as configurações de acesso/permissão para a Google API [Drive]
            $client->addScope("https://www.googleapis.com/auth/drive"); 

            // Adicionando a configuração de redirecionamento (para a própria host)
            $client->setRedirectUri('https://' . $_SERVER['HTTP_HOST']);

            // Adicionando o tipo de acesso
            $client->setAccessType('offline');

            // [Não sei o que é isso, mas estava na documentação]
            $client->setIncludeGrantedScopes(true); 

            // Criando um novo serviço do Google Sheets API
            $driveService = new Google_Service_Drive($client);

            // Criando um novo arquivo
            $file = new Google_Service_Drive_DriveFile();

            // Adicionando o nome do arquivo
            $file->setName($_FILES['arquivo']['name']);

            // Adicionando o tipo do arquivo
            $file->setMimeType($_FILES['arquivo']['type']);

            // Adicionando o arquivo
            $file = $driveService->files->create($file, [
                'data' => file_get_contents($_FILES['arquivo']['tmp_name']),
                'mimeType' => $_FILES['arquivo']['type'],
                'uploadType' => 'multipart'
            ]);

            $permission = new Google_Service_Drive_Permission();
            $permission->setRole('reader');
            $permission->setEmailAddress($professor['email']);
            $permission->setType('user');
            $permission->notify = false;


            // Adicionando a entrega no banco de dados 
            // id	atividade	resposta	anexo	aluno	data_entrega	
            $data = date('Y-m-d H:i:s');
            $stmt = $conn->prepare("INSERT INTO corvo_atividades_entregas (atividade, resposta, anexo, aluno, data_entrega) VALUES (:atividade, :resposta, :anexo, :aluno, :data_entrega)");
            $stmt->bindParam(':atividade', $_POST['atividade']);
            $stmt->bindParam(':resposta', $_POST['observacoes']);
            $stmt->bindParam(':anexo', $file->id);
            $stmt->bindParam(':aluno', $_SESSION['matricula']);
            $stmt->bindParam(':data_entrega', $data);

            $stmt->execute();
        }

        echo 'Entrega realizada com sucesso.';
        exit;
        
    } catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }

} else {
    echo 'erro';
    exit;
}