{if !empty($uploads)}
    {foreach $uploads as $item}
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <a href="{image_url($item.image)}" data-lightbox="photos" class="col-12 col-sm-3 col-form-label text-sm-right">
                <img src="{image_url($item.image)}" class="img-thumbnail mr-1 img-fluid">
            </a><br />
            <div class="btn btn-sm btn-danger" style="position: absolute; top: 0; right: 0;"><i class="far fa-trash-alt"></i></div>
            {if $item.status eq 'ng'}
                {$item.msg}<br/>
                {$item.file}
            {else}
                <input type="hidden" name="photo_url[{$item.key_id}]" value="{$item.image}" class="form-control">
                <input type="text" name="{$item.key_id}" placeholder="{lang('photo_title_hover')}" class="form-control" style="margin: 10px 0 0 10px;">
            {/if}
        </div>
    {/foreach}
{/if}