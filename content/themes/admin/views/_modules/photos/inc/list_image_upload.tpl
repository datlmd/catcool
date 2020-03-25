{if !empty($uploads)}
    {foreach $uploads as $item}
        <li id="photo_key_{$item.key_id}" {if $is_multi}class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12 mb-3"{/if}>
            {if $item.status eq 'ng'}
                <div class="text-danger">
                    <b>{$item.file}</b><br/>
                    {$item.msg}
                </div>
            {else}
                {* multi su dung cho album, nguoc lai photo*}
                {if $is_multi}
                    <a href="{image_url($item.image)}" data-lightbox="photos">
                        <img src="" style="background-image: url('{image_url($item.image)}');" class="img-fluid img-thumbnail img-photo-list">
                    </a>
                    <div class="btn btn-xs btn-danger top_right" data-photo_key="{$item.key_id}" onclick="Photo.delete_div_photo(this);"><i class="fas fa-trash-alt"></i></div>
                {else}
                    <a href="{image_url($item.image)}" data-lightbox="photos">
                        <img src="{image_url($item.image)}" class="img-fluid">
                    </a>
                {/if}
                <input type="hidden" name="photo_url[{$item.key_id}]" value="{$item.image}" class="form-control">
            {/if}
        </li>
    {/foreach}
{/if}