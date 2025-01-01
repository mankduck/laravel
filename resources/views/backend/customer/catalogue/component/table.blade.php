<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th>{{ __('messages.tableGrUserName') }}</th>
            <th class="text-center">{{ __('messages.tableGrUserNumber') }}</th>
            <th>{{ __('messages.tableGrUserDes') }}</th>
            <th class="text-center">{{ __('messages.tableStatus') }}</th>
            <th class="text-center">{{ __('messages.tableAction') }}</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($customerCatalogues) && is_object($customerCatalogues))
            @foreach ($customerCatalogues as $customerCatalogue)
                <tr>
                    <td>
                        <input type="checkbox" value="{{ $customerCatalogue->id }}" class="input-checkbox checkBoxItem">
                    </td>
                    <td>
                        {{ $customerCatalogue->name }}
                    </td>
                    <td class="text-center">
                        {{ $customerCatalogue->users_count }} người
                    </td>
                    <td>
                        {{ $customerCatalogue->description }}
                    </td>
                    <td class="text-center js-switch-{{ $customerCatalogue->id }}">
                        <input type="checkbox" value="{{ $customerCatalogue->publish }}" class="js-switch status"
                            data-field="publish" data-model="{{ $config['model'] }}"
                            {{ $customerCatalogue->publish == 2 ? 'checked' : '' }}
                            data-modelId="{{ $customerCatalogue->id }}" />
                    </td>
                    <td class="text-center">
                        <a href="{{ route('customer.catalogue.edit', $customerCatalogue->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i></a>
                        <a href="{{ route('customer.catalogue.delete', $customerCatalogue->id) }}" class="btn btn-danger"><i
                                class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
{{ $customerCatalogues->links('pagination::bootstrap-4') }}
