<div class="modal fade modalAdmin" id="currencyCodeModal" tabindex="-1" aria-labelledby="currencyCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="currencyCodeModalLabel">Search currency code by name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="admin-form-container">
                    <form id="searchCurrencyCode_form">
                        <div class="form-group">
                            <label for="q">{{ __('Currency Name') }}</label>
                            <input type="text" name="q" id="searchCurrencyCode_q" required placeholder="{{ __('Currency name') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <p class="form-label">{{ __('Search result') }} <i class="fa-solid fa-circle-info" style="cursor:pointer;" title="{{ __('Copy them and enter in Currency code field') }}"></i>:</p>
                            <p id="searchCurrencyCode_result"></p>
                        </div>
                        <button id="searchCurrencyCode_button" type="button" class="btn btn-success btn-block">
                            <i class="fa-solid fa-magnifying-glass"></i> {{ __('Search') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#searchCurrencyCode_button').click(function() {
        let form = $('#searchCurrencyCode_form');
        let query = $('#searchCurrencyCode_q').val();
        let resultBlock = $('#searchCurrencyCode_result');
        $.ajax({
            url: "{{ route('search-currency') }}",
            type: "POST",
            data: {
                'q': query
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
            },
            success: (data) => {
                resultBlock.empty();
                $.each(data, function(i, item) {
                    resultBlock.append('' +
                        '<b>Currency Code:</b> <i>'+item.code+'</i>, <b>name:</b> '+item.name+', <b>type:</b> '+item.type+', <b>unit:</b> '+item.unit
                    );
                    resultBlock.append('<br>');
                });
            },
            error: (data) => {
                console.log(data)
            },
            dataType: "json"
        });
    });
});
</script>
