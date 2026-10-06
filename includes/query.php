<?php

/**
 * Pickupメニューに登録されている投稿IDを取得する。
 *
 * @return int 投稿ID。未設定の場合は0。
 */
function road_to_musha_get_pickup_post_id()
{
    $locations = get_nav_menu_locations();

    if (empty($locations['pickup'])) {
        return 0;
    }

    $menu_items = wp_get_nav_menu_items(
        $locations['pickup']
    );

    if (empty($menu_items) || is_wp_error($menu_items)) {
        return 0;
    }

    foreach ($menu_items as $menu_item) {
        if (
            'post_type' === $menu_item->type &&
            'post' === $menu_item->object
        ) {
            $post_id = (int) $menu_item->object_id;

            if ('publish' === get_post_status($post_id)) {
                return $post_id;
            }
        }
    }

    return 0;
}

/**
 * 投稿一覧の表示件数・除外設定
 */
function road_to_musha_adjust_main_query($query)
{
    if (is_admin() || ! $query->is_main_query()) {
        return;
    }

    // カテゴリーアーカイブ
    if ($query->is_category()) {
        $query->set('posts_per_page', 12);
    }

    // トップページ
    if ($query->is_front_page()) {
        $query->set('posts_per_page', 12);

        // Pickup記事を一覧から除外する。
        $pickup_post_id = road_to_musha_get_pickup_post_id();

        if ($pickup_post_id) {
            $query->set(
                'post__not_in',
                [$pickup_post_id]
            );
        }
    }

    // 検索結果は投稿のみに限定
    if ($query->is_search()) {
        $query->set('post_type', 'post');
    }
}

add_action('pre_get_posts', 'road_to_musha_adjust_main_query');
