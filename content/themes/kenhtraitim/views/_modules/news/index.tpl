<div class="row pb-1 mt-4">

	<div class="col-lg-7 mb-4 pb-2">
		<a href="#">
			<article class="thumb-info thumb-info-no-borders thumb-info-bottom-info thumb-info-bottom-info-dark thumb-info-bottom-info-show-more thumb-info-no-zoom border-radius-0">
				<div class="thumb-info-wrapper thumb-info-wrapper-opacity-6">
					<img src="img/blog/default/blog-46.jpg" class="img-fluid" alt="How To Take Better Concert Pictures in 30 Seconds">
					<div class="thumb-info-title bg-transparent p-4">
						<div class="thumb-info-type bg-color-dark px-2 mb-1">Photography</div>
						<div class="thumb-info-inner mt-1">
							<h2 class="font-weight-bold text-color-light line-height-2 text-5 mb-0">How To Take Better Concert Pictures in 30 Seconds</h2>
						</div>
						<div class="thumb-info-show-more-content">
							<p class="mb-0 text-1 line-height-9 mb-1 mt-2 text-light opacity-5">Euismod atras vulputate iltricies etri elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
						</div>
					</div>
				</div>
			</article>
		</a>
	</div>
	<div class="col-lg-5">

		<article class="thumb-info thumb-info-side-image thumb-info-no-zoom bg-transparent border-radius-0 pb-4 mb-2">
			<div class="row align-items-center pb-1">
				<div class="col-sm-5">
					<a href="blog-post.html">
						<img src="img/blog/default/blog-55.jpg" class="img-fluid border-radius-0" alt="Simple Ways to Have a Pretty Face">
					</a>
				</div>
				<div class="col-sm-7 pl-sm-1">
					<div class="thumb-info-caption-text">
						<div class="thumb-info-type text-light text-uppercase d-inline-block bg-color-dark px-2 m-0 mb-1 float-none">
							<a href="blog-post.html" class="text-decoration-none text-color-light">Photography</a>
						</div>
						<h2 class="d-block line-height-2 text-4 text-dark font-weight-bold mt-1 mb-0">
							<a href="blog-post.html" class="text-decoration-none text-color-dark">Simple Ways to Have a Pretty Face</a>
						</h2>
					</div>
				</div>
			</div>
		</article>

		<article class="thumb-info thumb-info-side-image thumb-info-no-zoom bg-transparent border-radius-0 pb-4 mb-2">
			<div class="row align-items-center pb-1">
				<div class="col-sm-5">
					<a href="blog-post.html">
						<img src="img/blog/default/blog-56.jpg" class="img-fluid border-radius-0" alt="Ranking the greatest players in basketball">
					</a>
				</div>
				<div class="col-sm-7 pl-sm-1">
					<div class="thumb-info-caption-text">
						<div class="thumb-info-type text-light text-uppercase d-inline-block bg-color-dark px-2 m-0 mb-1 float-none">
							<a href="blog-post.html" class="text-decoration-none text-color-light">Sports</a>
						</div>
						<h2 class="d-block line-height-2 text-4 text-dark font-weight-bold mt-1 mb-0">
							<a href="blog-post.html" class="text-decoration-none text-color-dark">Ranking the greatest players in basketball</a>
						</h2>
					</div>
				</div>
			</div>
		</article>

		<article class="thumb-info thumb-info-side-image thumb-info-no-zoom bg-transparent border-radius-0 pb-4 mb-2">
			<div class="row align-items-center pb-1">
				<div class="col-sm-5">
					<a href="blog-post.html">
						<img src="img/blog/default/blog-57.jpg" class="img-fluid border-radius-0" alt="4 Ways to Look Cool in Glasses">
					</a>
				</div>
				<div class="col-sm-7 pl-sm-1">
					<div class="thumb-info-caption-text">
						<div class="thumb-info-type text-light text-uppercase d-inline-block bg-color-dark px-2 m-0 mb-1 float-none">
							<a href="blog-post.html" class="text-decoration-none text-color-light">Lifestyle</a>
						</div>
						<h2 class="d-block line-height-2 text-4 text-dark font-weight-bold mt-1 mb-0">
							<a href="blog-post.html" class="text-decoration-none text-color-dark">4 Ways to Look Cool in Glasses</a>
						</h2>
					</div>
				</div>
			</div>
		</article>
	</div>
