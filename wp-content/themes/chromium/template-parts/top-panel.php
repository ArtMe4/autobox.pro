<?php // Top Panel ?>


        <div class="header__top"><!-- Header top section -->
            <div class="site-content">
                <div class="row header__flex">
                    <div class="header__top-left col-md-9">
                        <?php if ( is_active_sidebar('top-sidebar-left') ) dynamic_sidebar( 'top-sidebar-left' ); ?>
                    </div>
                    <div class="header__top-right col-md-3">
                        <?php if ( is_active_sidebar('top-sidebar-right') ) dynamic_sidebar( 'top-sidebar-right' ); ?>
                    </div>
                </div>
            </div>
        </div><!-- end of Header top section -->



<!--	<div class="header-top">-->
<!--		<div class="top-widgets-left">-->
<!--			--><?php //if ( is_active_sidebar('top-sidebar-left') ) dynamic_sidebar( 'top-sidebar-left' ); ?>
<!--		</div>-->
<!--		<div class="top-widgets-right">-->
<!--			--><?php //if ( is_active_sidebar('top-sidebar-right') ) dynamic_sidebar( 'top-sidebar-right' ); ?>
<!--		</div>-->
<!--	</div>-->

