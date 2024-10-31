<div id="onionbuzz_loader" class="loader loader-default "></div>
<div class="laqm-top">
    <ul class="laqm-menu-top">
        <li><a class="<?=($data['current_menu_top'] == 'quizzes')?'active':''?>" href="?page=la_onionbuzz_dashboard">Stories</a></li>
        <li><a class="<?=($data['current_menu_top'] == 'feeds')?'active':''?>" href="?page=la_onionbuzz_feeds">Feeds</a></li>
        <li><a class="<?=($data['current_menu_top'] == 'settings')?'active':''?>" href="?page=la_onionbuzz_settings">Settings</a></li>
        <li><a class="<?=($data['current_menu_top'] == 'advertising')?'active':''?> buy-pro-version" href="javascript:void(0);">Advertising<span class="icon-lock"></span></a></li>
        <li><a class="<?=($data['current_menu_top'] == 'help')?'active':''?>" href="http://onionbuzz.com/wordpress/docs/" target="_blank">Help</a></li>
        <li class="laqm-version"><span>OnionBuzz Lite  <?=$data['plugin_version']?></span></li>
    </ul>
</div>