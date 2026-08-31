<form id="seoForm" method="POST">
  @csrf
  <input type="hidden" id="advertise_id" name="advertise_id">
  
  <!-- Meta Title & Description -->
  <div class="row mb-4">
    <div class="col-md-6">
      <div class="form-group">
        <label class="form-label">Meta Title</label>
        <input type="text" class="form-control" id="meta_title" name="meta_title" maxlength="60" value="{{ $advertise->meta_title ?? $advertise->title ?? '' }}">
        <div class="form-text">60 characters max</div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label class="form-label">Meta Description</label>
        <textarea class="form-control" id="meta_description" name="meta_description" rows="3" maxlength="160">{{ $advertise->meta_description ?? $advertise->description ?? '' }}</textarea>
        <div class="form-text">160 characters max</div>
      </div>
    </div>
  </div>

  <!-- SEO Switches -->
  <div class="row mb-4">
    <div class="col-md-2">
      <div class="form-check form-switch">
        <input class="form-check-input seo-switch" data-type="og_tag" type="checkbox" id="og-tag" name="seo_meta[og_tag]" value="1" {{ (isset($advertise->seo_meta['og_tag']) && $advertise->seo_meta['og_tag']) || empty($advertise->seo_meta) ? 'checked' : '' }}>
        <label class="form-check-label" for="og-tag">Open Graph Tags</label>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-check form-switch">
        <input class="form-check-input seo-switch" data-type="twitter_tag" type="checkbox" id="twitter-tag" name="seo_meta[twitter_tag]" value="1" {{ (isset($advertise->seo_meta['twitter_tag']) && $advertise->seo_meta['twitter_tag']) || empty($advertise->seo_meta) ? 'checked' : '' }}>
        <label class="form-check-label" for="twitter-tag">Twitter Tags</label>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-check form-switch">
        <input class="form-check-input seo-switch" data-type="schema" type="checkbox" id="schema-tag" name="seo_meta[is_schema]" value="1" {{ (isset($advertise->seo_meta['is_schema']) && $advertise->seo_meta['is_schema']) || empty($advertise->seo_meta) ? 'checked' : '' }}>
        <label class="form-check-label" for="schema-tag">Schema Code</label>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-check form-switch">
        <input class="form-check-input seo-switch" data-type="tags" type="checkbox" id="meta-tags" name="seo_meta[is_tags]" value="1" {{ (isset($advertise->seo_meta['is_tags']) && $advertise->seo_meta['is_tags']) || empty($advertise->seo_meta) ? 'checked' : '' }}>
        <label class="form-check-label" for="meta-tags">Meta Keywords</label>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-check form-switch">
        <input class="form-check-input seo-switch" data-type="canonicals" type="checkbox" id="is_canonicals" name="seo_meta[is_canonicals]" value="1" {{ (isset($advertise->seo_meta['is_canonicals']) && $advertise->seo_meta['is_canonicals']) || empty($advertise->seo_meta) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_canonicals">Link Canonicals</label>
      </div>
    </div>
  </div>

  <!-- Open Graph Tags -->
  <div class="row mb-4" id="og_tag_div" style="display:{{ (isset($advertise->seo_meta['og_tag']) && $advertise->seo_meta['og_tag']) || empty($advertise->seo_meta) ? 'block' : 'none' }};">
    <hr>
    <h5>Open Graph Tags</h5>
    <hr>
    <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label class="form-label">OG Title</label>
            <input type="text" class="form-control" name="seo_meta[og][title]" id="og_title" value="{{ $advertise->seo_meta['og']['title'] ?? $advertise->title ?? '' }}">
          </div>
          <div class="form-group">
            <label class="form-label">OG URL</label>
            <input type="text" class="form-control" name="seo_meta[og][url]" id="og_url" value="{{ $advertise->seo_meta['og']['url'] ?? $adUrl ?? '' }}">
          </div>
          <div class="form-group">
            <label class="form-label">OG Type</label>
            <input type="text" class="form-control" name="seo_meta[og][type]" id="og_type" value="{{ $advertise->seo_meta['og']['type'] ?? 'website' }}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="form-label">OG Image</label>
            <div class="input-group">
              <span class="input-group-btn">
                <a data-input="og-image" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
              </span>
              <input id="og-image" class="form-control input-sm" type="text" name="seo_meta[og][image]" id="og_image" value="{{ $advertise->seo_meta['og']['image'] ?? $adImage ?? '' }}">
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">OG Description</label>
            <textarea class="form-control" name="seo_meta[og][description]" id="og_description" rows="3">{{ $advertise->seo_meta['og']['description'] ?? $advertise->description ?? '' }}</textarea>
          </div>
        </div>

    </div>
  </div>

  <!-- Twitter Tags -->
  <div class="row mb-4" id="twitter_tag_div" style="display:{{ (isset($advertise->seo_meta['twitter_tag']) && $advertise->seo_meta['twitter_tag']) || empty($advertise->seo_meta) ? 'block' : 'none' }};">
    <hr>
    <h5>Twitter Tags</h5>
    <hr>
    <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label class="form-label">Twitter Title</label>
            <input type="text" class="form-control" name="seo_meta[twitter][title]" id="twitter_title" value="{{ $advertise->seo_meta['twitter']['title'] ?? $advertise->title ?? '' }}">
          </div>
          <div class="form-group">
            <label class="form-label">Twitter URL</label>
            <input type="text" class="form-control" name="seo_meta[twitter][url]" id="twitter_url" value="{{ $advertise->seo_meta['twitter']['url'] ?? $adUrl ?? '' }}">
          </div>
          <div class="form-group">
            <label class="form-label">Twitter Card</label>
            <input type="text" class="form-control" name="seo_meta[twitter][card]" id="twitter_card" value="{{ $advertise->seo_meta['twitter']['card'] ?? 'summary' }}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="form-label">Twitter Image</label>
            <div class="input-group">
              <span class="input-group-btn">
                <a data-input="twitter-image" class="btn btn-success image-placeholder" style="padding:4px 10px;"><i class="fa fa-picture-o"></i> Choose</a>
              </span>
              <input id="twitter-image" class="form-control input-sm" type="text" name="seo_meta[twitter][image]" id="twitter_image" value="{{ $advertise->seo_meta['twitter']['image'] ?? $adImage ?? '' }}">
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Twitter Description</label>
            <textarea class="form-control" name="seo_meta[twitter][description]" id="twitter_description" rows="3">{{ $advertise->seo_meta['twitter']['description'] ?? $advertise->description ?? '' }}</textarea>
          </div>
        </div>
        
    </div>
  </div>

  <!-- Schema Code -->
  <div class="row mb-4" id="schema_div" style="display:{{ (isset($advertise->seo_meta['is_schema']) && $advertise->seo_meta['is_schema']) || empty($advertise->seo_meta) ? 'block' : 'none' }};">
    <hr>
    <h5>Schema Code</h5>
    <hr>
    <div class="col-md-12">
      <textarea name="schema_code" id="schema_code" class="form-control" rows="10" placeholder="Enter your JSON-LD schema code here...">{{ $advertise->schema_code ?? $generatedSchema ?? '' }}</textarea>
    </div>
  </div>

  <!-- Meta Keywords -->
  <div class="row mb-4" id="tags_div" style="display:{{ (isset($advertise->seo_meta['is_tags']) && $advertise->seo_meta['is_tags']) || empty($advertise->seo_meta) ? 'block' : 'none' }};">
    <hr>
    <h5>Meta Keywords</h5>
    <hr>
    <div class="col-md-12">
      <input type="text" class="form-control" data-role="tagsinput" name="seo_meta[meta_tags]" id="meta_tags" placeholder="Enter keywords separated by commas..." value="{{ $advertise->seo_meta['meta_tags'] ?? '' }}">
    </div>
  </div>

  <!-- Link Canonicals -->
  <div class="row mb-4" id="canonicals_div" style="display:{{ (isset($advertise->seo_meta['is_canonicals']) && $advertise->seo_meta['is_canonicals']) || empty($advertise->seo_meta) ? 'block' : 'none' }};">
    <hr>
    <h5>Link Canonicals</h5>
    <hr>
    <div class="col-md-12">
      <div class="form-group">
        <label class="col-xs-5 control-label">href</label>
        <div class="col-xs-12 link-can">
          @if(isset($advertise->seo_meta['canonical']) && is_array($advertise->seo_meta['canonical']) && count($advertise->seo_meta['canonical']) > 0)
            @foreach($advertise->seo_meta['canonical'] as $cc => $can)
              <div style="position:relative;margin-top:5px;">
                <input type="text" class="form-control" name="seo_meta[canonical][]" id="canonical_{{ $cc }}" value="{{ $can ?? '' }}">
                @if($cc == 0)
                  <button type="button" class="btn btn-sm btn-info add-canonical" style="position:absolute;top:0px;right:5px;">ADD</button>
                @else
                  <button type="button" class="btn btn-xs btn-danger remove-canonical" style="position:absolute;top:0px;right:5px;"><i class="fa fa-times"></i></button>
                @endif
              </div>
            @endforeach
          @else
            <div style="position:relative;margin-top:5px;">
              <input type="text" class="form-control" name="seo_meta[canonical][]" id="canonical_0" value="{{ $adUrl ?? '' }}">
              <button type="button" class="btn btn-sm btn-info add-canonical" style="position:absolute;top:0px;right:5px;">ADD</button>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="form-group text-center mb-2">
    <button type="submit" class="btn btn-primary">
      <i class="fa fa-save"></i> Update SEO
    </button>
  </div>
</form> 