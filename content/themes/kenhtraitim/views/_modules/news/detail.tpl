<div class="blog-posts single-post">
    <article class="post post-large blog-single-post border-0 m-0 p-0">
        <div class="post-image ml-0">
            <a href="blog-post.html">
                <img src="img/blog/wide/blog-11.jpg" class="img-fluid img-thumbnail img-thumbnail-no-borders rounded-0" alt="" />
            </a>
        </div>
        <div class="post-content ml-0">
            <h2 class="font-weight-bold"><a href="blog-post.html">{$detail.name|unescape:"html"}</a></h2>
            <div class="post-meta">
                <span><i class="far fa-user"></i> RSS: <a href="{$detail.source}" target="_blank" title="{$detail.source}">{$detail.source|truncate:70:"...":true}</a> </span>
                {if !empty($detail.tags)}
                    <span>
                        <i class="far fa-folder"></i>
                        {foreach explode(',', $detail.tags) as $tag}
                            <a href="{base_url()}tags/{$tag}">{$tag}</a>
                        {/foreach}
                    </span>
                {/if}
{*                    <span><i class="far fa-comments"></i> <a href="#">12 Comments</a></span>*}
            </div>
            <div>
                {$detail.content|unescape:"html"}
            </div>

            <div class="post-block mt-5 post-share">
                <h4 class="mb-3">Share this Post</h4>
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

            <div class="post-block mt-4 pt-2 post-author">
                <h4 class="mb-3">Author</h4>
                <div class="img-thumbnail img-thumbnail-no-borders d-block pb-3">
                    <a href="blog-post.html">
                        <img src="img/avatars/avatar.jpg" alt="">
                    </a>
                </div>
                <p><strong class="name"><a href="#" class="text-4 pb-2 pt-2 d-block">John Doe</a></strong></p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae. Sed dui lorem, adipiscing in adipiscing et, interdum nec metus. Mauris ultricies, justo eu convallis placerat, felis enim ornare nisi, vitae mattis nulla ante id dui. </p>
            </div>

            <div id="comments" class="post-block mt-5 post-comments">
                <h4 class="mb-3">Comments (3)</h4>

                <ul class="comments">
                    <li>
                        <div class="comment">
                            <div class="img-thumbnail img-thumbnail-no-borders d-none d-sm-block">
                                <img class="avatar" alt="" src="img/avatars/avatar-2.jpg">
                            </div>
                            <div class="comment-block">
                                <div class="comment-arrow"></div>
                                <span class="comment-by">
                                                            <strong>John Doe</strong>
                                                            <span class="float-right">
                                                                <span> <a href="#"><i class="fas fa-reply"></i> Reply</a></span>
                                                            </span>
                                                        </span>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae, gravida pellentesque urna varius vitae. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae. Sed dui lorem, adipiscing in adipiscing et, interdum nec metus. Mauris ultricies, justo eu convallis placerat, felis enim ornare nisi, vitae mattis nulla ante id dui.</p>
                                <span class="date float-right">November 12, 2018 at 1:38 pm</span>
                            </div>
                        </div>

                        <ul class="comments reply">
                            <li>
                                <div class="comment">
                                    <div class="img-thumbnail img-thumbnail-no-borders d-none d-sm-block">
                                        <img class="avatar" alt="" src="img/avatars/avatar-3.jpg">
                                    </div>
                                    <div class="comment-block">
                                        <div class="comment-arrow"></div>
                                        <span class="comment-by">
                                                                    <strong>John Doe</strong>
                                                                    <span class="float-right">
                                                                        <span> <a href="#"><i class="fas fa-reply"></i> Reply</a></span>
                                                                    </span>
                                                                </span>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae, gravida pellentesque urna varius vitae.</p>
                                        <span class="date float-right">November 12, 2018 at 1:38 pm</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="comment">
                                    <div class="img-thumbnail img-thumbnail-no-borders d-none d-sm-block">
                                        <img class="avatar" alt="" src="img/avatars/avatar-4.jpg">
                                    </div>
                                    <div class="comment-block">
                                        <div class="comment-arrow"></div>
                                        <span class="comment-by">
                                                                    <strong>John Doe</strong>
                                                                    <span class="float-right">
                                                                        <span> <a href="#"><i class="fas fa-reply"></i> Reply</a></span>
                                                                    </span>
                                                                </span>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae, gravida pellentesque urna varius vitae.</p>
                                        <span class="date float-right">November 12, 2018 at 1:38 pm</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <div class="comment">
                            <div class="img-thumbnail img-thumbnail-no-borders d-none d-sm-block">
                                <img class="avatar" alt="" src="img/avatars/avatar.jpg">
                            </div>
                            <div class="comment-block">
                                <div class="comment-arrow"></div>
                                <span class="comment-by">
                                                            <strong>John Doe</strong>
                                                            <span class="float-right">
                                                                <span> <a href="#"><i class="fas fa-reply"></i> Reply</a></span>
                                                            </span>
                                                        </span>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                <span class="date float-right">November 12, 2018 at 1:38 pm</span>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="comment">
                            <div class="img-thumbnail img-thumbnail-no-borders d-none d-sm-block">
                                <img class="avatar" alt="" src="img/avatars/avatar.jpg">
                            </div>
                            <div class="comment-block">
                                <div class="comment-arrow"></div>
                                <span class="comment-by">
                                                            <strong>John Doe</strong>
                                                            <span class="float-right">
                                                                <span> <a href="#"><i class="fas fa-reply"></i> Reply</a></span>
                                                            </span>
                                                        </span>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                <span class="date float-right">November 12, 2018 at 1:38 pm</span>
                            </div>
                        </div>
                    </li>
                </ul>

            </div>

            <div class="post-block mt-5 post-leave-comment">
                <h4 class="mb-3">Leave a comment</h4>

                <form id="contactForm" class="contact-form p-4 rounded bg-color-grey" action="php/contact-form.php" method="POST">
                    <div class="p-2">
                        <div class="form-row">
                            <div class="form-group col-lg-6">
                                <label class="required font-weight-bold text-dark">Full Name</label>
                                <input type="text" value="" data-msg-required="Please enter your name." maxlength="100" class="form-control" name="name" id="name" required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="required font-weight-bold text-dark">Email Address</label>
                                <input type="email" value="" data-msg-required="Please enter your email address." data-msg-email="Please enter a valid email address." maxlength="100" class="form-control" name="email" id="email" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label class="required font-weight-bold text-dark">Comment</label>
                                <textarea maxlength="5000" data-msg-required="Please enter your message." rows="8" class="form-control" name="message" id="message" required></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col mb-0">
                                <input type="submit" value="Post Comment" class="btn btn-primary btn-modern" data-loading-text="Loading...">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </article>
</div>
