<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <x-slot name="nav">
        <div class="space-x-4">
            <x-jet-nav-link href="{{ route('categories.index') }}" :active="request()->routeIs('categories.index')">
                {{ __('Index') }}
            </x-jet-nav-link>
            <x-jet-nav-link href="{{ route('categories.create') }}" :active="request()->routeIs('categories.create')">
                {{ __('Create') }}
            </x-jet-nav-link>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-7">
                    <form action="{{route('categories.store')}}" method="post">
                        @csrf

                        <div>
                            <small class="mb-4 text-gray-500">Note: Select Parent only for subcategory.</small>
                            <select name="parent_id" id="" class="w-full mb-6 border-none bg-indigo-200 rounded">
                                <option value="">Select Parent Category</option>

                                @foreach ($categories as $cateory)
                                <option value="{{$cateory->id}}">{{$cateory->name}}</option>

                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-jet-label for="name" value="{{ __('Name') }}" />
                            <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            <span class="text-xs text-gray-500 mt-2">Maximum 80 characers</span>
                            <x-jet-input-error for="name" class="mt-2" />
                        </div>

                        <x-jet-button class="mt-12">
                            {{ __('Create') }}
                        </x-jet-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>