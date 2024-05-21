<?php

namespace Observer\App01;

/**
 * The Subject owns some important state and notifies observers when the state
 * changes.
 */
class ChatServer implements \SplSubject, \SplObserver
{
    /**
     * @var int For the sake of simplicity, the Subject's state, essential to
     * all subscribers, is stored in this variable.
     */
    public $state;

    /**
     * @var \SplObjectStorage List of subscribers. In real life, the list of
     * subscribers can be stored more comprehensively (categorized by event
     * type, etc.).
     */
    private $observers;

    public function __construct()
    {
        $this->observers = new \SplObjectStorage();
    }

    /**
     * The subscription management methods.
     */
    public function attach(\SplObserver $observer): void
    {
        echo "Subject: Attached an observer.\n";
        echo "<br>";
        $this->observers->attach($observer);
    }

    public function detach(\SplObserver $observer): void
    {
        $this->observers->detach($observer);
        echo "Subject: Detached an observer.\n";
        echo "<br>";
    }

    /**
     * Trigger an update in each subscriber.
     */
    public function notify(): void
    {
        echo "Subject: Notifying observers...\n";
        // var_dump($this->observers);
        echo "<br>";
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function broadcastMessage(string $message): void
    {
        echo "Remetente diz: " . $message;
        foreach ($this->observers as $observer) {
            $observer->receiveMessages($message);
        }
    }

    public function receiveMessages(string $message): void {
        echo "UserA recebeu msg: " . $message;
    }     

  

    public function update(\SplSubject $subject): void
    {
        echo "ConcreteObserverA: Reacted to the event.\n";
        echo "<br>";
        if ($subject->state < 3) {
        }
    }    



    /**
     * Usually, the subscription logic is only a fraction of what a Subject can
     * really do. Subjects commonly hold some important business logic, that
     * triggers a notification method whenever something important is about to
     * happen (or after it).
     */
    public function someBusinessLogic(string $action): void
    {
        echo "<br>";
        echo "Subject: " . $action;
        echo "<br>";
        $this->state = rand(0, 10);

        // echo "Subject: My state has just changed to: {$this->state}\n";
        // echo "<br>";
        $this->notify();
    }
}

/**
 * Concrete Observers react to the updates issued by the Subject they had been
 * attached to.
 */
class UserA implements \SplObserver
{
    public function update(\SplSubject $subject): void
    {
        echo "ConcreteObserverA: Reacted to the event.\n";
        echo "<br>";
        if ($subject->state < 3) {
        }
    }

    public function receiveMessages(string $message): void {
        echo "UserA recebeu msg: " . $message;
    }    
}

class UserB implements \SplObserver
{
    public function update(\SplSubject $subject): void
    {
        echo "ConcreteObserverB:     Reacted to the event.\n";
        var_dump($subject->state);
        echo "<br>";
        if ($subject->state == 0 || $subject->state >= 2) {
        }
    }

    public function receiveMessages(string $message): void {
        echo "UserB recebeu msg: " . $message;
    }    
}

/**
 * The client code.
 */

$chatServer = new ChatServer();

$userA = new UserA();
$chatServer->attach($userA);

$userB = new UserB();
$chatServer->attach($userB);

$chatServer->broadcastMessage('Hello from the server!!!');

// $subject->someBusinessLogic('fazer alongamento');
// $subject->someBusinessLogic('treinar golpes');

// $subject->detach($o2);

// $subject->someBusinessLogic('limpar equipamentos');