<?php

namespace Factory02;

// implementado classes para upload no S3
// e pronto para qualquer nova implementação de upload:
//   1-criar uma classe XYZ que implemente IFileManager
//     implementando o metodo uploadFile() conforme o local onde o arquivo será armazenado
//   2-criar uma classe que extenda FileUploadFactory
//     retornando no metodo factoryMethod() a instancia da classe XYZ

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
        return new dbFileManager();
    }
}

class s3FileManager implements IFileManager
{
    public function uploadFile(string $caminho): void
    {
        echo "salva arquivo no S3 <br>";
    }
}
class s3UploadFactory extends FileUploadFactory
{
    public function factoryMethod(): IFileManager
    {
        return new s3FileManager();
    }
}

function uploadFile(FileUploadFactory $creator, string $caminho)
{
    $creator->upload($caminho);
}

echo "Upload no BD usando factory...<br>";
uploadFile(new dbUploadFactory(), 'caminho de um arquivo');
echo '<br>';
echo "Upload no S3 usando factory...<br>";
uploadFile(new s3UploadFactory(), 'caminho de um arquivo');
