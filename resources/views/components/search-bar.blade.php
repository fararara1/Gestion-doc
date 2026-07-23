<form id="{{ $formId ?? 'searchForm' }}" method="GET" action="{{ $action ?? request()->url() }}" class="mb-0">
    <div class="input-group" style="max-width: 400px;">
        <span class="input-group-text">
            <i class="bi bi-search"></i>
        </span>
        <input
            type="text"
            name="{{ $inputName ?? 'search' }}"
            id="{{ $inputId ?? 'search' }}"
            class="form-control"
            placeholder="{{ $placeholder ?? 'Rechercher...' }}"
            value="{{ request($inputName ?? 'search') }}"
            autocomplete="off"
            onkeyup="liveSearch()">
    </div>
</form>

<script>
let timer;
function liveSearch() {
    clearTimeout(timer);
    timer = setTimeout(function () {
        document.getElementById('{{ $formId ?? 'searchForm' }}').submit();
    }, 300);
}
</script>
