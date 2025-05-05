<div>
    <flux:modal name="edit-contact" class="md:w-96" wire:model="modalOpen">
        <form wire:submit.prevent="save" class="space-y-6">
            <div>
                <flux:heading size="lg">Upraviť kontakt</flux:heading>
                <flux:text class="mt-2">Upravte údaje kontaktu.</flux:text>
            </div>

            <div>
                <flux:input label="Meno" placeholder="Meno kontaktu" wire:model="name" required />
                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <flux:input label="Email" type="email" placeholder="email@priklad.sk" wire:model="email" required />
                @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <flux:checkbox label="Používať vykanie" wire:model="use_vykanie" />
                @error('use_vykanie') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <flux:input label="Oslovenie" placeholder="Napíšte oslovenie (voliteľné)" wire:model="oslovenie" />
                @error('oslovenie') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">Uložiť zmeny</flux:button>
                <flux:button wire:click="$set('modalOpen', false)" class="ml-2">Zrušiť</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
