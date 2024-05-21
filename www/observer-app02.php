<?php

namespace Observer\App02;

interface IPublisher
{
    // Attach an observer to the publisher.
    public function Attach(IObserver $observer);

    // Detach an observer from the publisher.
    public function Detach(IObserver $observer);

    // Notify all observers about an event.
    public function Notify();    
}

interface IObserver
{
    // Receive update from publisher
    public function Update(IPublisher $publisher);
}

/**
 * The Aluno class has some states (email, celular)
 * and notifies observers when the state changes.
 */
class Aluno implements IPublisher
{
    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $celular;

    /**
     * @var IObserver[] 
     */
    private $observers;

    public function __construct()
    {
        $this->observers = array();
    }

    /**
     * The subscription management methods.
     */
    public function attach(IObserver $observer): void
    {
        // array_push($this->observers, $observer);
        $this->observers[] = $observer;
    }

    public function detach(IObserver $observer): void
    {
        foreach($this->observers as $key => $val) {
            if ($val == $observer) { 
                unset($this->observers[$key]);
            }
        }
    }

    /**
     * Trigger an update in each subscriber.
     */
    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    /**
     * Usually, the subscription logic is only a fraction of what a Publisher can
     * really do. Publishers commonly hold some important business logic, that
     * triggers a notification method whenever something important is about to
     * happen (or after it).
     */
    public function alterarDados(string $email, string $celular): void
    {
        $this->email = $email;
        $this->celular = $celular;
        $this->notify();
    }

}

/**
 * Concrete Observers react to the updates issued by the Publisher they had been
 * attached to.
 */
class notificadorPorEmail implements IObserver
{
    public function update(IPublisher $publisher): void
    {
        if (empty($publisher->email)) {
            echo "Não há email para notificar";
            echo "<br>";
            return;
        }
        echo "Enviar notificação para " . $publisher->email;
        echo "<br>";
    }
}

class notificadorPorCelular implements IObserver
{
    public function update(IPublisher $publisher): void
    {
        if (empty($publisher->celular)) {
            echo "Não há celular para notificar";
            echo "<br>";
            return;
        }
        echo "Enviar notificação para " . $publisher->celular;
        echo "<br>";
}
}

/**
 * The client code.
 */
$aluno = new Aluno();
$notificadorEmail = new notificadorPorEmail();
$notificadorCelular = new notificadorPorCelular();

echo "Ligar apenas notificador por Email";
echo "<br>";
echo "==================================";
$aluno->attach($notificadorEmail);

echo "<br>";
echo "Alterar email e celular";
echo "<br>";
$aluno->alterarDados('edson@koguishi.com', '43-9-9960');

echo "<br>";
echo "Alterar apenas o email";
echo "<br>";
$aluno->alterarDados('edson@koguishi.com', '');

echo "<br>";
echo "Alterar apenas o celular";
echo "<br>";
$aluno->alterarDados('', '43-9-9960');

$aluno->detach($notificadorEmail);

echo "<br>";
echo "Ligar apenas notificador por Celular";
echo "<br>";
echo "====================================";
$aluno->attach($notificadorCelular);

echo "<br>";
echo "Alterar email e celular";
echo "<br>";
$aluno->alterarDados('edson@koguishi.com', '43-9-9960');

echo "<br>";
echo "Alterar apenas o email";
echo "<br>";
$aluno->alterarDados('edson@koguishi.com', '');

echo "<br>";
echo "Alterar apenas o celular";
echo "<br>";
$aluno->alterarDados('', '43-9-9960');


echo "<br>";
echo "Ligar notificador por Email e por Celular";
echo "<br>";
echo "=========================================";
$aluno->attach($notificadorEmail);

echo "<br>";
echo "Alterar email e celular";
echo "<br>";
$aluno->alterarDados('edson@koguishi.com', '43-9-9960');

echo "<br>";
echo "Alterar apenas o email";
echo "<br>";
$aluno->alterarDados('edson@koguishi.com', '');

echo "<br>";
echo "Alterar apenas o celular";
echo "<br>";
$aluno->alterarDados('', '43-9-9960');
