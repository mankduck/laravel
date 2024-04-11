<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th>Tên Menu</th>
            <th>Từ Khóa</th>
            <th>Ngày Tạo</th>
            <th>Người tạo</th>
            <th class="text-center">{{ __('messages.tableStatus') }}</th>
            <th class="text-center">{{ __('messages.tableAction') }}</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($menus) && is_object($menus))
            @foreach ($menus as $menu)
                <tr>
                    <td>
                        <input type="checkbox" value="{{ $menu->id }}" class="input-checkbox checkBoxItem">
                    </td>
                    <td>
                        {{-- {{ $menu->name }} --}}
                    </td>
                    <td>
                        {{-- {{ $menu->email }} --}}
                    </td>
                    <td>
                        {{-- {{ $menu->phone }} --}}
                    </td>
                    <td>
                        {{-- {{ $menu->address }} --}}
                    </td>
                    <td class="text-center">
                        {{-- {{ $menu->user_catalogues->name }} --}}
                    </td>
                    <td class="text-center js-switch-{{ $menu->id }}">
                        <input type="checkbox" value="{{ $menu->publish }}" class="js-switch status"
                            data-field="publish" data-model="{{ $config['model'] }}"
                            {{ $menu->publish == 2 ? 'checked' : '' }} data-modelId="{{ $menu->id }}" />
                    </td>

                    <td class="text-center">
                        <a href="{{ route('user.edit', $menu->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i></a>
                        <a href="{{ route('user.delete', $menu->id) }}" class="btn btn-danger"><i
                                class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
