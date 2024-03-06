<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Fire_Truck_Center
 */

?>

	<footer class="footer">
		<div class="footer__container main-container">
            <div class="footer__brand">
                <img src="<?php echo get_template_directory_uri(); ?>/img/footer/logo-desctop.svg" alt="">
            </div>
            <div class="footer__nav">
                <div class="footer__nav-column">
                    <div class="footer__nav-head">
                        Quick links
                    </div>
                    <ul class="footer__nav-list">
                        <li class="footer__nav-item"><a class="footer__nav-lnk" href="<?php echo home_url(); ?>">Home</a></li>
                        <li class="footer__nav-item"><a class="footer__nav-lnk" href="<?php echo get_permalink(16); ?>">Contact Us</a></li>
                        <li class="footer__nav-item"><a class="footer__nav-lnk" href="<?php echo get_permalink(18); ?>">Sell Your Truck</a></li>
                        <li class="footer__nav-item"><a class="footer__nav-lnk" href="<?php echo get_permalink(60); ?>">View Available Trucks</a></li>
<!--                        <li class="footer__nav-item"><a class="footer__nav-lnk" href="#">Privacy Policy</a></li>-->
                    </ul>
                </div>
                <div class="footer__nav-column">
                    <div class="footer__nav-head">
                        Apparatus Type
                    </div>
                    <ul class="footer__nav-list">
                        <li class="footer__nav-item"><a class="footer__nav-lnk" href="https://firetruck.center/search-all-for-sale/?_sft_equipment_type=engine-pumpers">Engines & Pumpers</a></li>
                        <li class="footer__nav-item"><a class="footer__nav-lnk" href="https://firetruck.center/search-all-for-sale/?_sft_equipment_type=wildland-brush-trucks">Wildland & Brush</a></li>
                        <li class="footer__nav-item"><a class="footer__nav-lnk" href="https://firetruck.center/search-all-for-sale/?_sft_equipment_type=tanks">Tanks</a></li>
                        <li class="footer__nav-item"><a class="footer__nav-lnk" href="https://firetruck.center/search-all-for-sale/?_sft_equipment_type=aerials">Aerials</a></li>
                        <li class="footer__nav-item"><a class="footer__nav-lnk" href="https://firetruck.center/search-all-for-sale/?_sft_equipment_type=rescues">Rescues</a></li>
                        <li class="footer__nav-item"><a class="footer__nav-lnk" href="https://globalemergencyvehicles.com" target="_blank">Ambulances</a></li>
                    </ul>
                </div>
