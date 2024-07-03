<header class="d-flex justify-content-between align-items-center p-1 px-3 bg-white border-bottom">
    <div class="logo">
        <a href="<?= $link ?>/instituicao">
            <img src="<?= $link ?>/assets/img/corvo-logo.png" width="70px" alt="logo Corvo" class="img-fluid" />
        </a>
    </div>
    <!-- #region Aluno | Professor | Curso | Turma | Aula -->
    
    <nav class="nav">
        <a class="nav-link mx-1" href="<?= $link ?>/crudAluno.php">Aluno</a>
        <a class="nav-link mx-1" href="<?= $link ?>/crudProfessor.php">Professor</a>
        <a class="nav-link mx-1" href="<?= $link ?>/crudCurso.php">Curso</a>
        <a class="nav-link mx-1" href="<?= $link ?>/crudTurma.php">Turma</a>
        <a class="nav-link mx-1" href="<?= $link ?>/crudAula.php">Aula</a>
    </nav>

    <!-- Dropdown do perfil -->
    <div class="dropdown">
        <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            <?= $_SESSION['nome_usuario'] ?>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <li><a class="dropdown-item" href="<?= $link ?>/sair">Sair</a></li>
        </ul>
    </div>

    <!-- Script para o dropdown do perfil usando JS padrão e Bootstrap -->
    <script>
        document.querySelector('.user-icon').addEventListener('click', function() {
            document.querySelector('.dropdown-menu').classList.toggle('show');
        });
    </script>

</header>
<?php require_once $link . "/assets/includes/scripts.php"; ?>