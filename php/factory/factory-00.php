<?php

namespace Factory00;

// SEM FACTORY
// cenário inicial, apenas upload em BD
class Fotos
{
    // ... talvez algumas propriedades

    public function upload(string $caminho)
    {
        echo "logica do cenario sem factory para salvar arquivo no BD <br>";
    }

    // ... outros metodos
}

$arq = new Fotos();
$arq->upload('caminho de uma imagem qualquer');
