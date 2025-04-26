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
            <div class="footer__brand-soc">
                <a href="<?php echo get_field('facebook', 'options');?>">
                    <svg width="104" height="103" viewBox="0 0 104 103" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M103.056 51.3509C103.056 79.5187 80.0599 102.352 51.6917 102.352C23.3261 102.35 0.330078 79.5161 0.330078 51.3509C0.330078 23.1831 23.3261 0.349609 51.6943 0.349609C80.0625 0.349609 103.058 23.1831 103.058 51.3509H103.056Z" fill="#C92D36"/>
                        <path d="M66.911 47.3932L66.0552 54.2163C65.9105 55.3561 64.9384 56.2135 63.7854 56.2135H52.6558V84.7406C51.4821 84.8459 50.2928 84.8998 49.0907 84.8998C46.402 84.8998 43.7779 84.6328 41.2418 84.1245V56.2135H32.682C31.896 56.2135 31.2549 55.5743 31.2549 54.7913V46.2535C31.2549 45.4705 31.896 44.8314 32.682 44.8314H41.2418V32.0271C41.2418 24.1695 47.63 17.8008 55.5125 17.8008H65.4994C66.2853 17.8008 66.9265 18.44 66.9265 19.2229V27.7608C66.9265 28.5437 66.2853 29.1829 65.4994 29.1829H58.3641C55.2126 29.1829 52.6584 31.7294 52.6584 34.8739V44.8339H64.6437C66.019 44.8339 67.0816 46.0353 66.9136 47.3958L66.911 47.3932Z" fill="white"/>
                    </svg>
                </a>
                <a href="<?php echo get_field('instagram', 'options');?>">
                    <svg width="104" height="103" viewBox="0 0 104 103" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M103.239 51.3509C103.239 79.5187 80.2432 102.352 51.875 102.352C23.5068 102.352 0.510742 79.5187 0.510742 51.3509C0.510742 23.1831 23.5068 0.349609 51.875 0.349609C80.2432 0.349609 103.239 23.1831 103.239 51.3509Z" fill="#C92D36"/>
                        <path d="M65.8119 24.5977H37.9401C30.7582 24.5977 24.9336 30.3811 24.9336 37.5123V65.1872C24.9336 72.3183 30.7582 78.1018 37.9401 78.1018H65.8119C72.9938 78.1018 78.8185 72.3183 78.8185 65.1872V37.5123C78.8185 30.3811 72.9938 24.5977 65.8119 24.5977ZM74.1727 64.2656C74.1727 69.3585 70.0104 73.4914 64.8812 73.4914H38.8682C33.739 73.4914 29.5768 69.3585 29.5768 64.2656V38.4364C29.5768 33.3434 33.739 29.2106 38.8682 29.2106H64.8812C70.0104 29.2106 74.1727 33.3434 74.1727 38.4364V64.2656Z" fill="white"/>
                        <path d="M51.9005 37.5117C44.2093 37.5117 37.9658 43.711 37.9658 51.3479C37.9658 58.9847 44.2093 65.184 51.9005 65.184C59.5916 65.184 65.8351 58.9847 65.8351 51.3479C65.8351 43.711 59.5916 37.5117 51.9005 37.5117ZM51.9005 60.5737C46.7816 60.5737 42.609 56.4306 42.609 51.3479C42.609 46.2652 46.7816 42.1221 51.9005 42.1221C57.0193 42.1221 61.1919 46.2652 61.1919 51.3479C61.1919 56.4306 57.0193 60.5737 51.9005 60.5737Z" fill="white"/>
                        <path d="M66.7664 39.3587C65.2308 39.3587 63.9795 38.1163 63.9795 36.5915C63.9795 35.0666 65.2308 33.8242 66.7664 33.8242C68.3021 33.8242 69.5534 35.0666 69.5534 36.5915C69.5534 38.1163 68.3021 39.3587 66.7664 39.3587Z" fill="white"/>
                    </svg>
                </a>
                <a href="<?php echo get_field('youtube', 'options');?>">
                    <svg width="104" height="103" viewBox="0 0 104 103" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M103.33 51.3509C103.33 79.5187 80.334 102.352 51.9658 102.352C23.5976 102.352 0.601562 79.5187 0.601562 51.3509C0.601562 23.1831 23.5976 0.349609 51.9658 0.349609C80.334 0.349609 103.33 23.1831 103.33 51.3509Z" fill="#C92D36"/>
                        <path d="M74.1036 29.7402H29.8334C25.4591 29.7402 21.9121 33.2622 21.9121 37.603V65.0956C21.9121 69.439 25.4591 72.9584 29.8334 72.9584H74.1036C78.4753 72.9584 82.0223 69.439 82.0223 65.0956V37.603C82.0223 33.2622 78.4753 29.7402 74.1036 29.7402ZM59.078 53.2489L46.7669 59.3584C45.345 60.0643 43.6749 59.04 43.6749 57.4639V45.245C43.6749 43.6688 45.3476 42.6446 46.7669 43.3479L59.078 49.4574C60.6498 50.2378 60.6498 52.4685 59.078 53.2489Z" fill="white"/>
                    </svg>
                </a>
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
						<li class="footer__nav-item"><a class="footer__nav-lnk" href="https://firetruck.center/custom-built-brush-trucks/">Custom Brush Trucks</a></li>
