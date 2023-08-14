@extends('app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    {{ __('lang.settings') }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                 aria-orientation="vertical">
                                <a class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill"
                                   href="#general" role="tab" aria-controls="v-pills-home"
                                   aria-selected="true">{{ __('lang.general') }}</a>
                                <a class="nav-link" id="v-pills-home-tab" data-bs-toggle="pill"
                                   href="#banners" role="tab" aria-controls="v-pills-home"
                                   aria-selected="true">{{ __('lang.banners') }}</a>
                                <a class="nav-link" id="v-pills-home-tab" data-bs-toggle="pill"
                                   href="#cities" role="tab" aria-controls="v-pills-home"
                                   aria-selected="true">{{ __('lang.cities') }}</a>
                                <a class="nav-link" id="v-pills-home-tab" data-bs-toggle="pill"
                                   href="#cms" role="tab" aria-controls="v-pills-home"
                                   aria-selected="true">{{ __('lang.cms') }}</a>
                            </div>
                        </div>
                        <div class="col-md-9 col-sm-12">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="general" role="tabpanel"
                                     aria-labelledby="v-pills-home-tab">
                                    <form action="{{ route('setting.store') }}" data-parsley-validate
                                          id="general-setting-form" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id"
                                               value="{{ isset($setting->id) ? $setting->id : null }}">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="">{{ __('lang.site_name') }}</label>
                                                    <input type="text" name="site_name"
                                                           value="{{ isset($setting->site_name) ? $setting->site_name : null }}"
                                                           class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="">{{ __('lang.ntn_number') }}</label>
                                                    <input type="text" name="ntn_number"
                                                           value="{{ isset($setting->ntn_number) ? $setting->ntn_number : null }}"
                                                           class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="">{{ __('lang.srtn_number') }}</label>
                                                    <input type="text" name="srtn_number"
                                                           value="{{ isset($setting->srtn_number) ? $setting->srtn_number : null }}"
                                                           class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="">{{ __('lang.contact_number') }}</label>
                                                    <input type="text" name="contact_number"
                                                           value="{{ isset($setting->contact_number) ? $setting->contact_number : null }}"
                                                           class="form-control"
                                                           required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="">{{ __('lang.email') }}</label>
                                                    <input type="text" name="contact_email"
                                                           value="{{ isset($setting->contact_email) ? $setting->contact_email : null }}"
                                                           class="form-control"
                                                           required>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label for="">{{ __('lang.dark_mode') }}</label>
                                                    <div class="form-check form-switch fs-6">
                                                        <input class="form-check-input me-0" type="checkbox"
                                                               id="toggle-dark" name="dark_mode"
                                                               @if(isset($setting->dark_mode) && $setting->dark_mode) checked
                                                               @endif value="1">
                                                        <label class="form-check-label"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label for="">{{ __('lang.allow_brands') }}</label>
                                                    <div class="form-check form-switch fs-6">
                                                        <input class="form-check-input me-0" type="checkbox"
                                                               id="toggle-dark" name="allow_brands"
                                                               @if(isset($setting->allow_brands) && $setting->allow_brands) checked
                                                               @endif value="1">
                                                        <label class="form-check-label"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="">{{ __('lang.fb_url') }}</label>
                                                    <input type="text" name="facebook_url"
                                                           value="{{ isset($setting->facebook_url) ? $setting->facebook_url : null }}"
                                                           class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="">{{ __('lang.insta_url') }}</label>
                                                    <input type="text" name="instagram_url"
                                                           value="{{ isset($setting->instagram_url) ? $setting->instagram_url : null }}"
                                                           class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="">{{ __('lang.twitter_url') }}</label>
                                                    <input type="text" name="twitter_url"
                                                           value="{{ isset($setting->twitter_url) ? $setting->twitter_url : null }}"
                                                           class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="">{{ __('lang.liIN_url') }}</label>
                                                    <input type="text" name="linkedin_url"
                                                           value="{{ isset($setting->linkedin_url) ? $setting->linkedin_url : null }}"
                                                           class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="">{{ __('lang.delivery_charges') }}</label>
                                                    <input type="number" name="delivery_charges" step="0.01"
                                                           value="{{ isset($setting->delivery_charges) ? $setting->delivery_charges : null }}"
                                                           class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="">{{ __('lang.delivery_time') }}</label>
                                                    <input type="number" name="delivery_time"
                                                           value="{{ isset($setting->delivery_time) ? $setting->delivery_time : null }}"
                                                           class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">{{ __('lang.billu_bhai_points') }}</label>
                                                            <div class="form-check form-switch fs-6">
                                                                <input class="form-check-input me-0" type="checkbox"
                                                                       id="toggle-dark" name="allow_billu_points"
                                                                       @if(isset($setting->allow_billu_points) && $setting->allow_billu_points) checked
                                                                       @endif value="1">
                                                                <label class="form-check-label"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">{{ __('lang.allow_points_on') }}</label><br>
                                                            <input type="number" name="allow_points_on_price" id="allow_points_on_price"
                                                                   value="{{ isset($setting->allow_points_on_price) ? $setting->allow_points_on_price : null }}"
                                                                   class="form-control" step="0.01">
                                                            <span style="font-size: 12px">{{ __('lang.allow_points_on_note') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">{{ __('lang.allow_points') }}</label><br>
                                                            <input type="number" name="allow_points" id="allow_points"
                                                                   value="{{ isset($setting->allow_points) ? $setting->allow_points : null }}"
                                                            class="form-control" step="0.01">
                                                            <span style="font-size: 12px">{{ __('lang.allow_points_note') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">{{ __('lang.amount_to_be_used_on_points') }}</label>
                                                            <input type="number" name="amount_to_be_used_on_points" id="amount_to_be_used_on_points"
                                                                   value="{{ isset($setting->amount_to_be_used_on_points) ? $setting->amount_to_be_used_on_points : null }}"
                                                                   class="form-control" step="0.01">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="">{{ __('lang.allow_promo_code') }}</label>
                                                    <div class="form-check form-switch fs-6">
                                                        <input class="form-check-input me-0" type="checkbox"
                                                               id="toggle-dark" name="allow_promo_code"
                                                               @if(isset($setting->allow_promo_code) && $setting->allow_promo_code) checked
                                                               @endif value="1">
                                                        <label class="form-check-label"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="">{{ __('lang.address') }}</label>
                                                    <textarea name="address" id="address" class="form-control
"
                                                              rows="5">{{ isset($setting->address) ? $setting->address : null }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="">{{ __('lang.site_logo') }}</label>
                                                    <input
                                                        type="file"
                                                        name="logo"
                                                        class="dropify"
                                                        data-max-width="500"
                                                        data-max-height="500"
                                                        @if(isset($setting->logo) && $setting->logo) data-default-file="{{ asset('/' . $setting->logo) }}" @endif>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="">{{ __('lang.favicon') }}</label>
                                                    <input
                                                        type="file"
                                                        name="favicon"
                                                        class="dropify"
                                                        data-max-width="150"
                                                        data-max-height="150"
                                                        @if(isset($setting->favicon) && $setting->favicon) data-default-file="{{ asset('/' . $setting->favicon) }}" @endif>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12 text-right">
                                                <button type="submit" id="save-general-setting" class="btn btn-success">
                                                    <i class="bi bi-save"></i>&nbsp;{{ __('lang.save') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="banners" role="tabpanel">
                                    @if($setting)
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Banner Images</h5>
                                            </div>
                                            <div class="card-body">
                                                <form action="{{ route('setting.save-banners') }}"
                                                      id="banner-images-form" method="post"
                                                      enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="id"
                                                           value="{{ isset($setting->id) ? $setting->id : null }}">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="">{{ __('lang.banner_img') }}</label>
                                                                <input
                                                                    type="file"
                                                                    name="banner"
                                                                    class="dropify"
                                                                    data-max-width="1300"
                                                                    data-max-height="365"
                                                                >
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="">{{ __('lang.title') }}</label>
                                                                <input type="text" name="content_heading" class="form-control" placeholder="Banner Heading">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="">{{ __('lang.desc') }}</label>
                                                                <textarea name="content" placeholder="Banner Description" id="" rows="5" class="form-control"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="">{{ __('lang.deals') }}</label>
                                                                <select name="deal_id" id="deal_id"
                                                                        class="form-control">
                                                                    <option value="">{{ __('lang.select_option') }}</option>
                                                                    @foreach($deals as $deal)
                                                                        <option value="{{ $deal->id }}">{{ $deal->title }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="">{{ __('lang.position') }}</label>
                                                                <select name="position" id="deal_id"
                                                                        class="form-control">
                                                                    <option value="">{{ __('lang.select_option') }}</option>
                                                                    <option value="center">{{ __('lang.center') }}</option>
                                                                    <option value="right">{{ __('lang.right') }}</option>
                                                                    <option value="right">{{ __('lang.left') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">{{ __('lang.home_page_banner') }}</label>
                                                            <div class="form-check form-switch fs-6">
                                                                <input class="form-check-input me-0" type="checkbox"
                                                                       id="toggle-dark" name="home_page_banner"
                                                                       @if(isset($setting->home_page_banner) && $setting->home_page_banner) checked
                                                                       @endif value="1">
                                                                <label class="form-check-label"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-12 text-right">
                                                            <button type="submit" id="save-general-setting"
                                                                    class="btn btn-success">
                                                                <i class="bi bi-save"></i>&nbsp;{{ __('lang.save') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="row">
                                                    <div class="card-header">
                                                        <h5>Banners Images</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped" id="table1">
                                                                <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th></th>
                                                                    <th></th>
                                                                    <th></th>
                                                                    <th>{{ __('lang.show_on_home') }}</th>
                                                                    <th>{{ __('lang.actions') }}</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @if(isset($setting->banners) && $setting->banners->count())
                                                                    @foreach($setting->banners as $key => $banner)
                                                                        <tr>
                                                                            <td>{{ $key + 1 }}</td>
                                                                            <td colspan="3"><img width="350"
                                                                                                 src="{{ asset('/' . $banner->path . $banner->title) }}"
                                                                                                 alt="banner_{{ $key }}">
                                                                            </td>
                                                                            <td>
                                                                                <a href="{{ route('setting.change-banner-status', ['id' => $banner->id]) }}">
                                                                                    {{ $banner->show_on_home ? 'Hide' : 'Show' }}
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a class="text-danger"
                                                                                   href="{{ route('setting.delete-banner', ['id' => $banner->id]) }}">
                                                                                    <span class="bi bi-trash"></span>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <h4 class="text-center">{{ __('lang.add_general_setting_message') }}</h4>
                                    @endif
                                </div>
                                <div class="tab-pane fade" id="cms" role="tabpanel">
                                    <div class="card">
                                        <h4>{{ __('lang.cms') }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('setting.store') }}" data-parsley-validate
                                              id="cms-setting-form" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id"
                                                   value="{{ isset($setting->id) ? $setting->id : null }}">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="about_us">{{ __('lang.about_us') }}</label>
                                                        <textarea name="about_us" id="about_us"
                                                                  rows="5" class="textarea form-control">
                                                        {{isset($setting->about_us) ? $setting->about_us : null}}
                                                    </textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label
                                                            for="refund_policy">{{ __('lang.refund_policy') }}</label>
                                                        <textarea name="refund_policy" id="refund_policy"
                                                                  rows="5" class="textarea form-control">
                                                        {{isset($settig->refund_policy) ? $setting->refund_policy : null}}
                                                    </textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label
                                                            for="terms_conditions">{{ __('lang.terms_conditions') }}</label>
                                                        <textarea name="terms_and_conditions" id="terms_conditions"
                                                                  rows="5" class="textarea form-control">
                                                        {{isset($settig->terms_and_conditions) ? $setting->terms_and_conditions : null}}
                                                    </textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label
                                                            for="privacy_policy">{{ __('lang.privacy_policy') }}</label>
                                                        <textarea name="privacy_policy" id="privacy_policy"
                                                                  rows="5" class="textarea form-control">
                                                        {{isset($settig->privacy_policy) ? $setting->privacy_policy : null}}
                                                    </textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12 text-right">
                                                    <button class="btn btn-success">
                                                        <i class="bi bi-save"></i> {{ __('lang.save') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="cities" role="tabpanel">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-6">
                                                <h4>{{ __('lang.cities') }}</h4>
                                            </div>
                                            <div class="col-6 text-right">
                                                <button class="btn btn-primary" data-bs-target="#addCity"
                                                        data-bs-toggle="modal"><i
                                                        class="bi bi-plus"></i> {{ __('lang.add_option', ['field' => __('lang.city')]) }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="table2">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ __('lang.city') }}</th>
                                                    <th>{{ __('lang.postal_code') }}</th>
                                                    <th>{{ __('lang.actions') }}</th>
                                                </tr>
                                                </thead>
                                                @foreach($cities as $key => $city)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $city->city }}</td>
                                                        <td>{{ $city->postal_code }}</td>
                                                        <td>
                                                            <a href="{{ route('setting.delete-city', ['id' => $city->id])}}"
                                                               class="text-danger">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="addCity">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('lang.add_option', ['field' => __('lang.city')]) }}</h5>
                </div>
                <form action="{{ route('setting.save-city') }}" method="post" data-parsley-validate
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">{{ __('lang.city') }}</label>
                                    <input type="text" name="city" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">{{ __('lang.postal_code') }}</label>
                                    <input type="text" name="postal_code" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">{{ __('lang.image') }}</label>
                                    <input type="file" name="image" class="dropify" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> {{ __('lang.save') }}
                        </button>
                        <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">{{ __('lang.close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1, {
            "ordering": false
        });

        let table2 = document.querySelector('#table2');
        let dataTable = new simpleDatatables.DataTable(table2, {
            "ordering": false
        });

    </script>
@endpush
