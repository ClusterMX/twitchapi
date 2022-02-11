<?php
namespace App\Services\TwitchIrc\Commands;

use Amp\Promise;
use TwitchIrc\Bot\Command\BaseCommand;

class MeMideCommand extends BaseCommand
{
    public function identifier(): string {
        return "memide";
    }

    public function aliases(): array {
        return [];
    }

    public function description(): string {
        return "String de memide";
    }

    public function handle(): void {
        $this->reply("Hola");
    }

}