</div>
<div class="row pb-1 pt-2">

	<div class="col-md-9">

		{foreach $list as $category}
			<div class="heading heading-border heading-middle-border">
				<h3 class="text-4"><strong class="font-weight-bold text-1 px-3 text-light py-2 bg-secondary">{$category.detail.name}</strong></h3>
			</div>

			<div class="row pb-1">

				{foreach $category.list as $news}
					{if $news@iteration == 1}
						<div class="col-lg-6 mb-4 pb-1">
							<article class="thumb-info thumb-info-side-image thumb-info-no-zoom bg-transparent border-radius-0 pb-2 mb-2">
								<div class="row">
									<div class="col">
										<a href="blog-post.html">
											<img src="{image_url($news.images.robot)}" class="img-fluid border-radius-0" alt="{$news.name}">
										</a>
									</div>
								</div>
								<div class="row">
									<div class="col">
										<div class="thumb-info-caption-text">
											<div class="d-inline-block text-default text-1 mt-2 float-none">
												<a href="blog-post.html" class="text-decoration-none text-color-default">{$news.publish_date}</a>
											</div>
											<h4 class="d-block line-height-2 text-4 text-dark font-weight-bold mb-0">
												<a href="blog-post.html" class="text-decoration-none text-color-dark">{$news.name}</a>
											</h4>
										</div>
									</div>
								</div>
							</article>
						</div>
						{break}
					{/if}
				{/foreach}

				<div class="col-lg-6">
					{foreach $category.list as $news}
						{if $news@iteration > 1}
						<article class="thumb-info thumb-info-side-image thumb-info-no-zoom bg-transparent border-radius-0 pb-4 mb-2">
							<div class="row align-items-center pb-1">
								<div class="col-sm-4">
									<a href="blog-post.html">
										<img src="{image_url($news.images.robot)}" class="img-fluid border-radius-0" alt="{$news.name}">
									</a>
								</div>
								<div class="col-sm-8 pl-sm-0">
									<div class="thumb-info-caption-text">
										<div class="d-inline-block text-default text-1 float-none">
											<a href="blog-post.html" class="text-decoration-none text-color-default">{$news.publish_date}</a>
										</div>
										<h4 class="d-block pb-2 line-height-2 text-3 text-dark font-weight-bold mb-0">
											<a href="blog-post.html" class="text-decoration-none text-color-dark">{$news.name}</a>
										</h4>
									</div>
								</div>
							</div>
						</article>
						{/if}
					{/foreach}
				</div>
			</div>
		{/foreach}

		<div class="text-center py-3 mb-4">
			<a href="http://themeforest.net/item/porto-responsive-html5-template/4106987" target="_blank" class="d-block">
				<img alt="Porto" class="img-fluid pl-3" src="img/blog/blog-ad-3.jpg" />
			</a>
		</div>

		<div class="row pb-1 pt-3">
			<div class="col-md-6">

				<h3 class="font-weight-bold text-3 mb-0">Popular Posts</h3>

				<ul class="simple-post-list">

					<li>
						<article>
							<div class="post-image">
								<div class="img-thumbnail img-thumbnail-no-borders d-block">
									<a href="blog-post.html">
										<img src="img/blog/square/blog-55.jpg" class="border-radius-0" width="50" height="50" alt="Simple Ways to Have a Pretty Face">
									</a>
								</div>
							</div>
							<div class="post-info">
								<div class="post-meta">
									January 12, 2019
								</div>
								<h4 class="font-weight-normal text-3 mb-0"><a href="blog-post.html" class="text-dark">Simple Ways to Have a Pretty Face</a></h4>
							</div>
						</article>
					</li>

					<li>
						<article>
							<div class="post-image">
								<div class="img-thumbnail img-thumbnail-no-borders d-block">
									<a href="blog-post.html">
										<img src="img/blog/square/blog-56.jpg" class="border-radius-0" width="50" height="50" alt="Ranking the greatest players in basketball">
									</a>
								</div>
							</div>
							<div class="post-info">
								<div class="post-meta">
									January 12, 2019
								</div>
								<h4 class="font-weight-normal text-3 mb-0"><a href="blog-post.html" class="text-dark">Ranking the greatest players in basketball</a></h4>
							</div>
						</article>
					</li>

					<li>
						<article>
							<div class="post-image">
								<div class="img-thumbnail img-thumbnail-no-borders d-block">
									<a href="blog-post.html">
										<img src="img/blog/square/blog-57.jpg" class="border-radius-0" width="50" height="50" alt="4 Ways to Look Cool in Glasses">
									</a>
								</div>
							</div>
							<div class="post-info">
								<div class="post-meta">
									January 12, 2019
								</div>
								<h4 class="font-weight-normal text-3 mb-0"><a href="blog-post.html" class="text-dark">4 Ways to Look Cool in Glasses</a></h4>
							</div>
						</article>
					</li>

					<li>
						<article>
							<div class="post-image">
								<div class="img-thumbnail img-thumbnail-no-borders d-block">
									<a href="blog-post.html">
										<img src="img/blog/square/blog-58.jpg" class="border-radius-0" width="50" height="50" alt="Top Camper Trailer Towing Tips">
									</a>
								</div>
							</div>
							<div class="post-info">
								<div class="post-meta">
									January 12, 2019
								</div>
								<h4 class="font-weight-normal text-3 mb-0"><a href="blog-post.html" class="text-dark">Top Camper Trailer Towing Tips</a></h4>
							</div>
						</article>
					</li>

					<li>
						<article>
							<div class="post-image">
								<div class="img-thumbnail img-thumbnail-no-borders d-block">
									<a href="blog-post.html">
										<img src="img/blog/square/blog-59.jpg" class="border-radius-0" width="50" height="50" alt="5 Lovely Walks in New York">
									</a>
								</div>
							</div>
							<div class="post-info">
								<div class="post-meta">
									January 12, 2019
								</div>
								<h4 class="font-weight-normal text-3 mb-0"><a href="blog-post.html" class="text-dark">5 Lovely Walks in New York</a></h4>
							</div>
						</article>
					</li>

					<li>
						<article>
							<div class="post-image">
								<div class="img-thumbnail img-thumbnail-no-borders d-block">
									<a href="blog-post.html">
										<img src="img/blog/square/blog-60.jpg" class="border-radius-0" width="50" height="50" alt="How to Become a Professional Photographer">
									</a>
								</div>
							</div>
							<div class="post-info">
								<div class="post-meta">
									January 12, 2019
								</div>
								<h4 class="font-weight-normal text-3 mb-0"><a href="blog-post.html" class="text-dark">How to Become a Professional Photographer</a></h4>
							</div>
						</article>
					</li>
				</ul>

			</div>
			<div class="col-md-6">

				<h3 class="font-weight-bold text-3 mb-0 mt-4 mt-md-0">Recent Posts</h3>

				<ul class="simple-post-list">

					<li>
						<article>
							<div class="post-image">
								<div class="img-thumbnail img-thumbnail-no-borders d-block">
									<a href="blog-post.html">
										<img src="img/blog/square/blog-64.jpg" class="border-radius-0" width="50" height="50" alt="Explained: How does VR actually work?">
									</a>
								</div>
							</div>
							<div class="post-info">
								<div class="post-meta">
									January 12, 2019
								</div>
								<h4 class="font-weight-normal text-3 mb-0"><a href="blog-post.html" class="text-dark">Explained: How does VR actually work?</a></h4>
							</div>
						</article>
					</li>

					<li>
						<article>
							<div class="post-image">
								<div class="img-thumbnail img-thumbnail-no-borders d-block">
									<a href="blog-post.html">
										<img src="img/blog/square/blog-65.jpg" class="border-radius-0" width="50" height="50" alt="Main Reasons To Stop Texting And Driving">
									</a>
								</div>
							</div>
							<div class="post-info">
								<div class="post-meta">
									January 12, 2019
								</div>
								<h4 class="font-weight-normal text-3 mb-0"><a href="blog-post.html" class="text-dark">Main Reasons To Stop Texting And Driving</a></h4>
							</div>
						</article>
					</li>

					<li>
						<article>
							<div class="post-image">
								<div class="img-thumbnail img-thumbnail-no-borders d-block">
									<a href="blog-post.html">
										<img src="img/blog/square/blog-66.jpg" class="border-radius-0" width="50" height="50" alt="Tips to Help You Quickly Prepare your Lunch">
									</a>
								</div>
							</div>
							<div class="post-info">
								<div class="post-meta">
									January 12, 2019
								</div>
								<h4 class="font-weight-normal text-3 mb-0"><a href="blog-post.html" class="text-dark">Tips to Help You Quickly Prepare your Lunch</a></h4>
							</div>
						</article>
					</li>

					<li>
						<article>
							<div class="post-image">
								<div class="img-thumbnail img-thumbnail-no-borders d-block">
									<a href="blog-post.html">
										<img src="img/blog/square/blog-67.jpg" class="border-radius-0" width="50" height="50" alt="Why should I buy a smartwatch?">
									</a>
								</div>
							</div>
							<div class="post-info">
								<div class="post-meta">
									January 12, 2019
								</div>
								<h4 class="font-weight-normal text-3 mb-0"><a href="blog-post.html" class="text-dark">Why should I buy a smartwatch?</a></h4>
							</div>
						</article>
					</li>

					<li>
						<article>
							<div class="post-image">
								<div class="img-thumbnail img-thumbnail-no-borders d-block">
									<a href="blog-post.html">
										<img src="img/blog/square/blog-68.jpg" class="border-radius-0" width="50" height="50" alt="The best augmented reality smartglasses">
									</a>
								</div>
							</div>
							<div class="post-info">
								<div class="post-meta">
									January 12, 2019
								</div>
								<h4 class="font-weight-normal text-3 mb-0"><a href="blog-post.html" class="text-dark">The best augmented reality smartglasses</a></h4>
							</div>
						</article>
					</li>

					<li>
						<article>
							<div class="post-image">
								<div class="img-thumbnail img-thumbnail-no-borders d-block">
									<a href="blog-post.html">
										<img src="img/blog/square/blog-69.jpg" class="border-radius-0" width="50" height="50" alt="12 Healthiest Foods to Eat for Breakfast">
									</a>
								</div>
							</div>
							<div class="post-info">
								<div class="post-meta">
									January 12, 2019
								</div>
								<h4 class="font-weight-normal text-3 mb-0"><a href="blog-post.html" class="text-dark">12 Healthiest Foods to Eat for Breakfast</a></h4>
							</div>
						</article>
					</li>
				</ul>

			</div>
		</div>

	</div>

	<div class="col-md-3">

		<h3 class="font-weight-bold text-3 pt-1">Featured Posts</h3>

		<div class="pb-2">

			<div class="mb-4 pb-2">
				<article class="thumb-info thumb-info-side-image thumb-info-no-zoom bg-transparent border-radius-0 pb-2 mb-2">
					<div class="row">
						<div class="col">
							<a href="blog-post.html">
								<img src="img/blog/default/blog-65.jpg" class="img-fluid border-radius-0" alt="Main Reasons To Stop Texting And Driving">
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="thumb-info-caption-text">
								<div class="d-inline-block text-default text-1 mt-2 float-none">
									<a href="blog-post.html" class="text-decoration-none text-color-default">January 12, 2019</a>
								</div>
								<h4 class="d-block line-height-2 text-4 text-dark font-weight-bold mb-0">
									<a href="blog-post.html" class="text-decoration-none text-color-dark">Main Reasons To Stop Texting And Driving</a>
								</h4>
							</div>
						</div>
					</div>
				</article>
			</div>

			<div class="mb-4 pb-2">
				<article class="thumb-info thumb-info-side-image thumb-info-no-zoom bg-transparent border-radius-0 pb-2 mb-2">
					<div class="row">
						<div class="col">
							<a href="blog-post.html">
								<img src="img/blog/default/blog-66.jpg" class="img-fluid border-radius-0" alt="Tips to Help You Quickly Prepare your Lunch">
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="thumb-info-caption-text">
								<div class="d-inline-block text-default text-1 mt-2 float-none">
									<a href="blog-post.html" class="text-decoration-none text-color-default">January 12, 2019</a>
								</div>
								<h4 class="d-block line-height-2 text-4 text-dark font-weight-bold mb-0">
									<a href="blog-post.html" class="text-decoration-none text-color-dark">Tips to Help You Quickly Prepare your Lunch</a>
								</h4>
							</div>
						</div>
					</div>
				</article>
			</div>
		</div>

		<aside class="sidebar pb-4">
			<h5 class="font-weight-bold">Latest from Twitter</h5>
			<div id="tweet" class="twitter mb-4" data-plugin-tweets data-plugin-options="{literal}{'username': 'oklerthemes', 'count': 2}{/literal}">
				<p>Please wait...</p>
			</div>
			<h5 class="font-weight-bold pt-4">Photos from Instagram</h5>
			<div id="instafeedNoMargins" class="mb-4 pb-1"></div>
			<h5 class="font-weight-bold pt-4 mb-2">Tags</h5>
			<div class="mb-3 pb-1">
				<a href="#"><span class="badge badge-dark badge-sm badge-pill text-uppercase px-2 py-1 mr-1">design</span></a>
				<a href="#"><span class="badge badge-dark badge-sm badge-pill text-uppercase px-2 py-1 mr-1">brands</span></a>
				<a href="#"><span class="badge badge-dark badge-sm badge-pill text-uppercase px-2 py-1 mr-1">video</span></a>
				<a href="#"><span class="badge badge-dark badge-sm badge-pill text-uppercase px-2 py-1 mr-1">business</span></a>
				<a href="#"><span class="badge badge-dark badge-sm badge-pill text-uppercase px-2 py-1 mr-1">travel</span></a>
			</div>
			<a href="http://themeforest.net/item/porto-responsive-html5-template/4106987" target="_blank" class="my-4 pt-3 d-block">
				<img alt="Porto" class="img-fluid" src="img/blog/blog-ad-1-medium.jpg" />
			</a>
			<h5 class="font-weight-bold pt-4">Find us on Facebook</h5>
			<div class="fb-page" data-href="https://www.facebook.com/OklerThemes/" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true"><blockquote cite="https://www.facebook.com/OklerThemes/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/OklerThemes/">Okler Themes</a></blockquote></div>
		</aside>

		<h5 class="font-weight-bold pt-1">Recent Comments</h5>

		<ul class="list-unstyled mb-4 pb-1 pt-2">

			<li class="pb-3 text-2">
				<a href="#" rel="external nofollow" class="font-weight-bold text-dark">John Doe</a> on <a href="blog-post.html" class="text-dark">Main Reasons To Stop Texting And Driving</a>
			</li>

			<li class="pb-3 text-2">
				<a href="#" rel="external nofollow" class="font-weight-bold text-dark">John Doe</a> on <a href="blog-post.html" class="text-dark">Tips to Help You Quickly Prepare your Lunch</a>
			</li>

			<li class="pb-3 text-2">
				<a href="#" rel="external nofollow" class="font-weight-bold text-dark">John Doe</a> on <a href="blog-post.html" class="text-dark">Why should I buy a smartwatch?</a>
			</li>

			<li class="pb-3 text-2">
				<a href="#" rel="external nofollow" class="font-weight-bold text-dark">John Doe</a> on <a href="blog-post.html" class="text-dark">The best augmented reality smartglasses</a>
			</li>

			<li class="pb-3 text-2">
				<a href="#" rel="external nofollow" class="font-weight-bold text-dark">John Doe</a> on <a href="blog-post.html" class="text-dark">12 Healthiest Foods to Eat for Breakfast</a>
			</li>
		</ul>

	</div>

</div>