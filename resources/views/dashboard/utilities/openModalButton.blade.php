<{{ $isBtn ?? false ? 'button' : 'a href="#"' }} class="btn {{ $btnClass ?? 'btn-primary' }}" data-bs-toggle="modal" data-bs-target="#{{ $modalId ?? 'genericModal' }}">
    {{ $btnText }}
</{{ $isBtn ?? false ? 'button' : 'a' }}>