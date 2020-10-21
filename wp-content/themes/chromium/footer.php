<?php /* The Footer */ ?>
			<footer class="site-footer" role="contentinfo" itemscope="itemscope" itemtype="https://schema.org/WPFooter"><!-- Site's Footer -->

				<?php /* Get footer shortcode if exists */
				$footer_shortcode = get_theme_mod( 'footer_shortcode_section' );
				if ( $footer_shortcode && $footer_shortcode!='' ) {
					echo '<div class="pre-footer-shortcode">'. do_shortcode($footer_shortcode) .'</div>';
				} ?>

				<?php if ( is_active_sidebar( 'footer-sidebar-1' ) || is_active_sidebar( 'footer-sidebar-2' ) || is_active_sidebar( 'footer-sidebar-3' ) || is_active_sidebar( 'footer-sidebar-4' ) ) { ?>
				<aside class="footer-widgets"><!-- Footer's widgets -->
					<div class="widget-area col-1">
						<?php if ( is_active_sidebar( 'footer-sidebar-1' ) ) : ?>
							<?php dynamic_sidebar( 'footer-sidebar-1' ); ?>
						<?php endif; ?>
					</div>
					<div class="widget-area col-2">
						<?php if ( is_active_sidebar( 'footer-sidebar-2' ) ) : ?>
							<?php dynamic_sidebar( 'footer-sidebar-2' ); ?>
						<?php endif; ?>
					</div>
					<div class="widget-area col-3">
						<?php if ( is_active_sidebar( 'footer-sidebar-3' ) ) : ?>
							<?php dynamic_sidebar( 'footer-sidebar-3' ); ?>
						<?php endif; ?>
					</div>
					<div class="widget-area col-4">
						<?php if ( is_active_sidebar( 'footer-sidebar-4' ) ) : ?>
							<?php dynamic_sidebar( 'footer-sidebar-4' ); ?>
						<?php endif; ?>
                        <div class="dev-by">
                            <span class="dev-by__label">Создание и продвижение</span>
                            <a href="https://digitalaround.ru/" class="dev-by__link" target="_blank"
                                <?= $_SERVER['REQUEST_URI'] == '/' ? '' : 'rel="nofollow"'; ?>>
                                <img src="/wp-content/uploads/dev-by-da.svg" alt="Digital Around">
                            </a>
                        </div>
					</div>
				</aside><!-- end of Footer's widgets -->
				<?php } ?>

				<div class="site-info"><!-- Copyrights -->
					<?php /* Get copyright section text */
					$copy_text = get_theme_mod( 'copyright_section_text' );
					if ( $copy_text ) {
						echo apply_filters( 'chromium-copyright-label', esc_html__('Copyright ', 'chromium') ).'&copy;&nbsp;<span itemprop="copyrightYear">' . date("Y") . '</span>&nbsp;
									<span itemprop="copyrightHolder">' . wp_kses_post($copy_text) . '</span>';
					} else {
						echo '&copy;&nbsp;<span itemprop="copyrightYear">' . date("Y") . '</span>&nbsp;
									<span itemprop="copyrightHolder">Chromium Theme by <a href="//themes.zone" target="_blank" itemprop="url">Themes Zone</a></span>';
					} ?>
				</div><!-- end of Copyrights -->

			</footer><!-- end of Site's Footer -->

		</div><!-- end of Site's Wrapper -->

		<?php wp_footer(); ?>

        <!-- Yandex.Metrika counter -->
        <script type="text/javascript" >
            (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
                m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
            (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

            ym(65800849, "init", {
                clickmap:true,
                trackLinks:true,
                accurateTrackBounce:true,
                webvisor:true,
                ecommerce:"dataLayer"
            });
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/65800849" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->

        <script src="//cdn.callibri.ru/callibri.js" type="text/javascript" charset="utf-8"></script>

	</body>
</html>
