<x-filament-panels::page>
    <div id="app" data-api-token="{{ session('api_token') }}">
        <table-component></table-component>
    </div>
</x-filament-panels::page>

@vite('resources/js/app.js')
