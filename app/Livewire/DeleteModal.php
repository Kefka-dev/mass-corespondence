<?php

namespace App\Livewire;

use Livewire\Component;

class DeleteModal extends Component
{
    public $recordId = null;
    public $model = null;
    public $eventName = null;
    public bool $modalOpen = false;

    #[\Livewire\Attributes\On('open-delete-modal')]
    public function openModal($recordId, $model, $eventName): void
    {
        $this->recordId = $recordId;
        $this->model = $model;
        $this->eventName = $eventName;
        $this->modalOpen = true;
    }

    public function delete(): void
    {
        if ($this->recordId && $this->model) {
            $modelClass = "App\\Models\\" . $this->model;
            $record = $modelClass::findOrFail($this->recordId);
            $record->delete();
            $this->modalOpen = false;
            $this->dispatch($this->eventName);
            session()->flash('message', 'Záznam bol úspešne odstránený.');
        }
    }

    public function render()
    {
        return view('livewire.delete-modal');
    }
}
