<div class="col-lg-4">
    <div class="ibox">
        <div class="ibox-title">
            <h5>{{ __('messages.promotion.createPromotion.timeProgram') }}</h5>
        </div>
        <div class="ibox-content">
            <div class="form-row mb20">
                <label for=""
                    class="control-label text-left">{{ __('messages.promotion.createPromotion.startDate') }}<span
                        class="text-danger">(*)</span></label>
                <input type="datetime-local" name="startDate" id="datetime"
                    value="{{ old('startDate', $promotion->startDate ?? '') }}" class="form-control" placeholder=""
                    autocomplete="off" {{ isset($disabled) ? 'disabled' : '' }}>
            </div>
            <div class="form-row mb20">
                <label for=""
                    class="control-label text-left">{{ __('messages.promotion.createPromotion.endDate') }}<span
                        class="text-danger">(*)</span></label>
                <input type="datetime-local" name="endDate" value="{{ old('endDate', $promotion->endDate ?? '') }}"
                    class="form-control" placeholder="" autocomplete="off" {{ isset($disabled) ? 'disabled' : '' }}>
            </div>
            <div class="form-row">
                <div class="uk-flex uk-flex-middle">
                    <input type="checkbox" name="" class="" value="accept" id="neverEnd">
                    <label for=""
                        class="control-label fix-label ml5">{{ __('messages.promotion.createPromotion.noEndDate') }}</label>
                </div>
            </div>
        </div>
    </div>
    <div class="ibox">
        <div class="ibox-title">
            <h5>{{ __('messages.promotion.createPromotion.customer') }}</h5>
        </div>
        <div class="ibox-content">
            <div class="setting-value">
                <div class="form-row mb20">
                    <div class="uk-flex uk-flex-middle">
                        <input type="radio" name="customer" class="chooseSource" value="accept" id="allSource">
                        <label for="allSource"
                            class="control-label fix-label ml5">{{ __('messages.promotion.createPromotion.allCustomer') }}</label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="uk-flex uk-flex-middle">
                        <input type="radio" name="customer" class="chooseSource" value="accept" id="chooseSource">
                        <label for="chooseSource"
                            class="control-label fix-label ml5">{{ __('messages.promotion.createPromotion.chooseCustomer') }}</label>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="ibox">
        <div class="ibox-title">
            <h5>{{ __('messages.promotion.createPromotion.object') }}</h5>
        </div>
        <div class="ibox-content">
            <div class="form-row mb20">
                <div class="uk-flex uk-flex-middle">
                    <input type="radio" name="apply" class="chooseApply" value="" id="allApply">
                    <label for="allApply"
                        class="control-label fix-label ml5">{{ __('messages.promotion.createPromotion.allObject') }}</label>
                </div>
            </div>
            <div class="form-row">
                <div class="uk-flex uk-flex-middle">
                    <input type="radio" name="apply" class="chooseApply" value="" id="chooseApply">
                    <label for="chooseApply"
                        class="control-label fix-label ml5">{{ __('messages.promotion.createPromotion.chooseObject') }}</label>
                </div>
            </div>
        </div>
    </div>
</div>
