<x-app-layout :title="$title">
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </div>
    <footer>
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="border-t border-gray-200 dark:border-gray-700 py-4 flex justify-between items-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </p>
                <ul class="flex text-sm text-gray-600 dark:text-gray-400">
                    @foreach($footer as $route => $label)
                        <li class="mr-1 pr-1 border-r border-gray-300 dark:border-gray-700 last:border-r-0">
                            <a href="{{ route($route) }}" class="hover:text-gray-900 dark:hover:text-gray-100">{{ $label }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </footer>
</x-app-layout>
