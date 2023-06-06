<div class="container">
				<header class="content-header">
                <figure class="blog-banner">
						<a href="#"><img class="img-fluid" src="<?php the_post_thumbnail_url(); ?>" alt="image"></a>
						
					</figure>
					<div class="meta mb-3">
                        <span class="date">Published on: <?php the_date(); ?></span>
                    <?php 
                        the_tags('<span class="tag"><i class="fa fa-tag"></i>', 
                        '</span><span class="tag"><i class="fa fa-tag"></i>','</span>');
                    ?>
                   
                    <span class="comment">
                        <a href="#comments">
                            <i class='fa fa-comment'></i>
                             <?php comments_number(); ?>
                            </a>
                        </span>
                </div>
				</header>
<?php 

the_content();

?>
<?php 
comments_template();
?>
</div>