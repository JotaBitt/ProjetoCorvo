<?php 

if(!isset($turma['background']) || $turma['background'] == NULL) {
    $turma['background'] = "https://i.imgur.com/CHA78sr.png";
}

?>


<div class="card mb-4 p-5 d-flex justify-content-start align-items-start" style="
        background-image: url( <?= $turma['background'] ?> );
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        border-radius: 1rem;
    ">
    <div class="text-white">
        <h2 class="card-title"><?= $turma['nome'] ?></h2>

        <span><?= $professor['nome'] ?></span>
    </div>
</div>