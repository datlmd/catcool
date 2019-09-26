{if !empty($uploads)}
    {foreach $uploads as $item}
        <div class="form-group row">
            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                <a href="{image_url($item.image)}" data-lightbox="photos"><img src="{image_url($item.image)}" class="img-thumbnail mr-1 img-fluid"></a>
            </label>
            <div class="col-12 col-sm-8 col-lg-6">
                dfgdfg
            </div>
        </div>
    {/foreach}
{/if}