<?php 

namespace App\Entity;

class Name
{
    protected $task;

    public function getName(): string
    {
        return $this->task;
    }

    public function setName(string $task): void
    {
        $this->task = $task;
    }


}
