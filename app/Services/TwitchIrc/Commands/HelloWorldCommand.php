<?php

namespace App\Services\TwitchIrc\Commands;

use TwitchIrc\Bot\Command\BaseCommand;


class HelloWorldCommand extends BaseCommand{
    public function identifier(): string {
        return "hola";
    }

    public function aliases(): array {
        return [];
    }

    public function description(): string {
        return "Saluo en el chat";
    }

    public function handle(): void {
        $this->reply('Hola');
    }
}
