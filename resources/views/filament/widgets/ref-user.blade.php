<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center justify-start">
            <div class="flex items-start gap-3 flex-col justify-start">
                <div class="flex items-center gap-2 text-gray-500 justify-center">
                    <x-heroicon-o-user-group class="w-6 h-6 " />
                    <p>Всего пользователей которых пригласили</p>
                </div>
                <span class="text-2xl font-bold text-white">
                    {{ $this->getRefUsers() }}
                </span>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>