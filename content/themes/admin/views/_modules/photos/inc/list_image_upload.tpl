{if !empty($uploads)}
    {foreach $uploads as $item}
        <div id="photo_key_{$item.key_id}" class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12 mb-3">
            <a href="{image_url($item.image)}" data-lightbox="photos" class="col-12 col-sm-3 col-form-label text-sm-right">
                <img src="" style="background-image: url('{image_url($item.image)}');" class="img-thumbnail img-fluid img-photo-list">
            </a><br />
            <div class="btn btn-sm btn-danger" data-photo_key="{$item.key_id}" onclick="Photo.delete_div_photo(this);" style="position: absolute; top: 30px; right: 22px;"><i class="far fa-trash-alt"></i></div>
            {if $item.status eq 'ng'}
                {$item.msg}<br/>
                {$item.file}
            {else}
                <input type="hidden" name="photo_url[{$item.key_id}]" value="{$item.image}" class="form-control">
                <input type="text" name="{$item.key_id}" placeholder="{lang('photo_title_hover')}" class="form-control">
            {/if}
        </div>
    {/foreach}
{/if}