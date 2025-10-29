<footer class="fi-footer border-t border-gray-200 dark:border-gray-700 py-6 mt-8">
    <div class="fi-container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Інформація про систему --}}
            <div class="space-y-3">
                <div class="flex items-center gap-2">
                    <x-filament::icon 
                        icon="heroicon-o-book-open" 
                        class="h-6 w-6 text-primary-600 dark:text-primary-400"
                    />
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        readloop Admin
                    </h3>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Панель адміністрування соціальної мережі книголюбів
                </p>
                <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-500">
                    <x-filament::icon icon="heroicon-m-code-bracket" class="h-4 w-4" />
                    <span>Version 1.0.0</span>
                </div>
            </div>

            {{-- Швидкі посилання --}}
            <div class="space-y-3">
                <h4 class="text-sm font-semibold text-gray-900 dark:text-white">
                    Швидкі посилання
                </h4>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('filament.admin.pages.dashboard') }}" 
                           class="text-sm text-gray-600 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400 flex items-center gap-2 transition">
                            <x-filament::icon icon="heroicon-m-chart-bar" class="h-4 w-4" />
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('filament.admin.resources.books.index') }}" 
                           class="text-sm text-gray-600 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400 flex items-center gap-2 transition">
                            <x-filament::icon icon="heroicon-m-book-open" class="h-4 w-4" />
                            Книги
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('filament.admin.resources.users.index') }}" 
                           class="text-sm text-gray-600 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400 flex items-center gap-2 transition">
                            <x-filament::icon icon="heroicon-m-users" class="h-4 w-4" />
                            Користувачі
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Статистика --}}
            <div class="space-y-3">
                <h4 class="text-sm font-semibold text-gray-900 dark:text-white">
                    Статистика системи
                </h4>
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-3">
                        <div class="text-2xl font-bold text-primary-600 dark:text-primary-400">
                            {{ number_format(\App\Models\Book::count(), 0, ',', ' ') }}
                        </div>
                        <div class="text-xs text-gray-600 dark:text-gray-400">Книг</div>
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-3">
                        <div class="text-2xl font-bold text-success-600 dark:text-success-400">
                            {{ number_format(\App\Models\User::count(), 0, ',', ' ') }}
                        </div>
                        <div class="text-xs text-gray-600 dark:text-gray-400">Користувачів</div>
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-3">
                        <div class="text-2xl font-bold text-warning-600 dark:text-warning-400">
                            {{ number_format(\App\Models\Author::count(), 0, ',', ' ') }}
                        </div>
                        <div class="text-xs text-gray-600 dark:text-gray-400">Авторів</div>
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-3">
                        <div class="text-2xl font-bold text-info-600 dark:text-info-400">
                            {{ number_format(\App\Models\Rating::count(), 0, ',', ' ') }}
                        </div>
                        <div class="text-xs text-gray-600 dark:text-gray-400">Відгуків</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Copyright --}}
        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    © {{ date('Y') }} readloop. Всі права захищені.
                </p>
                <div class="flex items-center gap-4">
                    <span class="text-xs text-gray-500 dark:text-gray-500 flex items-center gap-1">
                        <x-filament::icon icon="heroicon-m-clock" class="h-4 w-4" />
                        Останнє оновлення: {{ now()->format('d.m.Y H:i') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</footer>
