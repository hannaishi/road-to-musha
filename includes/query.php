<?php

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

        // おすすめ記事のIDを取得
        $recommend_ids = get_posts(
            [
                'post_type'      => 'post',
                'post_status'    => 'publish',
                'posts_per_page' => 1,
                'fields'         => 'ids',
                'meta_query'     => [
                    [
                        'key'     => 'is_recommend',
                        'value'   => '1',
                        'compare' => '=',
                    ],
                ],
            ]
        );

        // おすすめ記事を一覧から除外
        if (! empty($recommend_ids)) {
            $query->set('post__not_in', $recommend_ids);
        }
    }

    // 検索結果は投稿のみに限定
    if ($query->is_search()) {
        $query->set('post_type', 'post');
    }
}

add_action('pre_get_posts', 'road_to_musha_adjust_main_query');