<!--                        <li class="footer__nav-item"><a class="footer__nav-lnk" href="#">Privacy Policy</a></li>-->
                    </ul>
                </div>
                <div class="footer__nav-column">
                    <div class="footer__nav-head">
                        Apparatus Type
                    </div>
                    <ul class="footer__nav-list">
                        <li class="footer__nav-item"><a class="footer__nav-lnk" href="https://firetruck.center/search-all-for-sale?_sft_equipment_type=pumper">Engines & Pumpers</a></li>
                        <li class="footer__nav-item"><a class="footer__nav-lnk" href="https://firetruck.center/search-all-for-sale/?_sft_equipment_type=wildland-brush-trucks">Wildland & Brush</a></li>
                        <li class="footer__nav-item"><a class="footer__nav-lnk" href="https://firetruck.center/search-all-for-sale/?_sft_equipment_type=tanks">Tanks</a></li>
                        <li class="footer__nav-item"><a class="footer__nav-lnk" href="https://firetruck.center/search-all-for-sale/?_sft_equipment_type=aerials">Aerials</a></li>
                        <li class="footer__nav-item"><a class="footer__nav-lnk" href="https://firetruck.center/search-all-for-sale/?_sft_equipment_type=rescues">Rescues</a></li>
						<li class="footer__nav-item"><a class="footer__nav-lnk" href="https://firetruck.center/search-all-for-sale/?_sft_equipment_type=cafs-dry-chem-arff">CAFS/Dry Chem /ARFF</a></li>
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
    <div class="footer__callback">
        <a href="tel:+12155599119" class="footer__callback-btn">
            <img alt="" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiI+PHBhdGggZD0iTTI3LjAxMzU1LDIzLjQ4ODU5bC0xLjc1MywxLjc1MzA1YTUuMDAxLDUuMDAxLDAsMCwxLTUuMTk5MjgsMS4xODI0M2MtMS45NzE5My0uNjkzNzItNC44NzMzNS0yLjM2NDM4LTguNDM4NDgtNS45Mjk1UzYuMzg3LDE0LjAyOCw1LjY5MzMsMTIuMDU2MTVBNS4wMDA3OCw1LjAwMDc4LDAsMCwxLDYuODc1NzMsNi44NTY4N0w4LjYyODc4LDUuMTAzNzZhMSwxLDAsMCwxLDEuNDE0MzEuMDAwMTJsMi44MjgsMi44Mjg4QTEsMSwwLDAsMSwxMi44NzEsOS4zNDY4TDExLjA2NDcsMTEuMTUzYTEuMDAzOCwxLjAwMzgsMCwwLDAtLjA4MjEsMS4zMjE3MSw0MC43NDI3OCw0MC43NDI3OCwwLDAsMCw0LjA3NjI0LDQuNTgzNzQsNDAuNzQxNDMsNDAuNzQxNDMsMCwwLDAsNC41ODM3NCw0LjA3NjIzLDEuMDAzNzksMS4wMDM3OSwwLDAsMCwxLjMyMTcxLS4wODIwOWwxLjgwNjIyLTEuODA2MjdhMSwxLDAsMCwxLDEuNDE0MTItLjAwMDEybDIuODI4OCwyLjgyOEExLjAwMDA3LDEuMDAwMDcsMCwwLDEsMjcuMDEzNTUsMjMuNDg4NTlaIiBmaWxsPSIjZmZmZmZmIi8+PC9zdmc+" width="40">
            CALL US NOW
        </a>
    </div>
<?php wp_footer(); ?>

</body>
</html>
