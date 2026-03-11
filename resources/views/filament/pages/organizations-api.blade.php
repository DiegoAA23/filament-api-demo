<x-filament-panels::page>
    <script>
        window.PHP_SESSION = @json(session('api_token'));
    </script>
    <div id="app">
        <table-component></table-component>
    </div>
</x-filament-panels::page>

@vite('resources/js/app.js')