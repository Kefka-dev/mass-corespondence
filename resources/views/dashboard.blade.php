<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-2">
            <div class="relative aspect-video overflow-hidden rounded-xl ">
                <livewire:template-table/>
            </div>
            <div class="relative aspect-video overflow-auto rounded-xl border border-neutral-200 dark:border-neutral-700">
                <div class="grid auto-rows-min gap-4 md:grid-cols-2">
                    <div>
                        <flux:heading>Parametrizovane frázy</flux:heading>
                        <flux:text class="mt-4">{pozdrav_zaciatok}</flux:text>
                        <flux:text class="ml-8">tykanie = Ahoj</flux:text>
                        <flux:text class="ml-8">vykanie = Dobrý deň</flux:text>
                        <flux:text class="">{dakujem}</flux:text>
                        <flux:text class="ml-8">tykanie = Ďakujem ti</flux:text>
                        <flux:text class="ml-8">vykanie = Ďakujem Vám</flux:text>
                        <flux:text class="">{pozdrav_zaver}</flux:text>
                        <flux:text class="ml-8">tykanie = Pozdravujem</flux:text>
                        <flux:text class="ml-8">vykanie = S pozdravom</flux:text>
                        <flux:text class="">{Vás/teba}</flux:text>
                        <flux:text class="ml-8">tykanie = teba</flux:text>
                        <flux:text class="ml-8">vykanie = Vás</flux:text>
                        <flux:text class="">{Vám/ti}</flux:text>
                        <flux:text class="ml-8">tykanie = ti</flux:text>
                        <flux:text class="ml-8">vykanie = Vám</flux:text>
                        <flux:text class="">{Vami/tebou}</flux:text>
                        <flux:text class="ml-8">tykanie = tebou</flux:text>
                        <flux:text class="ml-8">vykanie = Vami</flux:text>

                    </div>
                    <div>
                        <flux:heading>Parametrizované správy</flux:heading>
                        <flux:text class="mt-4">{Vy/ty}</flux:text>
                        <flux:text class="ml-8">tykanie = ty</flux:text>
                        <flux:text class="ml-8">vykanie = Vy</flux:text>
                        <flux:text class="">{oslovenie}</flux:text>
                        <flux:text class="ml-8">tykanie = (bez oslovenia)</flux:text>
                        <flux:text class="ml-8">vykanie = {dané_oslovenie}</flux:text>
                        <flux:text class="">{meno} = {meno adresáta}</flux:text>

                    </div>
                </div>
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl  ">
            <livewire:editor />
        </div>
        <livewire:delete-modal />
    </div>
</x-layouts.app>
