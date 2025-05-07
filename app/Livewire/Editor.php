<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Template;
use Illuminate\Support\Facades\Auth;

class Editor extends Component
{
    public $content = '';
    public $showNameModal = false;
    public $showConfirmModal = false;
    public $templateName = '';
    public $existingTemplateId = null;

    protected $listeners = [
        'load-template' => 'loadTemplate',
    ];

    public function openNameModal()
    {
        $this->showNameModal = true;
    }

    public function checkTemplate()
    {
        $this->validate([
            'templateName' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $existingTemplate = Template::where('user_id', $user->id)
            ->where('name', $this->templateName)
            ->first();

        if ($existingTemplate) {
            $this->existingTemplateId = $existingTemplate->id;
            $this->showConfirmModal = true;
        } else {
            $this->createTemplate();
        }
    }

    public function overwriteTemplate()
    {
        $template = Template::find($this->existingTemplateId);
        $template->template = $this->content;
        $template->save();

        $this->content = $template->template ?? '';
        $this->showConfirmModal = false;
        $this->showNameModal = false;
        session()->flash('message', 'Template overwritten successfully!');
    }

    public function createTemplate()
    {
        $user = Auth::user();
        $template = Template::create([
            'user_id' => $user->id,
            'name' => $this->templateName,
            'template' => $this->content,
        ]);

        $this->content = $template->template ?? '';
        $this->showNameModal = false;
        $this->dispatch('template-saved');
        session()->flash('message', 'Template saved successfully!');
    }

    public function loadTemplate($templateId)
    {
        $template = Template::find($templateId);
        if ($template && $template->user_id === auth()->id()) {
            $this->content = $template->template ?? '';
            session()->flash('message', 'Template loaded successfully!');
        }
    }

    public function render()
    {
        return view('livewire.editor');
    }
}
