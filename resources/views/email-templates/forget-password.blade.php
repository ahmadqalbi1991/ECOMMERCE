<div class="email-container" style="background: #f5f5f5; padding: 50px; text-align: center; border-radius: 25px; border: 6px solid #36499B; font-family: Sans-serif,serif">
    <div class="email-wrapper">
        <div class="logo">
            <img src="{{ asset('/' . $setting->logo) }}">
        </div>
        <div class="email-content-wrapper">
            <h4>{{ __('lang.forget_password') }}</h4>
            <p>{{ __('lang.click_link_below_for_reset_password') }}</p>
            <a style="background: #36499B; color: #fff; text-decoration: none; padding: 10px 25px; border-radius: 5px;" href="{{ env('REACT_APP_URL') }}?&secure_pass={{ $id }}&forget=1" class="activate_account_btn">{{ __('lang.reset_password') }}</a>
        </div>
    </div>
</div>
