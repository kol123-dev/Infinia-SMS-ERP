@php
    $short_codes = $certificate_type->short_code;
    $short_codes = json_decode($short_codes);
@endphp
<div class="studenttags" style="">
    @foreach ($short_codes as $short_code)
        <a data-value=" {<?php echo $short_code; ?>} " class="btn btn-light btn-xs btn_tag mb-1">{<?php echo $short_code; ?>}
        </a>
    @endforeach
</div>
