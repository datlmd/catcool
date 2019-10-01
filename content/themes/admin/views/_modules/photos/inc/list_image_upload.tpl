{if !empty($uploads)}
    {foreach $uploads as $item}
        <li id="photo_key_{$item.key_id}" class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12 mb-3">
            {if $item.status eq 'ng'}
                <div class="text-danger">
                    <b>{$item.file}</b><br/>
                    {$item.msg}
                </div>
            {else}
                <a href="{image_url($item.image)}" data-lightbox="photos">
                    <img src="" style="background-image: url('{image_url($item.image)}');" class="img-thumbnail img-fluid img-photo-list">
                </a>
                <div class="btn btn-xs btn-danger top_right" data-photo_key="{$item.key_id}" onclick="Photo.delete_div_photo(this);"><i class="far fa-trash-alt"></i></div>
                <div class="mt-2">
                    <input type="hidden" name="photo_url[{$item.key_id}]" value="{$item.image}" class="form-control">
                    <input type="text" name="{$item.key_id}" placeholder="{lang('photo_title_hover')}" class="form-control">
                </div>
            {/if}
        </li>
    {/foreach}
{/if}