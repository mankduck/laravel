<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th style="width:50px;">
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th>{{ __('messages.tableSlide.slideName') }}</th>
            <th>{{ __('messages.tableSlide.slideKey') }}</th>
            <th>{{ __('messages.tableSlide.slideImage') }}</th>

            <th class="text-center" style="width:200px;">{{ __('messages.tableStatus') }}</th>
            <th class="text-center" style="width:200px;">{{ __('messages.tableAction') }}</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($slides) && is_object($slides))
            @foreach ($slides as $slide)
                <tr id="{{ $slide->id }}">
                    <td>
                        <input type="checkbox" value="{{ $slide->id }}" class="input-checkbox checkBoxItem">
                    </td>
                    <td>
                        {{$slide->name}}
                    </td>
                    <td>
                        {{$slide->keyword}}
                    </td>
                    <td>
                        @foreach ($slide->item as $key => $val)
                            @foreach ($val as $item)
                                <img src="{{$item['image']}}" width="50px" height="30px" alt="">
                            @endforeach
                        @endforeach
                    </td>
                    <td class="text-center js-switch-{{ $slide->id }}">
                        <input type="checkbox" value="{{ $slide->publish }}" class="js-switch status "
                            data-field="publish" data-model="{{ $config['model'] }}"
                            {{ $slide->publish == 2 ? 'checked' : '' }} data-modelId="{{ $slide->id }}" />
                    </td>
                    <td class="text-center">
                        <a href="{{ route('slide.edit', $slide->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i></a>
                        <a href="{{ route('slide.delete', $slide->id) }}" class="btn btn-danger"><i
                                class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
{{-- {{ $slides->links('pagination::bootstrap-4') }} --}}
