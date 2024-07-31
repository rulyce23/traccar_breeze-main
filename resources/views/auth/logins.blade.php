<form method="POST" action="{{ route('logout') }}">
    @csrf
    @method('DELETE')
    <button type="submit">Logout</button>
</form>
