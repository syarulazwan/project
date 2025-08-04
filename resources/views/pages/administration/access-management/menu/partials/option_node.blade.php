<option value="{{ $node['menu']->id }}">{{ $prefix }}{{ $node['menu']->name }}</option>

@if (!empty($node['children']))
    @foreach ($node['children'] as $child)
        @include('pages.administration.access-management.menu.partials.option_node', [
            'node' => $child,
            'prefix' => $prefix . '— '
        ])
    @endforeach
@endif