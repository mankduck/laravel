<form action="{{ route('customer.index') }}">
    <div class="filter-wrapper">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            @include('backend.dashboard.component.perpage')
            <div class="action">
                <div class="uk-flex uk-flex-middle">
                    @include('backend.dashboard.component.filterPublish')
                    <select name="customer_catalogue_id" class="form-control mr10 setupSelect2">
                        <option value="0" selected="selected">Chọn Nhóm Khách Hàng</option>
                        @foreach ($customerCatalogues as $key => $val)
                            <option value="{{ $val->id }}">{{ $val->name }}</option>
                        @endforeach
                    </select>
                    {{-- @php
                        $postCatalogueId = request('post_catalogue_id') ?: old('post_catalogue_id');
                    @endphp --}}
                    @include('backend.dashboard.component.keyword')
                    <a href="{{ route('customer.create') }}" class="btn btn-danger"><i
                            class="fa fa-plus mr5"></i>{{ __('messages.customer.create.title') }}</a>
                </div>
            </div>
        </div>
    </div>
</form>
