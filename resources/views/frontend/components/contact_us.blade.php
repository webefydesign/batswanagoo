@push('push_css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.2.1/build/css/intlTelInput.css">

<style>
  .iti {
    width: 100%;
  }
  #phone {
    border: 1px solid #ddd;
    color: #555;
    margin-bottom: 10px;
    height: 35px;
    padding: 5px;
    width: 100%;
    -webkit-transition: all 0.5s;
    -moz-transition: all 0.5s;
    -ms-transition: all 0.5s;
    -o-transition: all 0.5s;
    transition: all 0.5s;
  }
  .contact-charCount {
    display: block;
    text-align: right;
    font-size: 12px;
    color: #999;
    margin-top: 4px;
  }
  .iti__selected-flag {
    pointer-events: none;
  }
  .iti__arrow {
    display: none;
  }
</style>
@endpush
<div class="m-container">
    <section class="contact_sec">
        <div class="container">
          <div class="row">
            <div class="col-md-12 text-center">
              @isset($meta['page_title'])
              <h1 style="border-bottom: 0px;" class="mb-0">{{$meta['page_title']}}</h1>
              @endisset
              @isset($meta['page_description'])
              <p>{{$meta['page_description']}}</p>
              @endisset
            </div>
          </div>
            <div class="row">              
                <div class="col-sm-4">
                    <div class="contact_info_sec">
                        <h3>{!! ($meta['detail_heading'])??'' !!}</h3>
                        <ul class="contacts-list">
                            @foreach (['address', 'phone', 'hour', 'email'] as $type)
                              @isset($meta[$type]['heading'])  
                              <li class="contacts-list-item">
                                    <div class="contacts-list-item__icon">
                                        <img src="{{ url(($meta[$type]['img'])??'#') }}" data-uk-svg="" alt="{{ ($meta[$type]['img_alt'])??'' }}">
                                    </div>
                                    <div class="contacts-list-item__desc">
                                        <div class="contacts-list-item__label">{!! ($meta[$type]['heading'])??'' !!}</div>
                                        <div class="contacts-list-item__content">{!! ($meta[$type]['text'])??'' !!}</div>
                                    </div>
                                </li>
                                @endisset
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!-- sm6 -->
                <div class="col-sm-8">
                    <div class="sforms">
                        <form action="{{ route('contactMail') }}" method="POST" id="frmContactUs">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-sm-12">
                                    <h3>{!! ($meta['form_heading'])??'' !!}</h3>
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label>Full name</label>
                                    <input type="text" name="name" placeholder="Name" required maxlength="100" autocomplete="off" class="form-control">
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" placeholder="Email" required maxlength="100" autocomplete="off" class="form-control">
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label>Telephone</label>
                                    <input id="phone" type="tel" class="form-control" name="phone" placeholder="71 123 456">
                                    <input type="hidden" id="country_code" name="country_code" />
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label>Message</label>
                                    <textarea name="message" id="contactMessage" placeholder="Write your message" required maxlength="5000" autocomplete="off" class="form-control" rows="10"></textarea>
                                    <span class="contact-charCount"><span id="contactMessageCount">0</span>/5000</span>
                                </div>
                                <div class="col-sm-12 form-group">
                                    <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="p-forme">
                                        <button type="submit" class="sal-save">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- sm6 -->
            </div>
        </div>
    </section>
</div>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@push('push_script')
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@25.2.1/build/js/intlTelInput.min.js"></script>
<script>
  $(document).ready(function () {
    // Initialize intlTelInput
    const input = $("#phone");
    const countryCodeInput = $("#country_code");
    const iti = window.intlTelInput(input[0], {
      initialCountry: "bw", // Default to Botswana
      onlyCountries: ["bw"], // Lock to Botswana, no other country selectable
      separateDialCode: true, // Show dial code separately
      utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@25.2.1/build/js/utils.js", // for number formatting
    });

    // Restrict input to numbers only
    input.on("input", function () {
      const validChars = /^[0-9]*$/; // Allow only numbers
      if (!validChars.test(this.value)) {
        this.value = this.value.replace(/[^0-9]/g, ""); // Remove invalid characters
      }
    });

    // Update hidden country code field on form submission
    $("#frmContactUs").on("submit", function () {
      const countryCode = iti.getSelectedCountryData().dialCode; // Get the country code
      countryCodeInput.val(countryCode); // Set the country code in the hidden field
    });

    // Live character count for the message field
    const message = $("#contactMessage");
    const messageCount = $("#contactMessageCount");
    message.on("input", function () {
      messageCount.text(this.value.length);
    });
  });
</script>
@endpush
