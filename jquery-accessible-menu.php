<?php
/*
Plugin Name: JQuery Accessible Menu
Plugin URI: http://wordpress.org/extend/plugins/jquery-accessible-menu/
Description: WAI-ARIA Enabled Menu Plugin for Wordpress
Author: Kontotasiou Dionysia
Version: 3.0
Author URI: http://www.iti.gr/iti/people/Dionisia_Kontotasiou.html
*/
include_once 'getRecentPosts.php';
include_once 'getRecentComments.php';
include_once 'getCategories.php';
include_once 'getMeta.php';

add_action("plugins_loaded", "JQueryAccessibleMenu_init");
function JQueryAccessibleMenu_init() {
    register_sidebar_widget(__('JQuery Accessible Menu'), 'widget_JQueryAccessibleMenu', 400, 400);
    register_widget_control(   'JQuery Accessible Menu', 'JQueryAccessibleMenu_control', 200, 200 );
    if ( !is_admin() && is_active_widget('widget_JQueryAccessibleMenu') ) {
        wp_register_style('jquery.ui.all', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-menu/lib/jquery-ui/themes/base/jquery.ui.all.css'));
        wp_enqueue_style('jquery.ui.all');

        wp_deregister_script('jquery');

        // add your own script
        wp_register_script('jquery-1.6.4', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-menu/lib/jquery-ui/jquery-1.6.4.js'));
        wp_enqueue_script('jquery-1.6.4');

        wp_register_script('jquery.ui.core.js', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-menu/lib/jquery-ui/ui/jquery.ui.core.js'));
        wp_enqueue_script('jquery.ui.core.js');

        wp_register_script('jquery.ui.widget', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-menu/lib/jquery-ui/ui/jquery.ui.widget.js'));
        wp_enqueue_script('jquery.ui.widget');

        wp_register_script('jquery.ui.position', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-menu/lib/jquery-ui/ui/jquery.ui.position.js'));
        wp_enqueue_script('jquery.ui.position');

        wp_register_script('jquery.ui.button', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-menu/lib/jquery-ui/ui/jquery.ui.button.js'));
        wp_enqueue_script('jquery.ui.button');

        wp_register_script('jquery.ui.menu', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-menu/lib/jquery-ui/ui/jquery.ui.menu.js'));
        wp_enqueue_script('jquery.ui.menu');

        wp_register_style('demos', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-menu/lib/jquery-ui/demos.css'));
        wp_enqueue_style('demos');

        wp_register_script('jquery-accessible-menu', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-menu/lib/jquery-accessible-menu.js'));
        wp_enqueue_script('jquery-accessible-menu');
    }
}

function widget_JQueryAccessibleMenu($args) {
    extract($args);

    $options = get_option("widget_JQueryAccessibleMenu");
    if (!is_array( $options )) {
        $options = array(
                'title' => 'JQuery Accessible Menu',
            'categories' => 'Categories',
            'meta' => 'Meta',
            'recentPosts' => 'Recent Posts',
            'recentComments' => 'Recent Comments'
        );
    }

    echo $before_widget;
    echo $before_title;
    echo $options['title'];
    echo $after_title;

    //Our Widget Content
    JQueryAccessibleMenuContent();
    echo $after_widget;
}

function JQueryAccessibleMenuContent() {
    $recentPosts = get_recent_posts();
    $recentComments = get_recent_comments();
    $categories = get_my_categories();
    $meta = get_my_meta();

    $options = get_option("widget_JQueryAccessibleMenu");
    if (!is_array( $options )) {
        $options = array(
            'title' => 'JQuery Accessible Menu',
            'categories' => 'Categories',
            'meta' => 'Meta',
            'recentPosts' => 'Recent Posts',
            'recentComments' => 'Recent Comments'
        );
    }
    echo '<div class="demo" role="application">
        <ul id="menubar" class="menubar" aria-label="Sample Options">
                <li><a href="#">' . $options['recentPosts'] . '</a>
                    <ul aria-label="Recent Posts">
                        ' . $recentPosts . '
                    </ul>
                </li>
                <li>
                    <a href="#">' . $options['recentComments'] . '</a>
                    <ul aria-label="Recent Comments">
                        ' . $recentComments . '
                    </ul>
                </li>
                <li>
                    <a href="#">' . $options['categories'] . '</a>
                    <ul aria-label="Categories">
                        ' . $categories . '
                    </ul>
                </li>
                <li><a href="#">' . $options['meta'] . '</a>
                    <ul aria-label="Meta">
                        ' . $meta . '
                    </ul>
                </li>
            </ul>

</div>';
}

function JQueryAccessibleMenu_control() {
    $options = get_option("widget_JQueryAccessibleMenu");
    if (!is_array( $options )) {
        $options = array(
                'title' => 'JQuery Accessible Menu',
            'categories' => 'Categories',
            'meta' => 'Meta',
            'recentPosts' => 'Recent Posts',
            'recentComments' => 'Recent Comments'
        );
    }

    if ($_POST['JQueryAccessibleMenu-SubmitTitle']) {
        $options['title'] = htmlspecialchars($_POST['JQueryAccessibleMenu-WidgetTitle']);
        update_option("widget_JQueryAccessibleMenu", $options);
    }
    if ($_POST['JQueryAccessibleMenu-SubmitCategories']) {
        $options['categories'] = htmlspecialchars($_POST['JQueryAccessibleMenu-WidgetCategories']);
        update_option("widget_JQueryAccessibleMenu", $options);
    }
    if ($_POST['JQueryAccessibleMenu-SubmitMeta']) {
        $options['meta'] = htmlspecialchars($_POST['JQueryAccessibleMenu-WidgetMeta']);
        update_option("widget_JQueryAccessibleMenu", $options);
    }
    if ($_POST['JQueryAccessibleMenu-SubmitRecentPosts']) {
        $options['recentPosts'] = htmlspecialchars($_POST['JQueryAccessibleMenu-WidgetRecentPosts']);
        update_option("widget_JQueryAccessibleMenu", $options);
    }
    if ($_POST['JQueryAccessibleMenu-SubmitRecentComments']) {
        $options['recentComments'] = htmlspecialchars($_POST['JQueryAccessibleMenu-WidgetRecentComments']);
        update_option("widget_JQueryAccessibleMenu", $options);
    }
    ?>
    <p>
        <label for="JQueryAccessibleMenu-WidgetTitle">Widget Title: </label>
        <input type="text" id="JQueryAccessibleMenu-WidgetTitle" name="JQueryAccessibleMenu-WidgetTitle" value="<?php echo $options['title'];?>" />
        <input type="hidden" id="JQueryAccessibleMenu-SubmitTitle" name="JQueryAccessibleMenu-SubmitTitle" value="1" />
    </p>
    <p>
        <label for="JQueryAccessibleMenu-WidgetCategories">Translation for "Categories": </label>
        <input type="text" id="JQueryAccessibleMenu-WidgetCategories" name="JQueryAccessibleMenu-WidgetCategories" value="<?php echo $options['categories'];?>" />
        <input type="hidden" id="JQueryAccessibleMenu-SubmitCategories" name="JQueryAccessibleMenu-SubmitCategories" value="1" />
    </p>
    <p>
        <label for="JQueryAccessibleMenu-WidgetMeta">Translation for "Meta": </label>
        <input type="text" id="JQueryAccessibleMenu-WidgetMeta" name="JQueryAccessibleMenu-WidgetMeta" value="<?php echo $options['meta'];?>" />
        <input type="hidden" id="JQueryAccessibleMenu-SubmitMeta" name="JQueryAccessibleMenu-SubmitMeta" value="1" />
    </p>
    <p>
        <label for="JQueryAccessibleMenu-WidgetRecentPosts">Translation for "Recent Posts": </label>
        <input type="text" id="JQueryAccessibleMenu-WidgetRecentPosts" name="JQueryAccessibleMenu-WidgetRecentPosts" value="<?php echo $options['recentPosts'];?>" />
        <input type="hidden" id="JQueryAccessibleMenu-SubmitRecentPosts" name="JQueryAccessibleMenu-SubmitRecentPosts" value="1" />
    </p>
    <p>
        <label for="JQueryAccessibleMenu-WidgetRecentComments">Translation for "Recent Comments": </label>
        <input type="text" id="JQueryAccessibleMenu-WidgetRecentComments" name="JQueryAccessibleMenu-WidgetRecentComments" value="<?php echo $options['recentComments'];?>" />
        <input type="hidden" id="JQueryAccessibleMenu-SubmitRecentComments" name="JQueryAccessibleMenu-SubmitRecentComments" value="1" />
    </p>
    
    <?php
}

?>
