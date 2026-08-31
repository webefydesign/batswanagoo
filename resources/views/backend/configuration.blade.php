@extends('layouts.backend')
@section('title', 'Configurations')
@section('customStyles')
<link rel="stylesheet" href="{{asset('assets_backend/css/bootstrap-tagsinput.css')}}" />

@endsection
@section('content')
<form action="{{route('updateConfiguration')}}" method="POST" id="updateForm">
    <div class="bg-body-light">
        <div class="content content-full">
          <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
              <h1 class="h3 fw-bold mb-1">
                Configuration
              </h1>
              {{-- <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                Multiple style options to match your preferences.
              </h2> --}}
              <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item">
                  <a class="link-fx" href="{{route('dashboard')}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    Configuration
                </li>
              </ol>
            </div>
            <button type="submit" class="btn btn-outline-success me-1 mb-3">
              @csrf
                <i class="fa fa-fw fa-save me-1"></i> Save
            </button>
          </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
          @if(Session::has('success'))
            <div class="alert alert-success">
              {{Session::get('success')}}
            </div>
          @endif
          @if(Session::has('error'))
            <div class="alert alert-danger">
              {{Session::get('error')}}
            </div>
          @endif
            <div class="col-md-12">
                <div class="block block-rounded row g-0">
                    <ul class="nav nav-tabs nav-tabs-block flex-md-column col-md-4 col-xxl-2" role="tablist">
                      <li class="nav-item d-md-flex flex-md-column">
                        <button type="button" class="nav-link text-md-start active" id="general-t-tab" data-bs-toggle="tab" data-bs-target="#general-t" role="tab" aria-controls="general-tab" aria-selected="true">
                          <i class="fa fa-fw fa-home opacity-50 me-1 d-none d-sm-inline-block"></i>
                          <span>General</span>
                          <span class="d-none d-md-block fs-xs fw-medium opacity-75 mt-md-2">
                            Here you change the general setting of your website.
                          </span>
                        </button>
                      </li>
                      <li class="nav-item d-md-flex flex-md-column">
                        <button type="button" class="nav-link text-md-start" id="social-t-tab" data-bs-toggle="tab" data-bs-target="#social-t" role="tab" aria-controls="social-t" aria-selected="false">
                          <i class="fa fa-fw fa-user-circle opacity-50 me-1 d-none d-sm-inline-block"></i>
                          <span>Social</span>
                          <span class="d-none d-md-block fs-xs fw-medium opacity-75 mt-md-2">
                            Here you can manage your social links of your website.
                          </span>
                        </button>
                      </li>
                      <li class="nav-item d-md-flex flex-md-column">
                        <button type="button" class="nav-link text-md-start" id="header-t-tab" data-bs-toggle="tab" data-bs-target="#header-t" role="tab" aria-controls="header-t" aria-selected="false">
                          <i class="fa fa-fw fa-cog opacity-50 me-1 d-none d-sm-inline-block"></i>
                          <span>Header</span>
                          <span class="d-none d-md-block fs-xs fw-medium opacity-75 mt-md-2">
                            Here you can manage your header of your website.
                          </span>
                        </button>
                      </li>
                      <li class="nav-item d-md-flex flex-md-column">
                        <button type="button" class="nav-link text-md-start" id="footer-t-tab" data-bs-toggle="tab" data-bs-target="#footer-t" role="tab" aria-controls="footer-t" aria-selected="false">
                          <i class="fa fa-fw fa-cog opacity-50 me-1 d-none d-sm-inline-block"></i>
                          <span>Footer</span>
                          <span class="d-none d-md-block fs-xs fw-medium opacity-75 mt-md-2">
                            Here you can manage your footer of your website.
                          </span>
                        </button>
                      </li>
                      <li class="nav-item d-md-flex flex-md-column">
                        <button type="button" class="nav-link text-md-start" id="search-t-tab" data-bs-toggle="tab" data-bs-target="#search-t" role="tab" aria-controls="search-tab" aria-selected="true">
                          <i class="fa fa-fw fa-search opacity-50 me-1 d-none d-sm-inline-block"></i>
                          <span>Search Page</span>
                          <span class="d-none d-md-block fs-xs fw-medium opacity-75 mt-md-2">
                            Here you change the general setting of your website search page.
                          </span>
                        </button>
                      </li>
                      <li class="nav-item d-md-flex flex-md-column">
                        <button type="button" class="nav-link text-md-start" id="sidebar-t-tab" data-bs-toggle="tab" data-bs-target="#sidebar-t" role="tab" aria-controls="sidebar-t" aria-selected="false">
                          <i class="fa fa-fw fa-list opacity-50 me-1 d-none d-sm-inline-block"></i>
                          <span>Sidebar</span>
                          <span class="d-none d-md-block fs-xs fw-medium opacity-75 mt-md-2">
                            Here you can manage your all sidebars of the website
                          </span>
                        </button>
                      </li>
                      <li class="nav-item d-md-flex flex-md-column">
                        <button type="button" class="nav-link text-md-start" id="seo-t-tab" data-bs-toggle="tab" data-bs-target="#seo-t" role="tab" aria-controls="seo-t" aria-selected="false">
                          <i class="fa fa-fw fa-hashtag opacity-50 me-1 d-none d-sm-inline-block"></i>
                          <span>SEO Related</span>
                          <span class="d-none d-md-block fs-xs fw-medium opacity-75 mt-md-2">
                            Here you can manage your seo related things of the website
                          </span>
                        </button>
                      </li>
                      <li class="nav-item d-md-flex flex-md-column">
                        <button type="button" class="nav-link text-md-start" id="s-modal-tab" data-bs-toggle="tab" data-bs-target="#s-modal" role="tab" aria-controls="s-modal" aria-selected="false">
                          <i class="fa fa-fw fa-hashtag opacity-50 me-1 d-none d-sm-inline-block"></i>
                          <span>StartUp Modal</span>
                          <span class="d-none d-md-block fs-xs fw-medium opacity-75 mt-md-2">
                            Here you can manage your startup modal
                          </span>
                        </button>
                      </li>
                    </ul>
                    <div class="tab-content col-md-8 col-xxl-10">
                      <div class="block-content tab-pane active" id="general-t" role="tabpanel" aria-labelledby="general-t-tab" tabindex="0">
                        <h4 class="fw-semibold">General</h4>
                        <div class="row">
                          <div class="form-group col-md-6 pb-2">
                            <label for="">Watermark</label>
                            <div class="input-group pull-left">
                              <span class="input-group-btn">
                                  <a data-input="watermark-img" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
                              </span>
                              <input id="watermark-img" class="form-control input-sm" type="text" name="watermark" value="{{$data['watermark']??''}}">
                            </div>
                          </div>
                          <div class="form-group col-md-6 pb-2">
                            <label for="">Top Bar Menu</label>
                            <select name="topbar_meta[menu_id]" class="form-select">
                                @foreach(getMenus() as $menu)
                                <option value="{{$menu->id}}" {{(isset($data['topbar_meta']['menu_id']) && $data['topbar_meta']['menu_id']==$menu->id)?'selected':''}}>{{$menu->title}}</option>
                                @endforeach
                            </select>
                          </div>
                        </div>
                        <h4>Contact Information</h4>
                        <div class="row">
                          <div class="form-group col-md-3">
                            <label for="">Email</label>
                            <input name="contact_meta[email]" class="form-control" value="{{$data['contact_meta']['email']??''}}">
                          </div>
                          <div class="form-group col-md-3">
                            <label for="">Phone</label>
                            <input name="contact_meta[phone]" class="form-control" value="{{$data['contact_meta']['phone']??''}}">
                          </div>
                          <div class="form-group col-md-3">
                            <label for="">Website</label>
                            <input name="contact_meta[website]" class="form-control" value="{{$data['contact_meta']['website']??''}}">
                          </div>
                          <div class="form-group col-md-3">
                            <label for="">Address</label>
                            <textarea name="contact_meta[address]" class="form-control">{{$data['contact_meta']['address']??''}}</textarea>
                          </div>
                        </div>
                        <hr>
                        <h5>Contact Email <small>(Where the form goes. You can input multiple with comma seperated.)</small></h5>
                        <input name="contact_mails" class="form-control mb-4" value="{{$data['contact_mails']??''}}">
                        <h5>Thank You Message</h5>
                        <textarea name="contact_meta[thank_msg]" class="form-control">{{$data['contact_meta']['thank_msg']??''}}</textarea>
                      </div>
                      <div class="block-content tab-pane" id="search-t" role="tabpanel" aria-labelledby="search-t-tab" tabindex="0">
                        <h4 class="fw-semibold">Search Page</h4>
                        <div class="row">
                            <div class="form-group col-md-6 pb-2">
                                <label for="">Background</label>
                                <div class="input-group pull-left">
                                    <span class="input-group-btn">
                                        <a data-input="searchbg-img" class="btn btn-success image-placeholder"><i class="fa fa-picture-o"></i> Choose</a>
                                    </span>
                                    <input id="searchbg-img" class="form-control input-sm" type="text" name="search_meta[bg]" value="{{$data['search_meta']['bg']??''}}">
                                </div>
                            </div>
                            <div class="form-group col-md-6 pb-2">
                                <label for="">Advertise Image 1</label>
                                <div class="input-group pull-left">
                                    <span class="input-group-btn">
                                        <a data-input="searchad-img" class="btn btn-success image-placeholder"><i class="fa fa-picture-o"></i> Choose</a>
                                    </span>
                                    <input id="searchad-img" class="form-control input-sm" type="text" name="search_meta[ad_1]" value="{{$data['search_meta']['ad_1']??''}}">
                                </div>
                            </div>
                            <div class="form-group col-md-6 pb-2">
                                <label for="">Advertise Image 2</label>
                                <div class="input-group pull-left">
                                    <span class="input-group-btn">
                                        <a data-input="searchad2-img" class="btn btn-success image-placeholder"><i class="fa fa-picture-o"></i> Choose</a>
                                    </span>
                                    <input id="searchad2-img" class="form-control input-sm" type="text" name="search_meta[ad_2]" value="{{$data['search_meta']['ad_2']??''}}">
                                </div>
                            </div>
                            <div class="form-group col-md-6 pb-2">
                                <label for="">Advertise Image Link 1</label>
                                <input class="form-control input-sm" type="text" name="search_meta[ad_link_1]" value="{{$data['search_meta']['ad_link_1']??''}}">
                            </div>
                            <div class="form-group col-md-6 pb-2">
                                <label for="">Advertise Image Link 2</label>
                                <input class="form-control input-sm" type="text" name="search_meta[ad_link_2]" value="{{$data['search_meta']['ad_link_2']??''}}">
                            </div>
                            <div class="col-md-12"><hr></div>
                            <div class="form-group col-md-6 pb-2">
                                <label for="">Background Image 2</label>
                                <div class="input-group pull-left">
                                    <span class="input-group-btn">
                                        <a data-input="searchbg2-img" class="btn btn-success image-placeholder"><i class="fa fa-picture-o"></i> Choose</a>
                                    </span>
                                    <input id="searchbg2-img" class="form-control input-sm" type="text" name="search_meta[bg_2]" value="{{$data['search_meta']['bg_2']??''}}">
                                </div>
                            </div>
                            <div class="form-group col-md-6 pb-2">
                                <label for="">Heading</label>
                                <input class="form-control input-sm" type="text" name="search_meta[h1]" value="{{$data['search_meta']['h1']??''}}">
                            </div>
                            <div class="form-group col-md-6 pb-2">
                                <label for="">Paragraph</label>
                                <input class="form-control input-sm" type="text" name="search_meta[p]" value="{{$data['search_meta']['p']??''}}">
                            </div>
                            <div class="form-group col-md-6 pb-2">
                                <label for="">Button Text</label>
                                <input class="form-control input-sm" type="text" name="search_meta[btn_txt]" value="{{$data['search_meta']['btn_txt']??''}}">
                            </div>
                            <div class="form-group col-md-6 pb-2">
                                <label for="">Button Link</label>
                                <input class="form-control input-sm" type="text" name="search_meta[btn_link]" value="{{$data['search_meta']['btn_link']??''}}">
                            </div>
                        </div>
                        <hr/>
                        <h4 class="fw-semibold">Seo</h4>
                        <hr/>
                        <div class="block block-rounded mt-3">
                          <div class="block-content">
                            <div class="row justify-content-center">
                              <div class="col-md-12">
                                  <div class="mb-4">
                                      <label class="form-label" for="meta_title">Title</label>
                                      <input type="text" class="js-maxlength form-control" id="meta_title" name="search_meta[seo][meta_title]" data-always-show="true" data-placement="top" value="{{$data['search_meta']['seo']['meta_title']??''}}">
                                    </div>
                                    <div class="mb-3">
                                      <label class="form-label" for="meta_desc">Description</label>
                                      <textarea class="js-maxlength form-control" id="meta_desc" name="search_meta[seo][meta_desc]" rows="4" data-always-show="true" data-placement="top">{{$data['search_meta']['seo']['meta_desc']??''}}</textarea>
                                    </div>
                              </div>
                            </div>
                            <div class="row justify-content-center">
                              <div class="form-group col-md-4">
                                <div class="form-check form-switch form-check-inline">
                                  <input class="form-check-input seo-switch" data-type="og_tag" type="checkbox" id="og-tag" name="search_meta[seo][og_tag]" value="1" {{(isset($data['search_meta']['seo']['og_tag']) && $data['search_meta']['seo']['og_tag']=='1')?'checked':''}}>
                                  <label class="form-check-label" for="og-tag">og: Open Graph</label>
                                </div>
                              </div>
                              <div class="form-group col-md-4">
                                <div class="form-check form-switch form-check-inline">
                                  <input class="form-check-input seo-switch" data-type="twitter_tag" type="checkbox" id="twitter-tag" name="search_meta[seo][twitter_tag]" value="1" {{(isset($data['search_meta']['seo']['twitter_tag']) && $data['search_meta']['seo']['twitter_tag']=='1')?'checked':''}}>
                                  <label class="form-check-label" for="twitter-tag">Twitter Tags</label>
                                </div>
                              </div>
                              <div class="form-group col-md-4">
                                <div class="form-check form-switch form-check-inline">
                                  <input class="form-check-input seo-switch" data-type="schema" type="checkbox" id="schema-tag" name="search_meta[seo][is_schema]" value="1" {{(isset($data['search_meta']['seo']['is_schema']) && $data['search_meta']['seo']['is_schema']=='1')?'checked':''}}>
                                  <label class="form-check-label" for="schema-tag">Schema Code</label>
                                </div>
                              </div>
                              <div class="form-group col-md-4">
                                <div class="form-check form-switch form-check-inline">
                                  <input class="form-check-input seo-switch" data-type="tags" type="checkbox" id="meta-tags" name="search_meta[seo][is_tags]" value="1" {{(isset($data['search_meta']['seo']['is_tags']) && $data['search_meta']['seo']['is_tags']=='1')?'checked':''}}>
                                  <label class="form-check-label" for="meta-tags">Meta Keywords</label>
                                </div>
                              </div>
                              <div class="form-group col-md-4">
                                <div class="form-check form-switch form-check-inline">
                                  <input class="form-check-input seo-switch" data-type="scripts" type="checkbox" id="script_tags" name="search_meta[seo][script_tags]" value="1" {{(isset($data['search_meta']['seo']['script_tags']) && $data['search_meta']['seo']['script_tags']=='1')?'checked':''}}>
                                  <label class="form-check-label" for="script_tags">Custom Scripts</label>
                                </div>
                              </div>
                              <div class="form-group col-md-4">
                                <div class="form-check form-switch form-check-inline">
                                  <input class="form-check-input seo-switch" data-type="canonicals" type="checkbox" id="is_canonicals" name="search_meta[seo][is_canonicals]" value="1" {{(isset($data['search_meta']['seo']['is_canonicals']) && $data['search_meta']['seo']['is_canonicals']=='1')?'checked':''}}>
                                  <label class="form-check-label" for="is_canonicals">Link Canonicals</label>
                                </div>
                              </div>
                            </div>
                            <hr>
                            <div class="row mb-4" id="og_tag_div" @if(isset($data['search_meta']['seo']['og_tag'])) @if($data['search_meta']['seo']['og_tag'] == null) style="display:none;" @endif @else style="display:none;" @endif>
                              <hr>
                              <h5 style="padding-left: 20px;">OG TAGS</h5>
                              <hr>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="col-md-3 control-label">Title</label>
                                      <div class="col-md-12">
                                          <input type="text" class="form-control" name="search_meta[seo][og][title]" value="{{ ($data['search_meta']['seo']['og']['title'])??'' }}">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-md-3 control-label">URL</label>
                                      <div class="col-md-12">
                                          <input type="text" class="form-control" name="search_meta[seo][og][url]" value="{{ ($data['search_meta']['seo']['og']['url'])??'' }}">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-md-3 control-label">Type</label>
                                      <div class="col-md-12">
                                          <input type="text" class="form-control" name="search_meta[seo][og][type]" value="{{ ($data['search_meta']['seo']['og']['type'])??'' }}">
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="form-label">OG Image</label>
                                      <div class="input-group pull-left">
                                          <span class="input-group-btn">
                                              <a data-input="og-image" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
                                          </span>
                                          <input id="og-image" class="form-control input-sm" type="text" name="search_meta[seo][og][image]" value="{{ ($data['search_meta']['seo']['og']['image'])??'' }}">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-md-3 control-label">Description</label>
                                      <div class="col-md-12">
                                          <textarea class="form-control" name="search_meta[seo][og][description]">{{ ($data['search_meta']['seo']['og']['description'])??'' }}</textarea>
                                      </div>
                                  </div>
                              </div>
                            </div>
                            <div class="row mb-4" id="twitter_tag_div" @if(isset($data['search_meta']['seo']['twitter_tag'])) @if($data['search_meta']['seo']['twitter_tag'] == null) style="display:none;" @endif @else style="display:none;" @endif>
                              <hr>
                              <h5 style="padding-left: 20px;">Twitter Tag</h5>
                              <hr>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="col-md-3 control-label">Title</label>
                                      <div class="col-md-12">
                                          <input type="text" class="form-control" name="search_meta[seo][twitter][title]" value="{{ ($data['search_meta']['seo']['twitter']['title'])??'' }}">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-md-3 control-label">URL</label>
                                      <div class="col-md-12">
                                          <input type="text" class="form-control" name="search_meta[seo][twitter][url]" value="{{ ($data['search_meta']['seo']['twitter']['url'])??'' }}">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-md-3 control-label">Card</label>
                                      <div class="col-md-12">
                                          <input type="text" class="form-control" name="search_meta[seo][twitter][card]" value="{{ ($data['search_meta']['seo']['twitter']['card'])??'' }}">
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="form-label">Image</label>
                                      <div class="input-group pull-left">
                                          <span class="input-group-btn">
                                              <a data-input="twitter-image" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
                                          </span>
                                          <input id="twitter-image" class="form-control input-sm" type="text" name="search_meta[seo][twitter][image]" value="{{ ($data['search_meta']['seo']['twitter']['image'])??'' }}">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-md-3 control-label">Description</label>
                                      <div class="col-md-12">
                                          <textarea class="form-control" name="search_meta[seo][twitter][description]">{{ ($data['search_meta']['seo']['twitter']['description'])??'' }}</textarea>
                                      </div>
                                  </div>
                              </div>
                            </div>
                            <div class="row mb-4" id="schema_div" @if(isset($data['search_meta']['seo']['is_schema'])) @if($data['search_meta']['seo']['is_schema'] == null) style="display:none;" @endif @else style="display:none;" @endif">
                              <hr>
                              <h5 style="padding-left: 20px;">Schema Code</h5>
                              <hr>
                              <div class="col-md-12">
                                  <textarea name="search_meta[seo][schema_code]" class="form-control" cols="30" rows="10">{{ ($data['search_meta']['seo']['schema_code'])??'' }}</textarea>
                              </div>
                            </div>
                            <div class="row mb-4" id="tags_div" @if(isset($data['search_meta']['seo']['is_tags'])) @if($data['search_meta']['seo']['is_tags'] == null) style="display:none;" @endif @else style="display:none;" @endif">
                              <hr>
                              <h5 style="padding-left: 20px;">Meta Keywords</h5>
                              <hr>
                              <div class="col-md-12">
                                  <input type="text" class="form-control" data-role="tagsinput" name="search_meta[seo][meta_tags]" value="{{ ($data['search_meta']['seo']['meta_tags'])??'' }}">
                              </div>
                            </div>
                            <div class="row mb-4" id="scripts_div" @if(isset($data['search_meta']['seo']['script_tags'])) @if($data['search_meta']['seo']['script_tags'] == null) style="display:none;" @endif @else style="display:none;" @endif">
                              <hr>
                              <h5 style="padding-left: 20px;">Custom Scripts</h5>
                              <hr>
                              <div class="col-md-12">
                                <textarea name="search_meta[seo][scripts]" class="form-control" cols="30" rows="6">{{ ($data['search_meta']['seo']['scripts'])??'' }}</textarea>
                              </div>
                            </div>
                            <div class="row mb-4" id="canonicals_div" @if(isset($data['search_meta']['seo']['is_canonicals'])) @if($data['search_meta']['seo']['is_canonicals'] == null) style="display:none;" @endif @else style="display:none;" @endif">
                              <hr>
                              <h5 style="padding-left: 20px;">Link Canonicals</h5>
                              <hr>
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label class="col-xs-5 control-label">href</label>
                                  <div class="col-xs-12 link-can">
                                  @if(isset($data['search_meta']['seo']['canonical']) && is_array($data['search_meta']['seo']['canonical']) && count($data['search_meta']['seo']['canonical'])>0)
                                      @foreach($data['search_meta']['seo']['canonical'] as $cc=>$can)
                                      <div style="position:relative;margin-top:5px;">
                                          <input type="text" class="form-control" name="search_meta[seo][canonical][]" value="{{($can)??''}}">
                                          @if($cc==0)
                                          <button type="button" class="btn btn-sm btn-info add-canonical" style="position:absolute;top:0px;right:5px;">ADD</button>
                                          @else
                                          <button type="button" class="btn btn-xs btn-danger remove-canonical" style="position:absolute;top:0px;right:5px;"><i class="fa fa-times"></i></button>
                                          @endif
                                      </div>
                                      @endforeach
                                  @else
                                      <div style="position:relative;margin-top:5px;">
                                          <input type="text" class="form-control" name="search_meta[seo][canonical][]" value="">
                                          <button type="button" class="btn btn-sm btn-info add-canonical" style="position:absolute;top:0px;right:5px;">ADD</button>
                                      </div>
                                  @endif
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="block-content tab-pane" id="social-t" role="tabpanel" aria-labelledby="social-t-tab" tabindex="0">
                        <h4 class="fw-semibold">Social</h4>
                        <div class="row">
                          <div class="form-group col-md-6 pb-1">
                            <div class="input-group">
                              <span class="input-group-text">
                                <i class="fab fa-facebook-f"></i>
                              </span>
                              <input type="text" class="form-control" id="social-facebook" name="social_meta[facebook]" value="{{$data['social_meta']['facebook']??''}}">
                            </div>
                          </div>
                          <div class="form-group col-md-6 pb-1">
                            <div class="input-group">
                              <span class="input-group-text">
                                <i class="fab fa-twitter"></i>
                              </span>
                              <input type="text" class="form-control" id="social-twitter" name="social_meta[twitter]" value="{{$data['social_meta']['twitter']??''}}">
                            </div>
                          </div>
                          <div class="form-group col-md-6 pb-1">
                            <div class="input-group">
                              <span class="input-group-text">
                                <i class="fab fa-pinterest"></i>
                              </span>
                              <input type="text" class="form-control" id="social-pinterest" name="social_meta[pinterest]" value="{{$data['social_meta']['pinterest']??''}}">
                            </div>
                          </div>
                          <div class="form-group col-md-6 pb-1">
                            <div class="input-group">
                              <span class="input-group-text">
                                <i class="fab fa-youtube"></i>
                              </span>
                              <input type="text" class="form-control" id="social-youtube" name="social_meta[youtube]" value="{{$data['social_meta']['youtube']??''}}">
                            </div>
                          </div>
                          <div class="form-group col-md-6 pb-1">
                            <div class="input-group">
                              <span class="input-group-text">
                                <i class="fab fa-instagram"></i>
                              </span>
                              <input type="text" class="form-control" id="social-instagram" name="social_meta[instagram]" value="{{$data['social_meta']['instagram']??''}}">
                            </div>
                          </div>
                          <div class="form-group col-md-6 pb-1">
                            <div class="input-group">
                              <span class="input-group-text">
                                <i class="fab fa-tiktok"></i>
                              </span>
                              <input type="text" class="form-control" id="social-tiktok" name="social_meta[tiktok]" value="{{$data['social_meta']['tiktok']??''}}">
                            </div>
                          </div>
                          <div class="form-group col-md-6 pb-1">
                            <div class="input-group">
                              <span class="input-group-text">
                                <i class="fab fa-linkedin"></i>
                              </span>
                              <input type="text" class="form-control" id="social-linkedin" name="social_meta[linkedin]" value="{{$data['social_meta']['linkedin']??''}}">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="block-content tab-pane" id="header-t" role="tabpanel" aria-labelledby="header-t-tab" tabindex="0">
                        <h4 class="fw-semibold">Header</h4>
                        <div class="row">
                            <div class="form-group col-md-4 mb-2">
                                <input name="header_meta[h_heading]" class="form-control" value="{{$data['header_meta']['h_heading']??''}}" placeholder="Heading" />
                            </div>

                            <div class="form-group col-md-4">
                                <input name="header_meta[h_btn1_text]" class="form-control" value="{{$data['header_meta']['h_btn1_text']??''}}" placeholder="Button 1 Text" />
                            </div>

                            <div class="form-group col-md-4">
                                <input name="header_meta[h_btn1_link]" class="form-control" value="{{$data['header_meta']['h_btn1_link']??''}}" placeholder="Button 1 Link" />
                            </div>

                            <div class="form-group col-md-4">
                                <input name="header_meta[h_btn2_text]" class="form-control" value="{{$data['header_meta']['h_btn2_text']??''}}" placeholder="Button 2 Text" />
                            </div>

                            <div class="form-group col-md-4">
                                <input name="header_meta[h_btn2_link]" class="form-control" value="{{$data['header_meta']['h_btn2_link']??''}}" placeholder="Button 2 Link" />
                            </div>
                        </div>
                      </div>
                      <div class="block-content tab-pane" id="footer-t" role="tabpanel" aria-labelledby="footer-t-tab" tabindex="0">
                        <h4 class="fw-semibold">Footer</h4>
                        <div class="row">

                          <hr class="mb-2 mt-2">

                          <h4 class="fw-semibold">Menu</h4>

                          <div class="form-group col-md-4 mb-2">
                            <label for="">Heading 1</label>
                            <input name="footer_meta[heading_1]" class="form-control" value="{{$data['footer_meta']['heading_1']??''}}" placeholder="Heading 1" />
                          </div>

                          <div class="form-group col-md-4">
                            <label for="">Footer Menu 1</label>
                            <select name="footer_meta[menu_1]" class="form-select">
                                @foreach(getMenus() as $menu)
                                <option value="{{$menu->id}}" {{(isset($data['footer_meta']['menu_1']) && $data['footer_meta']['menu_1']==$menu->id)?'selected':''}}>{{$menu->title}}</option>
                                @endforeach
                            </select>
                          </div>

                          <div class="form-group col-md-4 mb-2">
                            <label for="">Heading 2</label>
                            <input name="footer_meta[heading_2]" class="form-control" value="{{$data['footer_meta']['heading_2']??''}}" placeholder="Heading 2" />
                          </div>

                          <div class="form-group col-md-4">
                            <label for="">Footer Menu 2</label>
                            <select name="footer_meta[menu_2]" class="form-select">
                                @foreach(getMenus() as $menu)
                                <option value="{{$menu->id}}" {{(isset($data['footer_meta']['menu_2']) && $data['footer_meta']['menu_2']==$menu->id)?'selected':''}}>{{$menu->title}}</option>
                                @endforeach
                            </select>
                          </div>

                          <hr class="mb-2 mt-2">

                          <h4 class="fw-semibold">Setting</h4>

                          <div class="form-group col-md-4 mb-2">
                            <label for="">Support Number</label>
                            <input name="footer_meta[support_number]" class="form-control" value="{{$data['footer_meta']['support_number']??''}}" placeholder="Support Number" />
                          </div>

                          <div class="form-group col-md-4 mb-2">
                            <label for="">Support Email</label>
                            <input name="footer_meta[support_email]" class="form-control" value="{{$data['footer_meta']['support_email']??''}}" placeholder="Support Email" />
                          </div>

                          <div class="form-group col-md-4">
                            <label for="">Logo</label>
                            <div class="input-group pull-left">
                              <span class="input-group-btn">
                                <a data-input="logo-img" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
                              </span>
                              <input id="logo-img" class="form-control input-sm" type="text" name="footer_meta[logo]" value="{{$data['footer_meta']['logo']??''}}">
                            </div>
                          </div>

                          <div class="form-group col-md-4 mb-2">
                            <label for="">Logo Alt Text</label>
                            <input name="footer_meta[logo_alt]" class="form-control" value="{{$data['footer_meta']['logo_alt']??''}}" placeholder="Logo Alt Text" />
                          </div>

                          <div class="form-group col-md-4 mb-2">
                            <label for="">Footer Heading</label>
                            <input name="footer_meta[fheading]" class="form-control" value="{{$data['footer_meta']['fheading']??''}}" placeholder="Footer Heading" />
                          </div>

                          <div class="form-group col-md-4 mb-2">
                            <label for="">Footer Text</label>
                            <input name="footer_meta[ftext]" class="form-control" value="{{$data['footer_meta']['ftext']??''}}" placeholder="Footer Text" />
                          </div>

                          <div class="form-group col-md-4 mb-2">
                            <label for="">Footer Rating</label>
                            <input name="footer_meta[frating]" class="form-control" value="{{$data['footer_meta']['frating']??''}}" placeholder="Footer Rating" />
                          </div>

                          <div class="form-group col-md-4 mb-2">
                            <label for="">Footer Rating Text</label>
                            <input name="footer_meta[fratetext]" class="form-control" value="{{$data['footer_meta']['fratetext']??''}}" placeholder="Footer Rating Text" />
                          </div>

                          <hr class="mb-2 mt-2">

                          <h4 class="fw-semibold">App</h4>

                          <div class="form-group col-md-4">
                            <label for="">App Icon 1</label>
                            <div class="input-group pull-left">
                              <span class="input-group-btn">
                                <a data-input="icon1-img" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
                              </span>
                              <input id="icon1-img" class="form-control input-sm" type="text" name="footer_meta[icon_1]" value="{{$data['footer_meta']['icon_1']??''}}">
                            </div>
                          </div>

                          <div class="form-group col-md-4 mb-2">
                            <label for="">App Icon 1 Alt Text</label>
                            <input name="footer_meta[icon1_alt]" class="form-control" value="{{$data['footer_meta']['icon1_alt']??''}}" placeholder="App Icon 1 Alt Text" />
                          </div>

                          <div class="form-group col-md-4 mb-2">
                            <label for="">App Icon 1 Link</label>
                            <input name="footer_meta[icon1_link]" class="form-control" value="{{$data['footer_meta']['icon1_link']??''}}" placeholder="App Icon 1 Link" />
                          </div>

                          <div class="form-group col-md-4">
                            <label for="">App Icon 2</label>
                            <div class="input-group pull-left">
                              <span class="input-group-btn">
                                <a data-input="icon2-img" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
                              </span>
                              <input id="icon2-img" class="form-control input-sm" type="text" name="footer_meta[icon_2]" value="{{$data['footer_meta']['icon_2']??''}}">
                            </div>
                          </div>

                          <div class="form-group col-md-4 mb-2">
                            <label for="">App Icon 2 Alt Text</label>
                            <input name="footer_meta[icon2_alt]" class="form-control" value="{{$data['footer_meta']['icon2_alt']??''}}" placeholder="App Icon 2 Alt Text" />
                          </div>

                          <div class="form-group col-md-4 mb-2">
                            <label for="">App Icon 2 Link</label>
                            <input name="footer_meta[icon2_link]" class="form-control" value="{{$data['footer_meta']['icon2_link']??''}}" placeholder="App Icon 2 Link" />
                          </div>

                          <hr class="mb-2 mt-2">

                          <h4 class="fw-semibold">Newsletter</h4>

                          <div class="form-group col-md-4 mb-2">
                            <label for="">Heading</label>
                            <input name="footer_meta[newsletter][heading_1]" class="form-control" value="{{$data['footer_meta']['newsletter']['heading_1']??''}}" placeholder="Heading" />
                          </div>

                          <div class="form-group col-md-4 mb-2">
                            <label for="">Text</label>
                            <input name="footer_meta[newsletter][text]" class="form-control" value="{{$data['footer_meta']['newsletter']['text']??''}}" placeholder="Text" />
                          </div>

                          <div class="form-group col-md-4 mb-2">
                            <label for="">Button Text</label>
                            <input name="footer_meta[newsletter][btn_txt]" class="form-control" value="{{$data['footer_meta']['newsletter']['btn_txt']??''}}" placeholder="Button Text" />
                          </div>

                          <div class="form-group col-md-4 mb-2">
                            <label for="">Button Link</label>
                            <input name="footer_meta[newsletter][btn_link]" class="form-control" value="{{$data['footer_meta']['newsletter']['btn_link']??''}}" placeholder="Button Link" />
                          </div>
                          
                          
                          {{-- <div class="form-group col-md-4">
                            <label for="">Newsletter</label>
                            <textarea name="footer_meta[nl_text]" class="form-control">{{$data['footer_meta']['nl_text']??''}}</textarea>
                          </div> --}}
                        </div>
                      </div>
                      <div class="block-content tab-pane" id="sidebar-t" role="tabpanel" aria-labelledby="sidebar-t-tab" tabindex="0">
                        <h4 class="fw-semibold">Sidebar</h4>
                        <div class="row">
                          <h5>News Sidebar</h5>
                          <div class="form-check form-switch col-md-3">
                              <input class="form-check-input" type="checkbox" id="news_sidebar" name="sidebar_meta[on_news]" value="1" {{(isset($data['sidebar_meta']['on_news']) && $data['sidebar_meta']['on_news']==1)?'checked':''}}>
                              <label class="form-check-label" for="news_sidebar">Show Sidebar</label>
                          </div>
                          <div class="form-group col-md-4">
                              <label for="">Sidebar Position</label>
                              <select name="sidebar_meta[news][sidebar_position]" class="form-select">
                                  <option value="right" {{(isset($data['sidebar_meta']['news']['sidebar_position']) && $data['sidebar_meta']['news']['sidebar_position']=='right')?'selected':''}}>Right</option>
                                  <option value="left" {{(isset($data['sidebar_meta']['news']['sidebar_position']) && $data['sidebar_meta']['news']['sidebar_position']=='left')?'selected':''}}>Left</option>
                              </select>
                          </div>
                          <div class="form-group col-md-4">
                              <label for="">Sidebar Menu</label>
                              <select name="sidebar_meta[news][sidebar_menu]" class="form-select">
                                  @foreach(getMenus() as $menu)
                                  <option value="{{$menu->id}}" {{(isset($data['sidebar_meta']['news']['sidebar_menu']) && $data['sidebar_meta']['news']['sidebar_menu']==$menu->id)?'selected':''}}>{{$menu->title}}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                      <hr>
                        <div class="row">
                          <h5>Blogs Sidebar</h5>
                          <div class="form-check form-switch col-md-3">
                              <input class="form-check-input" type="checkbox" id="blogs_sidebar" name="sidebar_meta[on_blogs]" value="1" {{(isset($data['sidebar_meta']['on_blogs']) && $data['sidebar_meta']['on_blogs']==1)?'checked':''}}>
                              <label class="form-check-label" for="blogs_sidebar">Show Sidebar</label>
                          </div>
                          <div class="form-group col-md-4">
                              <label for="">Sidebar Position</label>
                              <select name="sidebar_meta[blogs][sidebar_position]" class="form-select">
                                  <option value="right" {{(isset($data['sidebar_meta']['blogs']['sidebar_position']) && $data['sidebar_meta']['blogs']['sidebar_position']=='right')?'selected':''}}>Right</option>
                                  <option value="left" {{(isset($data['sidebar_meta']['blogs']['sidebar_position']) && $data['sidebar_meta']['blogs']['sidebar_position']=='left')?'selected':''}}>Left</option>
                              </select>
                          </div>
                          <div class="form-group col-md-4">
                              <label for="">Sidebar Menu</label>
                              <select name="sidebar_meta[blogs][sidebar_menu]" class="form-select">
                                  @foreach(getMenus() as $menu)
                                  <option value="{{$menu->id}}" {{(isset($data['sidebar_meta']['blogs']['sidebar_menu']) && $data['sidebar_meta']['blogs']['sidebar_menu']==$menu->id)?'selected':''}}>{{$menu->title}}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                      <hr>
                        <div class="row">
                          <h5>Events Sidebar</h5>
                          <div class="form-check form-switch col-md-3">
                              <input class="form-check-input" type="checkbox" id="events_sidebar" name="sidebar_meta[on_events]" value="1" {{(isset($data['sidebar_meta']['on_events']) && $data['sidebar_meta']['on_events']==1)?'checked':''}}>
                              <label class="form-check-label" for="events_sidebar">Show Sidebar</label>
                          </div>
                          <div class="form-group col-md-4">
                              <label for="">Sidebar Position</label>
                              <select name="sidebar_meta[events][sidebar_position]" class="form-select">
                                  <option value="right" {{(isset($data['sidebar_meta']['events']['sidebar_position']) && $data['sidebar_meta']['events']['sidebar_position']=='right')?'selected':''}}>Right</option>
                                  <option value="left" {{(isset($data['sidebar_meta']['events']['sidebar_position']) && $data['sidebar_meta']['events']['sidebar_position']=='left')?'selected':''}}>Left</option>
                              </select>
                          </div>
                          <div class="form-group col-md-4">
                              <label for="">Sidebar Menu</label>
                              <select name="sidebar_meta[events][sidebar_menu]" class="form-select">
                                  @foreach(getMenus() as $menu)
                                  <option value="{{$menu->id}}" {{(isset($data['sidebar_meta']['events']['sidebar_menu']) && $data['sidebar_meta']['events']['sidebar_menu']==$menu->id)?'selected':''}}>{{$menu->title}}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                      <hr>
                        <div class="row">
                          <h5>Services Sidebar</h5>
                          <div class="form-check form-switch col-md-3">
                              <input class="form-check-input" type="checkbox" id="service_sidebar" name="sidebar_meta[on_service]" value="1" {{(isset($data['sidebar_meta']['on_service']) && $data['sidebar_meta']['on_service']==1)?'checked':''}}>
                              <label class="form-check-label" for="service_sidebar">Show Sidebar</label>
                          </div>
                          <div class="form-group col-md-4">
                              <label for="">Sidebar Position</label>
                              <select name="sidebar_meta[service][sidebar_position]" class="form-select">
                                  <option value="right" {{(isset($data['sidebar_meta']['service']['sidebar_position']) && $data['sidebar_meta']['service']['sidebar_position']=='right')?'selected':''}}>Right</option>
                                  <option value="left" {{(isset($data['sidebar_meta']['service']['sidebar_position']) && $data['sidebar_meta']['service']['sidebar_position']=='left')?'selected':''}}>Left</option>
                              </select>
                          </div>
                          <div class="form-group col-md-4">
                              <label for="">Sidebar Menu</label>
                              <select name="sidebar_meta[service][sidebar_menu]" class="form-select">
                                  @foreach(getMenus() as $menu)
                                  <option value="{{$menu->id}}" {{(isset($data['sidebar_meta']['service']['sidebar_menu']) && $data['sidebar_meta']['service']['sidebar_menu']==$menu->id)?'selected':''}}>{{$menu->title}}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                      <hr>
                        <div class="row">
                          <h5>Albums Sidebar</h5>
                          <div class="form-check form-switch col-md-3">
                              <input class="form-check-input" type="checkbox" id="albums_sidebar" name="sidebar_meta[on_albums]" value="1" {{(isset($data['sidebar_meta']['on_albums']) && $data['sidebar_meta']['on_albums']==1)?'checked':''}}>
                              <label class="form-check-label" for="albums_sidebar">Show Sidebar</label>
                          </div>
                          <div class="form-group col-md-4">
                              <label for="">Sidebar Position</label>
                              <select name="sidebar_meta[albums][sidebar_position]" class="form-select">
                                  <option value="right" {{(isset($data['sidebar_meta']['albums']['sidebar_position']) && $data['sidebar_meta']['albums']['sidebar_position']=='right')?'selected':''}}>Right</option>
                                  <option value="left" {{(isset($data['sidebar_meta']['albums']['sidebar_position']) && $data['sidebar_meta']['albums']['sidebar_position']=='left')?'selected':''}}>Left</option>
                              </select>
                          </div>
                          <div class="form-group col-md-4">
                              <label for="">Sidebar Menu</label>
                              <select name="sidebar_meta[albums][sidebar_menu]" class="form-select">
                                  @foreach(getMenus() as $menu)
                                  <option value="{{$menu->id}}" {{(isset($data['sidebar_meta']['albums']['sidebar_menu']) && $data['sidebar_meta']['albums']['sidebar_menu']==$menu->id)?'selected':''}}>{{$menu->title}}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                      <hr>
                      </div>
                      <div class="block-content tab-pane" id="seo-t" role="tabpanel" aria-labelledby="seo-t-tab" tabindex="0">
                        <h4 class="fw-semibold">SEO Related</h4>
                        <div class="row">
                          <div class="col-md-12">
                            <h5>Google Analytics</h5>
                            <div class="form-group">
                              <label for="">Tracking code</label>
                              <input name="tracking_code" class="form-control" value="{{$data['tracking_code']??''}}">
                            </div>
                            <h5 class="mt-3">Robots.txt</h5>
                            <div class="form-group">
                              <label for="">robot.txt</label>
                              <textarea type="text" class="form-control" name="robot" rows="15">{!! $data['robot']??'' !!}</textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="block-content tab-pane" id="s-modal" role="tabpanel" aria-labelledby="s-modal-tab" tabindex="0">
                        <h4 class="fw-semibold">Start Up Modal</h4>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-check form-switch col-md-3">
                              <input class="form-check-input" type="checkbox" id="show_smodal" name="startup_meta[show]" value="1" {{(isset($data['startup_meta']['show']) && $data['startup_meta']['show']==1)?'checked':''}}>
                              <label class="form-check-label" for="show_smodal">Active</label>
                          </div>
                          </div>
                            <div class="form-group col-md-6 pb-2">
                                <label for="">Top Image</label>
                                <div class="input-group pull-left">
                                    <span class="input-group-btn">
                                        <a data-input="top_image-img" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
                                    </span>
                                    <input id="top_image-img" class="form-control input-sm" type="text" name="startup_meta[top_image]" value="{{$data['startup_meta']['top_image']??''}}">
                                </div>
                            </div>

                            <div class="form-group col-md-6 pb-2">
                                <label for="">Top Image Alt</label>
                                <input name="startup_meta[top_image_alt]" class="form-control" value="{{$data['startup_meta']['top_image_alt']??''}}">
                            </div>

                            <div class="form-group col-md-6 pb-2">
                                <label for="">Image</label>
                                <div class="input-group pull-left">
                                    <span class="input-group-btn">
                                        <a data-input="image-img" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
                                    </span>
                                    <input id="image-img" class="form-control input-sm" type="text" name="startup_meta[image]" value="{{$data['startup_meta']['image']??''}}">
                                </div>
                            </div>

                            <div class="form-group col-md-6 pb-2">
                                <label for="">Image Alt</label>
                                <input name="startup_meta[image_alt]" class="form-control" value="{{$data['startup_meta']['image_alt']??''}}">
                            </div>

                            <div class="form-group col-md-6 pb-2">
                                <label for="">Heading 1</label>
                                <input name="startup_meta[heading_1]" class="form-control" value="{{$data['startup_meta']['heading_1']??''}}">
                            </div>

                            <div class="form-group col-md-6 pb-2">
                                <label for="">Heading 2</label>
                                <input name="startup_meta[heading_2]" class="form-control" value="{{$data['startup_meta']['heading_2']??''}}">
                            </div>

                            <div class="form-group col-md-6 pb-2">
                                <label for="">Text</label>
                                <input name="startup_meta[text]" class="form-control" value="{{$data['startup_meta']['text']??''}}">
                            </div>

                            <div class="form-group col-md-6 pb-2">
                                <label for="">Privacy Text</label>
                                <input name="startup_meta[privacy_text]" class="form-control" value="{{$data['startup_meta']['privacy_text']??''}}">
                            </div>

                            <div class="form-group col-md-6 pb-2">
                                <label for="">Privacy Link Text</label>
                                <input name="startup_meta[privacy_link_text]" class="form-control" value="{{$data['startup_meta']['privacy_link_text']??''}}">
                            </div>

                            <div class="form-group col-md-6 pb-2">
                                <label for="">Privacy Link</label>
                                <input name="startup_meta[privacy_link]" class="form-control" value="{{$data['startup_meta']['privacy_link']??''}}">
                            </div>

                            <div class="form-group col-md-6 pb-2">
                                <label for="">Button 1 Text</label>
                                <input name="startup_meta[btn_1_text]" class="form-control" value="{{$data['startup_meta']['btn_1_text']??''}}">
                            </div>

                            <div class="form-group col-md-6 pb-2">
                                <label for="">Button 1 Link</label>
                                <input name="startup_meta[btn_1_link]" class="form-control" value="{{$data['startup_meta']['btn_1_link']??''}}">
                            </div>

                            <div class="form-group col-md-6 pb-2">
                                <label for="">Button 2 Text</label>
                                <input name="startup_meta[btn_2_text]" class="form-control" value="{{$data['startup_meta']['btn_2_text']??''}}">
                            </div>

                            <div class="form-group col-md-6 pb-2">
                                <label for="">Button 2 Link</label>
                                <input name="startup_meta[btn_2_link]" class="form-control" value="{{$data['startup_meta']['btn_2_link']??''}}">
                            </div>
                        </div>
                      </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('customScripts')
<script src="{{asset('/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
<script src="{{asset('assets_backend/js/bootstrap-tagsinput.min.js')}}"></script>
<script>
  $('.image-placeholder').filemanager('image');
  $('.seo-switch').click(function(){
      if($(this).is(':checked')) {
        $("#"+$(this).data('type')+'_div').show(300);
      } else {
        $("#"+$(this).data('type')+'_div').hide(300);
      }
    });
    $('.add-canonical').on('click',function(){
        var html = `<div style="position:relative;margin-top:5px;"><input type="text" class="form-control" name="search_meta[seo][canonical][]">
                    <button type="button" class="btn btn-xs btn-danger remove-canonical" style="position:absolute;top:0px;right:5px;"><i class="fa fa-times"></i></button></div>`;
        $(this).parents('.link-can').append(html);
    });
    $(document).on('click', '.remove-canonical', function(){
        $(this).parent().remove();
    });
</script>
@endsection
