<header class="d-flex justify-content-between align-items-center p-1 px-3 bg-white border-bottom">
    <div class="logo">
        <a href="<?= $link ?>/">
            <img src="<?= $link ?>/assets/img/corvo-logo.png" width="70px" alt="logo Corvo" class="img-fluid" />
        </a>
    </div>
    <?php if(!str_contains($_SERVER["SCRIPT_NAME"], "index.php")) { ?>
    <nav class="nav">
        <a class="nav-link mx-1" href="<?= $link ?>/turmas/<?= $turma['idTurma'] ?>">Turma</a>
        <a class="nav-link mx-1" href="<?= $link ?>/turmas/<?= $turma['idTurma'] ?>/aulas">Aulas</a>
        <a class="nav-link mx-1" href="<?= $link ?>/turmas/<?= $turma['idTurma'] ?>/atividades">Atividades</a>
        <a class="nav-link mx-1" href="<?= $link ?>/turmas/<?= $turma['idTurma'] ?>/notas">Notas</a>
        <a class="nav-link mx-1" href="<?= $link ?>/turmas/<?= $turma['idTurma'] ?>/frequencia">Presença</a>
        <a class="nav-link mx-1" href="<?= $link ?>/turmas/<?= $turma['idTurma'] ?>/membros">Membros</a>
    </nav>
    <?php } ?>
    <!-- <div class="user-icon">
        <i class="fas fa-user-circle" style="font-size: 40px"></i>
    </div> -->
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
        document.addEventListener('DOMContentLoaded', function() {
            var dropdownMenuButton = document.getElementById('dropdownMenuButton');
            dropdownMenuButton.addEventListener('click', function() {
                var dropdownMenu = dropdownMenuButton.nextElementSibling;
                if (dropdownMenu.style.display === 'block') {
                    dropdownMenu.style.display = 'none';
                } else {
                    dropdownMenu.style.display = 'block';
                }
            });
        });
    </script>



</header>
<?php require_once $link . "/assets/includes/scripts.php"; ?>