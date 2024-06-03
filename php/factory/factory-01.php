<?php

namespace Factory01;

// criar classes/interfaces para implementar o design pattern factory method
// refatorar codigo anterior para usar a factory


interface IFileManager
{
    public function uploadFile(string $caminho): void;
}
abstract class FileUploadFactory
{
    abstract public function factoryMethod(): IFileManager;

    public function upload($caminho): void
    {
        // Chama factory method para criar o objeto (produto)...
        $product = $this->factoryMethod();
        // ...e usa o(s) metodo(s) deste objeto.
        $product->uploadFile($caminho);
    }
}

class dbFileManager implements IFileManager
{
    public function uploadFile(string $caminho): void
    {
        echo "salva arquivo no BD <br>";
    }
}
class dbUploadFactory extends FileUploadFactory
{
    public function factoryMethod(): IFileManager
    {
        // implementa aqui a lógica do cenário inicial
        return new dbFileManager();
    }
}

// método que faz o upload do arquivo seja onde for
// o parâmetro FileUploadFactory é que sabe dos detalhes
function uploadFile(FileUploadFactory $creator, string $caminho)
{
    $creator->upload($caminho);
}

class Fotos
{
    public function upload(string $caminho)
    {
        // echo "logica do cenario sem factory para salvar arquivo no BD <br>";
        echo "refatorado para usar factory...<br>";
        uploadFile(new dbUploadFactory(), 'caminho de um arquivo');
    }
}

$arq = new Fotos();
$arq->upload('caminho de uma imagem qualquer');
