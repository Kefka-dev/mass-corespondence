<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Contact;

class DeleteContactModal extends Component
{
    public $contactId = null;
    public bool $modalOpen = false;

    #[\Livewire\Attributes\On('open-delete-modal')]
    public function openModal($contactId): void
    {
        $this->contactId = $contactId;
        $this->modalOpen = true;
    }

    public function delete(): void
    {
        if ($this->contactId) {
            Contact::findOrFail($this->contactId)->delete();
            $this->modalOpen = false;
            $this->dispatch('contact-deleted'); // Udalosť pre refresh tabuľky
            session()->flash('message', 'Kontakt bol úspešne odstránený.');
        }
    }

    public function render()
    {
        return view('livewire.delete-contact-modal');
    }
}
