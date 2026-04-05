<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            @can('exportPdf', $user)
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg flex justify-between items-center">
                    <h2 class="text-lg font-medium text-gray-900">Выписка профиля</h2>
                    <a href="{{ route('users.export_pdf', $user) }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500">
                        Скачать PDF
                    </a>
                </div>
            @endcan

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">Аватар профиля</h2>
                    </header>

                    {{-- Отображение текущего аватара через FileService --}}
                    <div class="mt-4">
                        <img src="{{ app(\App\Services\FileService::class)->getAvatarUrl($user->avatar) }}" 
                            alt="Avatar" class="w-20 h-20 rounded-full object-cover">
                    </div>

                    <form method="post" action="{{ route('users.update_avatar', $user) }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="avatar" value="Выберите файл" />
                            <input id="avatar" name="avatar" type="file" class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>Сохранить аватар</x-primary-button>
                        </div>
                    </form>
                </section>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
