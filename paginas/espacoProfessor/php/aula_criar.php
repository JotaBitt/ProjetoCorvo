<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once '../../../config.php';

    
    
    try {
        
        if(!isset($_POST['aula'], $_POST['conteudo'], $_POST['data_aula'], $_POST['turma_id'])) {
            echo 'Aula, conteúdo, data da aula e/ou turma não informada.';
            exit;
        }

        $stmt = $conn->prepare("SELECT * FROM corvo_turmas WHERE id = :turma");
        $stmt->bindParam(':turma', $_POST['turma_id']);
        $stmt->execute();

        $turma = $stmt->fetch();

        if(!$turma) {
            echo 'Turma não encontrada.';
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO corvo_aulas (nomeAula, conteudo, data_aula, siglaTurma, status) VALUES (:aula, :conteudo, :data_aula, :turma_id, true)");
        $stmt->bindParam(':aula', $_POST['aula']);
        $stmt->bindParam(':conteudo', $_POST['conteudo']);
        $stmt->bindParam(':data_aula', $_POST['data_aula']);
        $stmt->bindParam(':turma_id', $turma['siglaTurma']);
        $stmt->execute();
        
        $aulaID = $conn->lastInsertId();
        

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
            foreach($_FILES as $file) {

                // Criando um novo arquivo
                $fileMetadata = new Google_Service_Drive_DriveFile();

                // Adicionando o nome do arquivo
                $fileMetadata->setName($file['name']);
                
                // Adicionando o conteúdo do arquivo
                $content = file_get_contents($file['tmp_name']);

                // Adicionando o arquivo
                $file = $driveService->files->create($fileMetadata, [
                    'data' => $content,
                    'uploadType' => 'multipart',
                    'fields' => 'id'
                ]);

                // Adicionando permissão de visualização para o arquivo
                $permission = new Google_Service_Drive_Permission();
                $permission->setRole('reader');
                $permission->setType('anyone');
                $permission->setAllowFileDiscovery(false);

                $driveService->permissions->create($file->id, $permission);


                // Adicionando o arquivo ao banco de dados
                $stmt = $conn->prepare("INSERT INTO corvo_aulas_arquivos (idAula, siglaTurma, arquivo) VALUES (:idAula, :siglaTurma, :arquivo)");
                $stmt->bindParam(':idAula', $aulaID);
                $stmt->bindParam(':siglaTurma', $turma['siglaTurma']);
                $stmt->bindParam(':arquivo', $file->id);
                $stmt->execute();
            } 
        }


        echo $aulaID;
        exit;
        
    } catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }

} else {
    echo 'erro';
    exit;
}