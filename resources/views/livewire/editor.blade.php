<div>
    <livewire:quill-text-editor wire:model.live="content" theme="snow" />
    <flux:button.group>
        <flux:button wire:click="openLoadModal">Load Template</flux:button>
        <flux:button wire:click="openNameModal">Save Template</flux:button>
    </flux:button.group>

    <!-- Modal for entering template name -->
    <flux:modal name="name-modal" wire:model="showNameModal">
        <div class="px-8">
            <flux:heading class="my-5">Save Template</flux:heading>
            <flux:input class="my-5" wire:model="templateName" placeholder="Template Name" />
            <flux:button class="my-5" wire:click="checkTemplate">Save</flux:button>
            <flux:button class="my-5" wire:click="$set('showNameModal', false)">Cancel</flux:button>
        </div>
    </flux:modal>

    <!-- Modal for confirming overwrite -->
    <flux:modal name="confirm-modal" wire:model="showConfirmModal">
        <div>
            <flux:heading>Confirm Overwrite</flux:heading>
            <flux:text>A template with this name already exists. Do you want to overwrite it?</flux:text>
            <flux:button wire:click="overwriteTemplate">Yes</flux:button>
            <flux:button wire:click="$set('showConfirmModal', false)">No</flux:button>
        </div>
    </flux:modal>

    <!-- Modal for loading template -->
    <flux:modal name="load-modal" wire:model="showLoadModal">
        <div>
            <flux:heading>Load Template</flux:heading>
            @if(empty($templates))
                <flux:text>No templates found.</flux:text>
            @else
                @foreach($templates as $template)
                    <flux:button wire:click="">{{ $template->name }}</flux:button>
                @endforeach
            @endif
            <flux:button wire:click="$set('showLoadModal', false)">Cancel</flux:button>
        </div>
    </flux:modal>
</div>
