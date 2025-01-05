<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th style="width:50px;">
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center">{{ __('messages.tableSource.sourceName') }}</th>
            <th class="text-center">{{ __('messages.tableSource.sourceKey') }}</th>
            <th class="text-center">{{ __('messages.tableSource.sourceDescription') }}</th>
            <th class="text-center">{{ __('messages.tableStatus') }}</th>
            <th class="text-center">{{ __('messages.tableAction') }}</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($sources) && is_object($sources))
            @foreach ($sources as $source)
                <tr id="{{ $source->id }}">
                    <td>
                        <input type="checkbox" value="{{ $source->id }}" class="input-checkbox checkBoxItem">
                    </td>
                    <td>
                        {{ $source->name }}
                    </td>
                    <td>
                        {{ $source->keyword }}
                    </td>

                    <td>
                        {!! $source->description !!}
                    </td>
                    <td class="text-center js-switch-{{ $source->id }}">
                        <input type="checkbox" value="{{ $source->publish }}" class="js-switch status "
                            data-field="publish" data-model="{{ $config['model'] }}"
                            {{ $source->publish == 2 ? 'checked' : '' }} data-modelId="{{ $source->id }}" />
                    </td>
                    <td class="text-center">
                        <a href="{{ route('source.edit', $source->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i></a>
                        <a href="{{ route('source.delete', $source->id) }}" class="btn btn-danger"><i
                                class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
{{ $sources->links('pagination::bootstrap-4') }}