<!--                <div class="footer__nav-column">-->
<!--                    <div class="footer__nav-head">-->
<!--                        Inventory-->
<!--                    </div>-->
<!--                    <ul class="footer__nav-list">-->
<!--                        <li class="footer__nav-item"><a class="footer__nav-lnk" href="#">Jaws of Life and Reels</a></li>-->
<!--                        <li class="footer__nav-item"><a class="footer__nav-lnk" href="#">SCBA / Air Bottles</a></li>-->
<!--                        <li class="footer__nav-item"><a class="footer__nav-lnk" href="#">SKID / CAFS Units</a></li>-->
<!--                        <li class="footer__nav-item"><a class="footer__nav-lnk" href="#">Loose and Misc Equipment</a></li>-->
<!--                        <li class="footer__nav-item"><a class="footer__nav-lnk" href="#">AFE Torpedo Nozzle</a></li>-->
<!--                    </ul>-->
<!--                </div>-->
                <div class="footer__nav-column">
                    <div class="footer__nav-head">
                        Contact
                    </div>
                    <ul class="footer__nav-list footer__nav-contacts">
                        <li class="footer__nav-item">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8 7.33331C8.55228 7.33331 9 6.8856 9 6.33331C9 5.78103 8.55228 5.33331 8 5.33331C7.44772 5.33331 7 5.78103 7 6.33331C7 6.8856 7.44772 7.33331 8 7.33331Z" fill="#828282"/>
                                <path d="M8.00002 1.33331C6.59472 1.33324 5.24619 1.88782 4.24752 2.87651C3.24884 3.8652 2.68074 5.20809 2.66669 6.61331C2.66669 10.2666 7.36669 14.3333 7.56669 14.5066C7.68744 14.6099 7.84112 14.6667 8.00002 14.6667C8.15892 14.6667 8.3126 14.6099 8.43335 14.5066C8.66669 14.3333 13.3334 10.2666 13.3334 6.61331C13.3193 5.20809 12.7512 3.8652 11.7525 2.87651C10.7538 1.88782 9.40532 1.33324 8.00002 1.33331ZM8.00002 8.66665C7.53853 8.66665 7.0874 8.5298 6.70369 8.27341C6.31997 8.01702 6.02091 7.6526 5.8443 7.22624C5.6677 6.79988 5.62149 6.33072 5.71152 5.8781C5.80155 5.42548 6.02378 5.00972 6.3501 4.6834C6.67643 4.35707 7.09219 4.13485 7.54481 4.04481C7.99743 3.95478 8.46659 4.00099 8.89295 4.17759C9.31931 4.3542 9.68373 4.65327 9.94012 5.03698C10.1965 5.4207 10.3334 5.87182 10.3334 6.33331C10.3334 6.95215 10.0875 7.54564 9.64994 7.98323C9.21235 8.42081 8.61886 8.66665 8.00002 8.66665Z" fill="#828282"/>
                            </svg>
                            <span>1991 Hartel Ave<br>Levitttown, PA 19057</span>
                        </li>
                        <li class="footer__nav-item">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.9664 10.8226C12.1367 10.0786 11.2947 9.62788 10.4752 10.3708L9.98586 10.8198C9.62784 11.1457 8.96217 12.6686 6.38847 9.56438C3.81531 6.46405 5.34656 5.98133 5.70512 5.6582L6.19713 5.20864C7.01233 4.46404 6.70469 3.52669 6.11674 2.56181L5.76193 1.97737C5.1713 1.01474 4.52814 0.382534 3.7108 1.12601L3.26916 1.53062C2.90792 1.80654 1.89817 2.70342 1.65323 4.40728C1.35845 6.45169 2.28835 8.79281 4.41881 11.3615C6.54658 13.9314 8.62987 15.2222 10.6033 15.1997C12.2433 15.1812 13.2338 14.2584 13.5436 13.9229L13.9868 13.5178C14.802 12.7748 14.2955 12.0184 13.4653 11.2727L12.9664 10.8226Z" fill="#828282"/>
                            </svg>
                            <a class="footer__nav-lnk" href="tel:2155599119">
                                (215) 559-9119
                            </a>
                        </li>
                        <li class="footer__nav-item">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.6666 5.02332V11.3333C14.6667 11.8435 14.4718 12.3343 14.1218 12.7055C13.7718 13.0767 13.2932 13.3001 12.784 13.33L12.6666 13.3333H3.33331C2.82317 13.3333 2.3323 13.1384 1.96114 12.7885C1.58998 12.4385 1.36657 11.9599 1.33665 11.4506L1.33331 11.3333V5.02332L7.62998 9.22132L7.70731 9.26532C7.79845 9.30984 7.89855 9.33299 7.99998 9.33299C8.10141 9.33299 8.20151 9.30984 8.29265 9.26532L8.36998 9.22132L14.6666 5.02332Z" fill="#828282"/>
                                <path d="M12.6667 2.66669C13.3867 2.66669 14.018 3.04669 14.37 3.61802L8 7.86469L1.63 3.61802C1.79716 3.34653 2.02681 3.11895 2.29981 2.95428C2.57281 2.7896 2.88123 2.69259 3.19934 2.67135L3.33334 2.66669H12.6667Z" fill="#828282"/>
                            </svg>
                            <a class="footer__nav-lnk" href="mailto:Vitaly.s@globalemergencyvehicles.com">
                                help@firetruck.center
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer__copyright">
                Copyright © <?php echo date('Y');?> Fire Center   |   All rights reserved.
            </div>
		</div>
	</footer>
    <div class="popup" style="display: none">
        <div class="popup__container">
            Your message was sent.
        </div>
    </div>
    <div class="popup-truck" style="display: none">
        <div class="popup-truck__container">
            <div class="popup-truck__close">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 2.5C10.25 2.5 2.5 10.25 2.5 20C2.5 29.75 10.25 37.5 20 37.5C29.75 37.5 37.5 29.75 37.5 20C37.5 10.25 29.75 2.5 20 2.5ZM26.75 28.75L20 22L13.25 28.75L11.25 26.75L18 20L11.25 13.25L13.25 11.25L20 18L26.75 11.25L28.75 13.25L22 20L28.75 26.75L26.75 28.75Z" fill="#C92D36"/>
                </svg>
            </div>
            <div class="popup-truck__wrapper">

            </div>
        </div>
    </div>
<?php wp_footer(); ?>

</body>
</html>
