<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th style="width:50px;">
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center">{{ __('messages.tableWidget.widgetName') }}</th>
            <th class="text-center">{{ __('messages.tableWidget.widgetKey') }}</th>
            <th class="text-center">{{ __('messages.tableWidget.widgetModel') }}</th>
            <th class="text-center" style="width:100px;">{{ __('messages.tableStatus') }}</th>
            <th class="text-center" style="width:100px;">{{ __('messages.tableAction') }}</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($widgets) && is_object($widgets))
            @foreach ($widgets as $widget)
                <tr id="{{ $widget->id }}">
                    <td>
                        <input type="checkbox" value="{{ $widget->id }}" class="input-checkbox checkBoxItem">
                    </td>
                    <td>
                        <div class="uk-flex uk-flex-middle">
                            <div class="main-info">
                                <div class="name"><span class="maintitle">{{ $widget->name }}</span></div>
                                <div class="name"><span class="maintitle">{{ $widget->keyword }}</span></div>
                                <div class="name"><span class="maintitle">{{ $widget->name }}</span></div>

                            </div>
                        </div>
                    </td>
                    {{-- @include('backend.dashboard.component.languageTd', [
                        'model' => $widget,
                        'modeling' => 'Post',
                    ]) --}}
                    <td>
                        <input type="text" name="order" value="{{ $widget->order }}"
                            class="form-control sort-order text-right" data-id="{{ $widget->id }}"
                            data-model="{{ $config['model'] }}">
                    </td>
                    <td class="text-center js-switch-{{ $widget->id }}">
                        <input type="checkbox" value="{{ $widget->publish }}" class="js-switch status "
                            data-field="publish" data-model="{{ $config['model'] }}"
                            {{ $widget->publish == 2 ? 'checked' : '' }} data-modelId="{{ $widget->id }}" />
                    </td>
                    <td class="text-center">
                        <a href="{{ route('post.edit', $widget->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i></a>
                        <a href="{{ route('post.delete', $widget->id) }}" class="btn btn-danger"><i
                                class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
{{ $widgets->links('pagination::bootstrap-4') }}
