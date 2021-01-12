<div class="blog-posts single-post mt-4 ">
    <article class="post post-large blog-single-post border-0 m-0 p-0">
        <div class="post-content ml-0">
            <h2 class="font-weight-bold">{$detail.name|unescape:"html"}</h2>
            <div class="post-meta">
                <span><i class="far fa-user"></i> RSS: <a href="{$detail.source}" target="_blank" title="{$detail.source}">{$detail.source|truncate:70:"...":true}</a> </span>
{*                {if !empty($detail.tags)}*}
{*                    <span>*}
{*                        <i class="far fa-folder"></i>*}
{*                        {foreach explode(',', $detail.tags) as $tag}*}
{*                            <a href="{base_url()}tags/{$tag}">{$tag}</a>*}
{*                        {/foreach}*}
{*                    </span>*}
{*                {/if}*}
{*                    <span><i class="far fa-comments"></i> <a href="#">12 Comments</a></span>*}
            </div>
            <div>
                {$detail.content|unescape:"html"}
            </div>

            <div class="post-block mt-5 post-share">
                <!-- AddThis Button BEGIN -->
                <div class="addthis_toolbox addthis_default_style ">
                    <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                    <a class="addthis_button_tweet"></a>
                    <a class="addthis_button_pinterest_pinit"></a>
                    <a class="addthis_counter addthis_pill_style"></a>
                </div>
                <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-50faf75173aadc53"></script>
                <!-- AddThis Button END -->
            </div>

            {include file=get_theme_path('views/_modules/news/inc/list_tags.tpl') tags=explode(',', $detail.tags)}

            {foreach $news_category_list as $news}
                {if $news@iteration > 6}
                    {break}
                {/if}
                {if $news.news_id eq $detail.news_id}
                    {continue}
                {/if}
                {assign var="detail_url" value="`$news.slug`.`$news.news_id`"}
                <article class="post post-medium">
                    <div class="row mb-3">
                        <div class="col-lg-5">
                            <div class="post-image">
                                <a href="{site_url($detail_url)}">
                                    <img src="{if !empty($news.images.root)}{image_url($news.images.root)}{else}{image_url($news.images.robot)}{/if}" class="img-fluid img-thumbnail img-thumbnail-no-borders rounded-0" alt="{$news.name|unescape:"html"}" />
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="post-content">
                                <h2 class="font-weight-semibold pt-4 pt-lg-0 text-5 line-height-4 mb-2"><a href="{site_url($detail_url)}">{$news.name|unescape:"html"}</a></h2>
                                <p class="mb-0">{$news.description|unescape:"html"}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="post-meta">
                                <span><i class="far fa-calendar-alt"></i> January 10, 2017 </span>
                                <span><i class="far fa-user"></i> By <a href="#">John Doe</a> </span>
                                <span><i class="far fa-folder"></i> <a href="#">Lifestyle</a>, <a href="#">Design</a> </span>
                                <span><i class="far fa-comments"></i> <a href="#">12 Comments</a></span>
                            </div>
                        </div>
                    </div>
                </article>
            {/foreach}
        </div>
    </article>
</div>
