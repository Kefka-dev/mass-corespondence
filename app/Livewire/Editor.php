<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Template;
use Illuminate\Support\Facades\Auth;

class Editor extends Component
{
    public $content = '';
    public $showNameModal = false;
    public $showLoadModal = false;
    public $showConfirmModal = false;
    public $templateName = '';
    public $existingTemplateId = null;
    public $templates= [];
    public function openNameModal()
    {
        $this->showNameModal = true;
    }
    public function openLoadModal()
    {
        $user = Auth::user();
        $this->templates = Template::where('user_id', $user->id)->get();
        $this->showLoadModal = true;
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

        $this->showConfirmModal = false;
        $this->showNameModal = false;
        session()->flash('message', 'Template overwritten successfully!');
    }

    public function createTemplate()
    {
        $user = Auth::user();
        Template::create([
            'user_id' => $user->id,
            'name' => $this->templateName,
            'template' => $this->content,
        ]);

        $this->showNameModal = false;
        session()->flash('message', 'Template saved successfully!');
    }

    public function render()
    {
        return view('livewire.editor');
    }
}
