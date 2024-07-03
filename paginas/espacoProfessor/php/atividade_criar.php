<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once '../../../config.php';


    try {
        
        if(!isset($_POST['turma_id'], $_POST['atividade'], $_POST['descricao'], $_POST['nota_maxima'])) {
            echo 'Turma, atividade, descrição e/ou atividade não informada.';
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO corvo_atividades (descricao, atividade, nota_maxima, turma) VALUES (:descricao, :atividade, :nota_maxima, :turma_id)");
        $stmt->bindParam(':descricao', $_POST['descricao']);
        $stmt->bindParam(':atividade', $_POST['atividade']);
        $stmt->bindParam(':nota_maxima', $_POST['nota_maxima']);
        $stmt->bindParam(':turma_id', $_POST['turma_id']);
        $stmt->execute();

        $atividadeID = $conn->lastInsertId();

        $stmt = $conn->prepare("SELECT * FROM corvo_turmas INNER JOIN corvo_usuarios ON corvo_turmas.professor = corvo_usuarios.matricula WHERE corvo_turmas.id = :turma");
        $stmt->bindParam(':turma', $_POST['turma_id']);
        $stmt->execute();

        $turma = $stmt->fetch();

        if(!$turma) {
            echo 'Turma não encontrada.';
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

            // Para cada arquivo enviado...
            for($i = 0; $i < count($_FILES['arquivos']['name']); $i++) {

                // Criando um novo arquivo
                $fileMetadata = new Google_Service_Drive_DriveFile();

                // Adicionando o nome do arquivo
                $fileMetadata->setName($_FILES['arquivos']['name'][$i]);
                
                // Adicionando o conteúdo do arquivo
                $content = file_get_contents($_FILES['arquivos']['tmp_name'][$i]);

                // Adicionando o arquivo
                $file = $driveService->files->create($fileMetadata, [
                    'data' => $content,
                    'uploadType' => 'multipart',
                    'fields' => 'id'
                ]);

                // // Compartilhando o arquivo com o professor
                // $driveService->permissions->create($file->id, new Google_Service_Drive_Permission([
                //     'type' => 'user',
                //     'role' => 'writer',
                //     'emailAddress' => $turma['email'],
                //     'sendNotificationEmail' => false
                // ]));

                // Compartilhando o arquivo com a turma
                $permission = new Google_Service_Drive_Permission();
                $permission->setRole('reader');
                $permission->setType('anyone');
                $permission->setAllowFileDiscovery(false);

                $driveService->permissions->create($file->id, $permission);


                // Adicionando o arquivo ao banco de dados
                $stmt = $conn->prepare("INSERT INTO corvo_atividades_arquivos (atividade, siglaTurma, arquivo) VALUES (:atividade, :siglaTurma, :arquivo)");
                $stmt->bindParam(':atividade', $atividadeID);
                $stmt->bindParam(':siglaTurma', $turma['siglaTurma']);
                $stmt->bindParam(':arquivo', $file->id);
                $stmt->execute();
            } 
        }


        // Verificar se foi enviado data de entrega
        if($_POST['data_entrega']) {

            $dataEntrega = DateTime::createFromFormat('Y-m-d', $_POST['data_entrega']);

            // converter pra string
            $dataEntrega = $dataEntrega->format('Y-m-d');

            $stmt = $conn->prepare("UPDATE corvo_atividades SET data_entrega = :data_entrega WHERE id = :atividade_id");
            $stmt->bindParam(':data_entrega', $dataEntrega);
            $stmt->bindParam(':atividade_id', $atividadeID);
            $stmt->execute();
        }


        echo $atividadeID;
        exit;
        
    } catch (Exception $e) {
        echo 'erro';
        exit;
    }

} else {
    echo 'erro';
    exit;
}