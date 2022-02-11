<?php
namespace App\Services\TwitchIrc\Commands;

use TwitchIrc\Bot\Command\BaseCommand;

class MeMideCommand extends BaseCommand
{
    public function identifier(): string {
        return "medir";
    }

    public function aliases(): array {
        return [];
    }

    public function description(): string {
        return "String de memide";
    }

    public function handle(): void {
        $this->chatUser()->getUsername();
    }

}
