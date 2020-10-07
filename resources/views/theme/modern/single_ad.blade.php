@extends('layout.main')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('social-meta')
    <meta property="og:title" content="{{ $ad->title }}">
    <meta property="og:description" content="{{ substr(trim(preg_replace('/\s\s+/', ' ',strip_tags($ad->description) )),0,160) }}">
    @if($ad->media_img->first())
        <meta property="og:image" content="{{ media_url($ad->media_img->first(), true) }}">
    @else
        <meta property="og:image" content="{{ asset('uploads/placeholder.png') }}">
    @endif
    <meta property="og:url" content="{{  route('single_ad', [$ad->id, $ad->slug]) }}">
    <meta name="twitter:card" content="summary_large_image">
    <!--  Non-Essential, But Recommended -->
    <meta name="og:site_name" content="{{ get_option('site_name') }}">
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/fotorama-4.6.4/fotorama.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/owl.carousel/assets/owl.carousel.css') }}">
@endsection

@section('main')

    <div class="modern-single-ad-top-description-wrap">

        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="modern-single-ad-breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="{{ route('home') }}">@lang('app.home')</a></li>
                            @if($ad->category)
                                <li><a href="{{ route('listing', ['category' => $ad->category->id]) }}">  {{ $ad->category->category_name }} </a> </li>
                            @endif
                            <li>{{ $ad->title }}</li>
                        </ol><!-- breadcrumb -->
                        <h2 class="modern-single-ad-top-title">{{ $ad->title }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div style="background-color: white; padding: 10px">
                    <div class="col-sm-7 col-xs-12">
                        <div class="row" style="padding-left: 20px">
                            @if($ad->discount_price==0)
                                <span style="color:#63e339;font-size: x-large;margin-left: 10px">${{$ad->price}}</span>
                            @else
                                <span style="color:#63e339;font-size: x-large;margin-left: 10px">${{$ad->discount_price}}</span>
                                @if($ad->price - $ad->discount_price > 0 && $ad->discount_price!=0)
                                    <span style="color:red;font-size: 15px;margin-left: 10px;text-decoration: line-through">${{$ad->price}}</span>
                                @endif
                            @endif
                        </div>
                        @if($ad->discount_price!=0)
                            <div class="row" style="padding-left: 20px">
                                <span style="color:#63e339;font-size: x-large;margin-left: 10px">Save</span>
                                <span style="color:#63e339;font-size: x-large;margin-left: 10px">${{$ad->price-$ad->discount_price}}</span>
                            </div>
                        @endif
                        <div class="row" style="padding:20px">
                            {{$ad->description}}
                        </div>
                        @if($ad['coupon_code']!='')
                            <div class="row" style="padding-left:20px;padding-bottom: 15px">
                                <div style="width:30%; padding-left:15px;padding-right:15px;padding-top:6px;padding-bottom:6px;border-radius: 10px;border-style:dotted;border-width:1px;text-align: center">{{$ad['coupon_code']}}</div>
                            </div>
                        @endif
                        @if($ad->expiry_date!='0000-00-00')
                            <div class="row" style="padding-left:20px;padding-bottom: 10px">
                                Offer expire: {{$ad->expiry_date}}

                            </div>
                            @if($ad->expiry_date > today())
                                <div class="row" style="color:red;padding-left:20px;padding-bottom: 20px;font-size: 20px">
                                    Not Expired
                                </div>
                            @else
                                <div class="row" style="color:red;padding-left:20px;padding-bottom: 20px;font-size: 20px">
                                    Expired
                                </div>
                            @endif


                        @endif
                        <div class="row" style="padding-left:20px;padding-bottom: 20px;font-size: 20px; ">
                            <div>
                                <a href="{{$ad->seller_url}}" style="background-color: #7bcbc8;padding-left: 15px;padding-right: 15px;padding-top: 8px;padding-bottom: 8px;text-align: center">Grab this offer</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5 col-xs-12">
                        <div>
                            <div style="font-size: 17px; padding-bottom: 10px; color:#248cf8; font-weight: bold">Categories</div>
                            @foreach($categories as $category)
                                <div style="color:#248cf8">
                                    <a style="color: #248cf8" href="{{ route('listing', ['category'=>$ad['category_id'], 'sub_category' => $category['id']]) }}" target="_self">{{$category['category_name']}}</a>
                                </div>
                            @endforeach
                        </div>
                        <div>
                            <div style="font-size: 17px; padding-bottom: 10px; color:#248cf8; padding-top: 10px;font-weight: bold">Brands</div>
                            @foreach($brands as $brand)
                                {{--                                <div style="color:#248cf8">{{$brand}}</div>--}}
                                <div>
                                    <a style="color: #248cf8" href="{{ route('listing', ['category'=>$ad['category_id'], 'sub_category' => $ad['sub_category_id'] , 'brand'=>$brand['id']]) }}" target="_self">{{$brand['brand_name']}}</a>
                                </div>

                            @endforeach
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

        </div>
    </div>






    @if($hp_deals->count() > 0 && get_option('enable_related_ads') == 1)
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="carousel-header">
                        <h4><a href="{{ route('listing') }}">
                                @lang('app.deals_from_hp')
                            </a>
                        </h4>
                    </div>
                    <hr />
                    <div class="themeqx_new_regular_ads_wrap themeqx-carousel-ads">
                        @foreach($related_ads as $rad)
                            <div>
                                <div itemscope itemtype="http://schema.org/Product" class="ads-item-thumbnail ad-box-{{$rad->price_plan}}">
                                    <div class="ads-thumbnail">
                                        <a href="{{  route('single_ad', [$rad->id, $rad->slug]) }}">
                                            <img itemprop="image"  src="{{ media_url($rad->feature_img) }}" class="img-responsive" alt="{{ $rad->title }}">
                                            <span class="modern-img-indicator">
                                                @if(! empty($rad->video_url))
                                                    <i class="fa fa-file-video-o"></i>
                                                @else
                                                    <i class="fa fa-file-image-o"> {{ $rad->media_img->count() }}</i>
                                                @endif
                                            </span>
                                        </a>
                                    </div>
                                    <div class="caption">
                                        <h4><a href="{{  route('single_ad', [$rad->id, $rad->slug]) }}" title="{{ $rad->title }}"><span itemprop="name">{{ str_limit($rad->title, 40) }} </span></a></h4>
                                        @if($rad->category)
                                            <a class="price text-muted" href="{{ route('listing', ['category' => $rad->category->id]) }}"> <i class="fa fa-folder-o"></i> {{ $rad->category->category_name }} </a>
                                        @endif

                                        @if($rad->city)
                                            <a class="location text-muted" href="{{ route('listing', ['city' => $rad->city->id]) }}"> <i class="fa fa-location-arrow"></i> {{ $rad->city->city_name }} </a>
                                        @endif
                                        <p class="date-posted text-muted"> <i class="fa fa-clock-o"></i> {{ $rad->created_at->diffForHumans() }}</p>
                                        @if($rad->discount_price==0)
                                            <p class="price"> <span itemprop="price" content="{{$rad->price}}"> {{ themeqx_price_ng($rad->price, $rad->is_negotiable) }} </span></p>
                                        @else
                                            <p class="price"> <span itemprop="price" content="{{$rad->discount_price}}"> {{ themeqx_price_ng($rad->discount_price, $rad->is_negotiable) }} </span></p>
                                        @endif
                                        <link itemprop="availability" href="http://schema.org/InStock" />
                                    </div>

                                    @if($rad->price_plan == 'premium')
                                        <div class="ribbon-wrapper-green"><div class="ribbon-green">{{ ucfirst($rad->price_plan) }}</div></div>
                                    @endif
                                    @if($rad->mark_ad_urgent == '1')
                                        <div class="ribbon-wrapper-red"><div class="ribbon-red">@lang('app.urgent')</div></div>
                                    @endif


                                </div>
                            </div>
                        @endforeach
                    </div> <!-- themeqx_new_premium_ads_wrap -->
                </div>

            </div>
        </div>
    @endif
    @if($similar_deals->count() > 0 && get_option('enable_related_ads') == 1)
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="carousel-header">
                        <h4><a href="{{ route('listing') }}">
                                @lang('app.similar_deals')
                            </a>
                        </h4>
                    </div>
                    <hr />
                    <div class="themeqx_new_regular_ads_wrap themeqx-carousel-ads">
                        @foreach($related_ads as $rad)
                            <div>
                                <div itemscope itemtype="http://schema.org/Product" class="ads-item-thumbnail ad-box-{{$rad->price_plan}}">
                                    <div class="ads-thumbnail">
                                        <a href="{{  route('single_ad', [$rad->id, $rad->slug]) }}">
                                            <img itemprop="image"  src="{{ media_url($rad->feature_img) }}" class="img-responsive" alt="{{ $rad->title }}">
                                            <span class="modern-img-indicator">
                                                @if(! empty($rad->video_url))
                                                    <i class="fa fa-file-video-o"></i>
                                                @else
                                                    <i class="fa fa-file-image-o"> {{ $rad->media_img->count() }}</i>
                                                @endif
                                            </span>
                                        </a>
                                    </div>
                                    <div class="caption">
                                        <h4><a href="{{  route('single_ad', [$rad->id, $rad->slug]) }}" title="{{ $rad->title }}"><span itemprop="name">{{ str_limit($rad->title, 40) }} </span></a></h4>
                                        @if($rad->category)
                                            <a class="price text-muted" href="{{ route('listing', ['category' => $rad->category->id]) }}"> <i class="fa fa-folder-o"></i> {{ $rad->category->category_name }} </a>
                                        @endif

                                        @if($rad->city)
                                            <a class="location text-muted" href="{{ route('listing', ['city' => $rad->city->id]) }}"> <i class="fa fa-location-arrow"></i> {{ $rad->city->city_name }} </a>
                                        @endif
                                        <p class="date-posted text-muted"> <i class="fa fa-clock-o"></i> {{ $rad->created_at->diffForHumans() }}</p>
                                        @if($rad->discount_price==0)
                                            <p class="price"> <span itemprop="price" content="{{$rad->price}}"> {{ themeqx_price_ng($rad->price, $rad->is_negotiable) }} </span></p>
                                        @else
                                            <p class="price"> <span itemprop="price" content="{{$rad->discount_price}}"> {{ themeqx_price_ng($rad->discount_price, $rad->is_negotiable) }} </span></p>
                                        @endif
                                        <link itemprop="availability" href="http://schema.org/InStock" />
                                    </div>

                                    @if($rad->price_plan == 'premium')
                                        <div class="ribbon-wrapper-green"><div class="ribbon-green">{{ ucfirst($rad->price_plan) }}</div></div>
                                    @endif
                                    @if($rad->mark_ad_urgent == '1')
                                        <div class="ribbon-wrapper-red"><div class="ribbon-red">@lang('app.urgent')</div></div>
                                    @endif


                                </div>
                            </div>
                        @endforeach
                    </div> <!-- themeqx_new_premium_ads_wrap -->
                </div>

            </div>
        </div>
    @endif

    <div class="modern-post-ad-call-to-cation">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1>@lang('app.want_something_sell_quickly')</h1>
                    <p>@lang('app.post_your_ad_quicly')</p>
                    <a href="{{route('create_ad')}}" class="btn btn-info btn-lg">@lang('app.post_an_ad')</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reportAdModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@lang('app.report_ad_title')</h4>
                </div>
                <div class="modal-body">

                    <p>@lang('app.report_ad_description')</p>

                    <form>

                        <div class="form-group">
                            <label class="control-label">@lang('app.reason'):</label>
                            <select class="form-control" name="reason">
                                <option value="">@lang('app.select_a_reason')</option>
                                <option value="unavailable">@lang('app.item_sold_unavailable')</option>
                                <option value="fraud">@lang('app.fraud')</option>
                                <option value="duplicate">@lang('app.duplicate')</option>
                                <option value="spam">@lang('app.spam')</option>
                                <option value="wrong_category">@lang('app.wrong_category')</option>
                                <option value="offensive">@lang('app.offensive')</option>
                                <option value="other">@lang('app.other')</option>
                            </select>

                            <div id="reason_info"></div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="control-label">@lang('app.email'):</label>
                            <input type="text" class="form-control" id="email" name="email">
                            <div id="email_info"></div>

                        </div>
                        <div class="form-group">
                            <label for="message-text" class="control-label">@lang('app.message'):</label>
                            <textarea class="form-control" id="message" name="message"></textarea>
                            <div id="message_info"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('app.close')</button>
                    <button type="button" class="btn btn-primary" id="report_ad">@lang('app.report_ad')</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="replyByEmail" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>

                <form action="" id="replyByEmailForm" method="post"> @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="control-label">@lang('app.name'):</label>
                            <input type="text" class="form-control" id="name" name="name" data-validation="required">
                        </div>

                        <div class="form-group">
                            <label for="email" class="control-label">@lang('app.email'):</label>
                            <input type="text" class="form-control" id="email" name="email">
                        </div>

                        <div class="form-group">
                            <label for="phone_number" class="control-label">@lang('app.phone_number'):</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number">
                        </div>

                        <div class="form-group">
                            <label for="message-text" class="control-label">@lang('app.message'):</label>
                            <textarea class="form-control" id="message" name="message"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="ad_id" value="{{ $ad->id }}" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('app.close')</button>
                        <button type="submit" class="btn btn-primary" id="reply_by_email_btn">@lang('app.send_email')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




@endsection

@section('page-js')
    <script src="{{ asset('assets/plugins/fotorama-4.6.4/fotorama.js') }}"></script>
    <script src="{{ asset('assets/plugins/SocialShare/SocialShare.js') }}"></script>
    <script src="{{ asset('assets/plugins/owl.carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/form-validator/form-validator.min.js') }}"></script>

    <script>
        $('.share').ShareLink({
            title: '{{ $ad->title }}', // title for share message
            text: '{{ substr(trim(preg_replace('/\s\s+/', ' ',strip_tags($ad->description) )),0,160) }}', // text for share message

            @if($ad->media_img->first())
            image: '{{ media_url($ad->media_img->first(), true) }}', // optional image for share message (not for all networks)
            @else
            image: '{{ asset('uploads/placeholder.png') }}', // optional image for share message (not for all networks)
            @endif
            url: '{{  route('single_ad', [$ad->id, $ad->slug]) }}', // link on shared page
            class_prefix: 's_', // optional class prefix for share elements (buttons or links or everything), default: 's_'
            width: 640, // optional popup initial width
            height: 480 // optional popup initial height
        })
    </script>
    <script>
        $.validate();
    </script>
    <script>
        $(document).ready(function(){
            $(".themeqx_new_regular_ads_wrap").owlCarousel({
                loop:true,
                margin:10,
                responsiveClass:true,
                responsive:{
                    0:{
                        items:1,
                        nav:true
                    },
                    600:{
                        items:3,
                        nav:false
                    },
                    1000:{
                        items:4,
                        nav:true,
                        loop:false
                    }
                },
                navText : ['<i class="fa fa-arrow-circle-o-left"></i>','<i class="fa fa-arrow-circle-o-right"></i>']
            });
        });
    </script>
    <script>
        $(function(){
            $('#onClickShowPhone').click(function(){
                $('#ShowPhoneWrap').html('<i class="fa fa-phone"></i> {{ $ad->seller_phone }}');
            });

            $('#save_as_favorite').click(function(){
                var selector = $(this);
                var slug = selector.data('slug');

                $.ajax({
                    type : 'POST',
                    url : '{{ route('save_ad_as_favorite') }}',
                    data : { slug : slug, action: 'add',  _token : '{{ csrf_token() }}' },
                    success : function (data) {
                        if (data.status == 1){
                            selector.html(data.msg);
                        }else {
                            if (data.redirect_url){
                                location.href= data.redirect_url;
                            }
                        }
                    }
                });
            });

            $('button#report_ad').click(function(){
                var reason = $('[name="reason"]').val();
                var email = $('[name="email"]').val();
                var message = $('[name="message"]').val();
                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

                var error = 0;
                if(reason.length < 1){
                    $('#reason_info').html('<p class="text-danger">Reason required</p>');
                    error++;
                }else {
                    $('#reason_info').html('');
                }
                if(email.length < 1){
                    $('#email_info').html('<p class="text-danger">Email required</p>');
                    error++;
                }else {
                    if ( ! regex.test(email)){
                        $('#email_info').html('<p class="text-danger">Valid email required</p>');
                        error++;
                    }else {
                        $('#email_info').html('');
                    }
                }
                if(message.length < 1){
                    $('#message_info').html('<p class="text-danger">Message required</p>');
                    error++;
                }else {
                    $('#message_info').html('');
                }

                if (error < 1){
                    $('#loadingOverlay').show();
                    $.ajax({
                        type : 'POST',
                        url : '{{ route('report_ads_pos') }}',
                        data : { reason : reason, email: email,message:message, slug:'{{ $ad->slug }}',  _token : '{{ csrf_token() }}' },
                        success : function (data) {
                            if (data.status == 1){
                                toastr.success(data.msg, '@lang('app.success')', toastr_options);
                            }else {
                                toastr.error(data.msg, '@lang('app.error')', toastr_options);
                            }
                            $('#reportAdModal').modal('hide');
                            $('#loadingOverlay').hide();
                        }
                    });
                }
            });

            $('#replyByEmailForm').submit(function(e){
                e.preventDefault();
                var reply_email_form_data = $(this).serialize();

                $('#loadingOverlay').show();
                $.ajax({
                    type : 'POST',
                    url : '{{ route('reply_by_email_post') }}',
                    data : reply_email_form_data,
                    success : function (data) {
                        if (data.status == 1){
                            toastr.success(data.msg, '@lang('app.success')', toastr_options);
                        }else {
                            toastr.error(data.msg, '@lang('app.error')', toastr_options);
                        }
                        $('#replyByEmail').modal('hide');
                        $('#loadingOverlay').hide();
                    }
                });
            });
            $('#click_grab').click(function(){
                window.location.assign("https://www.coupondunia.in/grabadeal")
            })

        });
    </script>

@endsection